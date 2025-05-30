<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Order;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::with('user')->get();

        foreach ($orders as $order) {
            // Solo si el pedido tiene usuario asociado
            if ($order->user_id) {
                Invoice::create([
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'fecha_emision' => Carbon::now(),
                    'numero_factura' => 'INV-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                    'pdf_url' => 'factura_' . $order->id . '.pdf',
                ]);
            }
        }
    }
}
