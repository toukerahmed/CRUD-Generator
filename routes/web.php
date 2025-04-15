<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $modelFiles = File::allFiles(app_path('Models'));

    $models = collect($modelFiles)->map(function ($file) {
        return str_replace(
            ['/', '.php'],
            ['\\', ''],
            Str::after($file->getPathname(), app_path('Models') . DIRECTORY_SEPARATOR)
        );
    });

    return view('welcome', ['models' => $models]);
});

Route::resource('admin/projects', \App\Http\Controllers\Admin\ProjectController::class);