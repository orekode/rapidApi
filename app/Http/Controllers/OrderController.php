<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            ...$request->all(),
        ]);

        $total_price = 0;
        $total_quantity = 0;

        foreach ($request->products as $cart_product) {
            $product = Product::find($cart_product['id']);

            OrderProduct::create([
                'order' => $order->id,
                'product' => $product->id,
                'quantity' => $cart_product['quantity'],
                'price' => $product->price,
            ]);

            $total_price += $cart_product['quantity'] * $product->price;
            $total_quantity += $cart_product['quantity'];
        }

        $order->update([
            'total_price' => $total_price,
            'total_quantity' => $total_quantity,
        ]);

        OrderCreated::dispatch($order);

        return new OrderResource($order);
    }

    /**
     * Display the s<tr>
     * <td>
     * <th colspan="">Total Quantity:</th>
     * <td>${{ number_format($order->total_quantity, 2) }}</td>
     * </td>.
     *
     * $order = Order::create([
     * ...$request->all(),
     * <td>
     * <th colspan="">Total Price:</th>
     * <td>${{ number_format($order->total_price, 2) }}</td>
     * </td>
     * </tr>pecified resource.
     */
    public function show(Order $order)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
    }
}
