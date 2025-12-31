<?php

namespace App\Services\Order;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    const DISCOUNT_THRESHOLD = 2000;
    const DISCOUNT_RATE = 0.10;

    private function generateOrderNumber(): string
    {
        $lastOrder = Order::withTrashed()->latest('id')->first();
        $nextId = $lastOrder ? $lastOrder->id + 1 : 1;

        return 'ORD-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    public function processOrder(array $data): Order
    {
        // in case something goes wrong
        DB::beginTransaction();

        try {
            $subtotal = 0;
            $items = [];

            foreach ($data['items'] as $item) {
                $amount = $item['quantity'] * $item['price'];
                $subtotal += $amount;

                $items[] = array_merge($item, [
                    'amount' => $amount
                ]);
            }

            $discount = $subtotal >= self::DISCOUNT_THRESHOLD ? $subtotal * self::DISCOUNT_RATE : 0;
            $total = $subtotal - $discount;

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'order_date' => $data['order_date'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
            ]);

            $order->items()->createMany($items);


            // Commit transaction
            DB::commit();

            return $order;
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            Log::error('Error on creating order: ' . $e->getMessage());

            throw $e;
        }
    }
}
