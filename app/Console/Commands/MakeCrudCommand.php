<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class MakeCrudCommand extends Command
{
    protected $signature = 'make:crud {model} {--fields=} {--relations=}';
    protected $description = 'Generate model, migration, controller, request, views, and routes';

    public function handle()
    {
        $modelInput = str_replace('/', '\\', $this->argument('model'));
        $modelName = class_basename($modelInput);
        $namespacePath = trim(Str::replaceFirst($modelName, '', $modelInput), '\\');

        $modelNamespace = $namespacePath ? 'App\\Models\\' . $namespacePath : 'App\\Models';
        $controllerNamespace = 'App\\Http\\Controllers' . ($namespacePath ? '\\' . $namespacePath : '');
        $requestNamespace = 'App\\Http\\Requests' . ($namespacePath ? '\\' . $namespacePath : '');
        $resourceNamespace = 'App\\Http\\Resources' . ($namespacePath ? '\\' . $namespacePath : '');

        $viewPath = collect(explode('\\', $modelInput))
            ->map(fn ($part, $i) => $i === 0
                ? Str::kebab(Str::plural(Str::snake($part))) // pluralize only the first (e.g. admin)
                : Str::kebab(Str::snake($part)))             // singular for model name (e.g. order)
            ->implode('.');
        $viewFolder = str_replace('.', '/', $viewPath); // used for folder structure

        $fields = $this->option('fields') ? $this->parseFields($this->option('fields')) : [];
        $relations = $this->option('relations') ? explode(',', $this->option('relations')) : [];

        $scopes = collect($fields)
            ->map(function ($field) {
                $fieldName = explode(':', $field)[0];
                return "->when(\$filters['$fieldName'] ?? null, fn(\$q, \$value) => \$q->where('$fieldName', \$value))";
            })->implode("\n        ");

        $modelVar = Str::camel($modelName);
        $pluralModelVar = Str::plural($modelVar);
        $tableName = Str::snake(Str::pluralStudly($modelName));

        $fillable = collect($fields)->map(fn($f) => "'" . explode(':', $f)[0] . "'")->implode(', ');
        $columns = collect($fields)->map(fn($f) => $this->generateColumn($f))->implode("\n            ");
        $rules = collect($fields)->map(fn($f) => $this->generateRule($f))->implode(",\n            ");
        $resourceFields = collect($fields)->map(fn($f) => "'" . explode(':', $f)[0] . "' => \$this->" . explode(':', $f)[0] . ",")->implode("\n            ");
        $relationshipMethods = $this->generateRelations($relations);

        $replacements = [
            '{{ modelNamespace }}' => $modelNamespace,
            '{{ modelName }}' => $modelName,
            '{{ fillable }}' => $fillable,
            '{{ tableName }}' => $tableName,
            '{{ modelVar }}' => $modelVar,
            '{{ pluralModelVar }}' => $pluralModelVar,
            '{{ modelVariable }}' => $modelVar,
            '{{ modelPluralVariable }}' => $pluralModelVar,
            '{{ rules }}' => $rules,
            '{{ columns }}' => $columns,
            '{{ resourceFields }}' => $resourceFields,
            '{{ useResource }}' => "{$modelName}Resource",
            '{{ relationships }}' => $relationshipMethods,
            '{{ fieldsForView }}' => collect($fields)->map(fn($f) => $this->generateViewField($f))->implode("\n                "),
            '{{ controllerNamespace }}' => $controllerNamespace,
            '{{ requestNamespace }}' => $requestNamespace,
            '{{ resourceNamespace }}' => $resourceNamespace,
            '{{ viewPath }}' => $viewPath,
            '{{ scopes }}' => $scopes,
        ];

        $stubPath = base_path('stubs/crud');
        $modelPath = "app/Models/" . ($namespacePath ? str_replace('\\', '/', $namespacePath) : '');
        $controllerPath = "app/Http/Controllers/" . ($namespacePath ? str_replace('\\', '/', $namespacePath) : '');
        $requestPath = "app/Http/Requests/" . ($namespacePath ? str_replace('\\', '/', $namespacePath) : '');
        $resourcePath = "app/Http/Resources/" . ($namespacePath ? str_replace('\\', '/', $namespacePath) : '');

        $this->generateFile("$modelPath/$modelName.php", "$stubPath/model.stub", $replacements);
        $this->generateMigration($tableName, $columns);
        $this->generateFile("$controllerPath/{$modelName}Controller.php", "$stubPath/controller.stub", $replacements);
        $this->generateFile("$requestPath/{$modelName}Request.php", "$stubPath/request.stub", $replacements);
        $this->generateFile("$resourcePath/{$modelName}Resource.php", "$stubPath/resource.stub", $replacements);

        foreach (['index', 'create', 'edit', 'show'] as $view) {
            $this->generateFile("resources/views/$viewFolder/$view.blade.php", "$stubPath/views/$view.stub", $replacements);
        }

        $this->addApiRoute($modelName, $controllerNamespace);
        $this->addWebRoute($modelInput);

        Artisan::call('migrate');
        $this->info("✅ Database migrated successfully.");
        $this->info("\n🎉 CRUD for $modelName generated successfully.");
    }

    protected function generateFile($path, $stub, $replacements)
    {
        $fullPath = base_path(trim($path, '/'));
        $dir = dirname($fullPath);
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $content = file_get_contents($stub);
        foreach ($replacements as $key => $value) {
            $content = str_replace($key, $value, $content);
        }

        file_put_contents($fullPath, $content);
        $this->info("Created: $fullPath");
    }

    protected function generateMigration($table, $columns)
    {
        $timestamp = now()->format('Y_m_d_His');
        $fileName = "{$timestamp}_create_{$table}_table.php";
        $path = database_path("migrations/$fileName");

        $stub = file_get_contents(base_path('stubs/crud/migration.stub'));
        $content = str_replace(['{{ tableName }}', '{{ columns }}'], [$table, $columns], $stub);

        file_put_contents($path, $content);
        $this->info("Created: database/migrations/$fileName");
    }

    protected function parseFields(string $input): array
    {
        $fields = [];
        $buffer = '';
        $depth = 0;
        foreach (str_split($input) as $char) {
            if ($char === ',' && $depth === 0) {
                $fields[] = $buffer;
                $buffer = '';
            } else {
                if ($char === '(') $depth++;
                if ($char === ')') $depth--;
                $buffer .= $char;
            }
        }
        if (trim($buffer) !== '') {
            $fields[] = $buffer;
        }
        return array_map('trim', $fields);
    }

    protected function generateColumn($field)
    {
        [$name, $type] = explode(':', $field);
        if (Str::startsWith($type, 'enum')) {
            $enumValues = Str::between($type, 'enum(', ')');
            $enumArray = collect(explode(',', $enumValues))->map(fn($v) => "'" . trim($v) . "'")->implode(', ');
            return "\$table->enum('$name', [$enumArray]);";
        }
        return "\$table->$type('$name');";
    }

    protected function generateRule($field)
    {
        [$name, $type] = explode(':', $field);
        if (Str::startsWith($type, 'enum')) {
            $enumValues = Str::between($type, 'enum(', ')');
            return "'$name' => 'required|in:$enumValues'";
        }
        return "'$name' => 'required'";
    }

    protected function generateRelations($relations)
    {
        return collect($relations)->map(function ($rel) {
            [$name, $type] = explode(':', $rel);
            $relatedModel = Str::studly(Str::singular($name));
            return "public function $name()\n    {\n        return \$this->$type($relatedModel::class);\n    }";
        })->implode("\n\n    ");
    }

    protected function generateViewField($field)
    {
        [$name, $type] = explode(':', $field);
        return "['name' => '$name', 'type' => '$type'],";
    }

    private function addApiRoute($modelName, $controllerNamespace)
    {
        $plural = Str::plural(Str::kebab($modelName));
        $controller = "{$controllerNamespace}\\{$modelName}Controller";
        $route = "\nRoute::apiResource('$plural', $controller::class);";

        $file = base_path('routes/api.php');
        if (!Str::contains(File::get($file), $controller)) {
            File::append($file, $route);
            $this->info("✅ API route added to routes/api.php");
        }
    }

    private function addWebRoute($modelInput)
    {
        $routeFile = base_path('routes/web.php');
        $modelInput = str_replace('/', '\\', $modelInput);

        $segments = explode('\\', $modelInput);
        $controllerName = array_pop($segments); // NewTask
        $controllerNamespacePath = implode('\\', $segments); // User

        $namespaceSlug = collect($segments)->map(fn($s) => Str::kebab($s))->implode('/');
        $resourceSlug = Str::kebab(Str::pluralStudly($controllerName));
        $routePath = $namespaceSlug ? "$namespaceSlug/$resourceSlug" : $resourceSlug;

        $controllerClass = 'App\\Http\\Controllers' . ($controllerNamespacePath ? '\\' . $controllerNamespacePath : '') . "\\{$controllerName}Controller";

        $route = "\nRoute::resource('$routePath', \\$controllerClass::class);";

        if (!Str::contains(File::get($routeFile), $controllerClass)) {
            File::append($routeFile, $route);
            $this->info("✅ Web route added to routes/web.php");
        } else {
            $this->warn("⚠️ Web route for {$controllerClass} already exists.");
        }
    }
}
