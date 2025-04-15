<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Task1;
use App\Http\Requests\User\Task1Request;
use App\Http\Resources\User\Task1Resource;

class Task1Controller extends Controller
{
    public function index()
    {
        $task1s = Task1::all();
        return view('users.task1.index', [
            'task1s' => $task1s,
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function create()
    {
        return view('users.task1.create', [
            'modelVariable' => 'Task1',
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function store(Task1Request $request)
    {
        Task1::create($request->validated());
        return redirect()->route('task1s.index')->with('success', 'Task1 created successfully.');
    }

    public function show(\App\Models\User\Task1 $task1)
    {
        return view('users.task1.show', [
            'task1' => $task1
        ]);
    }

    public function edit(\App\Models\User\Task1 $task1)
    {
        return view('users.task1.edit', [
            'task1' => $task1,
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function update(Task1Request $request, \App\Models\User\Task1 $task1)
    {
        $task1->update($request->validated());
        return redirect()->route('task1s.index')->with('success', 'Task1 updated successfully.');
    }

    public function destroy(\App\Models\User\Task1 $task1)
    {
        $task1->delete();
        return redirect()->route('task1s.index')->with('success', 'Task1 deleted successfully.');
    }
}