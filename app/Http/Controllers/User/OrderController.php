<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Order;
use App\Http\Requests\User\OrderRequest;
use App\Http\Resources\User\OrderResource;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('users.order.index', [
            'orders' => $orders,
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function create()
    {
        return view('users.order.create', [
            'modelVariable' => 'Order',
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function store(OrderRequest $request)
    {
        Order::create($request->validated());
        return redirect()->route('user.orders.index')->with('success', 'Order created successfully.');
    }

    public function show(\App\Models\User\Order $order)
    {
        return view('users.order.show', [
            'order' => $order
        ]);
    }

    public function edit(\App\Models\User\Order $order)
    {
        return view('users.order.edit', [
            'order' => $order,
            'fields' => [
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'status', 'type' => 'enum(open,closed)'],
            ]
        ]);
    }

    public function update(OrderRequest $request, \App\Models\User\Order $order)
    {
        $order->update($request->validated());
        return redirect()->route('user.orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(\App\Models\User\Order $order)
    {
        $order->delete();
        return redirect()->route('user.orders.index')->with('success', 'Order deleted successfully.');
    }
}