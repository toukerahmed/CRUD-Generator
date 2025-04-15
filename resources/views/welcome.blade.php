<x-layout>

    <div class="w3-container w3-padding-32 mt-5">
        <h1 class="w3-border-bottom w3-border-light-grey w3-padding-16 mb-4">All Created Models</h1>
    </div>

    @php
        $filteredModels = collect($models)->filter(fn($model) => $model !== 'User');

    @endphp

    @if ($filteredModels->isEmpty())
        <div class="alert alert-warning">
            🚫 No model created yet.
        </div>
    @else
        <div class="row">
            @foreach ($filteredModels as $model)
            @php
                $className = Str::afterLast($model, '\\');
                $slug = Str::kebab(Str::pluralStudly($className));
                $table = Str::snake(Str::pluralStudly($className));
                $columns = class_exists("App\\Models\\$model") && Schema::hasTable($table)
                    ? implode(', ', Schema::getColumnListing($table))
                    : 'No table found';

                    $segments = collect(explode('\\', $model))
                    ->map(fn($segment, $i) => $i === count(explode('\\', $model)) - 1
                        ? Str::kebab(Str::pluralStudly($segment)) // pluralize last segment
                        : Str::kebab(Str::singular(Str::snake($segment))) // singularize others
                    );
                    $routePath = $segments->implode('/');
            @endphp

            <div class="col-md-4 mb-4">
                <div class="card h-100 w3-black">
                    <div class="card-body">
                        <h5 class="card-title">{{ $className }}</h5>
                        <p class="card-text"><strong>Fields:</strong><br>{{ $columns }}</p>
                        <a href="{{ url($routePath) }}" class="w3-button w3-white w3-block">CRUD</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</x-layout>
