<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Project;
use App\Http\Requests\Admin\ProjectRequest;
use App\Http\Resources\Admin\ProjectResource;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::filter($request->query())->get();
        return view('admins.project.index', [
            'projects' => $projects,
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'descrioption', 'type' => 'text'],
                ['name' => 'status', 'type' => 'enum(active,inactive)'],
            ]
        ]);
    }

    public function create()
    {
        return view('admins.project.create', [
            'modelVariable' => 'Project',
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'descrioption', 'type' => 'text'],
                ['name' => 'status', 'type' => 'enum(active,inactive)'],
            ]
        ]);
    }

    public function store(ProjectRequest $request)
    {
        Project::create($request->validated());
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(\App\Models\Admin\Project $project)
    {
        return view('admins.project.show', [
            'project' => $project
        ]);
    }

    public function edit(\App\Models\Admin\Project $project)
    {
        return view('admins.project.edit', [
            'project' => $project,
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'descrioption', 'type' => 'text'],
                ['name' => 'status', 'type' => 'enum(active,inactive)'],
            ]
        ]);
    }

    public function update(ProjectRequest $request, \App\Models\Admin\Project $project)
    {
        $project->update($request->validated());
        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(\App\Models\Admin\Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}