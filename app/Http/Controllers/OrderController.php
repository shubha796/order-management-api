<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;


class OrderController extends Controller
{
   
    public function store(OrderRequest $request, OrderService $service)
    {
     
        $order = $service->processOrder($request->validated());

        return response()->json([
            'order_number' => $order->order_number,
            'subtotal' => $order->subtotal,
            'discount' => $order->discount,
            'total' => $order->total,
        ], 201);
    }
}
