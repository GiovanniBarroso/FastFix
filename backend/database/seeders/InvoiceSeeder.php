<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Order;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $ordenes = Order::where('estado', 'pagado')->get();
        $contador = 1;

        foreach ($ordenes as $orden) {
            Invoice::create([
                'order_id' => $orden->id,
                'fecha_emision' => $orden->fecha_pago ?? now(),
                'numero_factura' => 'INV-' . str_pad($contador++, 4, '0', STR_PAD_LEFT),
                'pdf_url' => 'factura_' . $orden->id . '.pdf',
            ]);
        }
    }
}
