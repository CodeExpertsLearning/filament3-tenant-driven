<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $store = \App\Models\Store::first();
        $products = $store->products()->orderByRaw('RANDOM()')->take(5)->get();

        $belongsTenantStore = [
            'store_id' => $store->id,
            'tenant_id' => $store->tenant_id
        ];

        $user = \App\Models\User::factory()
            ->hasOrders(1, $belongsTenantStore)
            ->create();

        $order = $user->orders->first();

        foreach ($products as $prod) {
            $amount = rand(1, 5);

            $order->items()->create(array_merge([
                'product_id' => $prod->id,
                'amount' => $amount,
                'order_value' => $prod->price * $amount
            ], $belongsTenantStore));
        }
    }
}
