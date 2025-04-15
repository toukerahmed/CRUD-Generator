<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', [
            'tasks' => $tasks,
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function create()
    {
        return view('tasks.create', [
            'modelVariable' => 'Task',
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function store(TaskRequest $request)
    {
        Task::create($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(\App\Models\Task $task)
    {
        return view('tasks.show', [
            'task' => $task
        ]);
    }

    public function edit(\App\Models\Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function update(TaskRequest $request, \App\Models\Task $task)
    {
        $task->update($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(\App\Models\Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}