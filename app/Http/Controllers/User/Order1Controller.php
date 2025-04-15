<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Order1;
use App\Http\Requests\User\Order1Request;
use App\Http\Resources\User\Order1Resource;

class Order1Controller extends Controller
{
    public function index()
    {
        $order1s = Order1::all();
        return view('users.order1.index', [
            'order1s' => $order1s,
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function create()
    {
        return view('users.order1.create', [
            'modelVariable' => 'Order1',
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function store(Order1Request $request)
    {
        Order1::create($request->validated());
        return redirect()->route('order1s.index')->with('success', 'Order1 created successfully.');
    }

    public function show(\App\Models\User\Order1 $order1)
    {
        return view('users.order1.show', [
            'order1' => $order1
        ]);
    }

    public function edit(\App\Models\User\Order1 $order1)
    {
        return view('users.order1.edit', [
            'order1' => $order1,
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function update(Order1Request $request, \App\Models\User\Order1 $order1)
    {
        $order1->update($request->validated());
        return redirect()->route('order1s.index')->with('success', 'Order1 updated successfully.');
    }

    public function destroy(\App\Models\User\Order1 $order1)
    {
        $order1->delete();
        return redirect()->route('order1s.index')->with('success', 'Order1 deleted successfully.');
    }
}