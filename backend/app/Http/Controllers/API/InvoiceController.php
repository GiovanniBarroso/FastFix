<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    // Listar facturas del usuario autenticado
    public function index()
    {
        return Invoice::with(['order', 'user'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
    }

    // Crear una nueva factura (admin o automáticamente tras compra)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asunto' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|string|in:emitida,pagada,anulada',
            'fecha_emision' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id'
        ]);
        $invoice = Invoice::create($validated);
        return response()->json(['message' => 'Factura creada', 'data' => $invoice], 201);
    }

    // Ver detalles de una factura
    public function show($id)
    {
        $invoice = Invoice::with(['order', 'user'])->find($id);
        if (!$invoice || $invoice->user_id !== Auth::id()) {
            return response()->json(['message' => 'Factura no encontrada o no autorizada'], 404);
        }

        return response()->json($invoice);
    }

    public function download($id)
    {
        return response()->json(['message' => 'Funcionalidad de PDF aún no implementada'], 501);
    }

    public function generatePdf($id)
    {
        $invoice = Invoice::with('order.products', 'order.user', 'order.address')->findOrFail($id);
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice')); // Renderizamos la vista como PDF
        $filename = 'factura_' . $invoice->order_id . '.pdf'; // Ruta donde guardar el PDF
        $path = 'public/facturas/' . $filename;
        Storage::put($path, $pdf->output());

        // Guardar la URL en la factura (si no se ha guardado)
        if (!$invoice->pdf_url || $invoice->pdf_url !== $filename) {
            $invoice->update(['pdf_url' => $filename]);
        }

        return response()->json([
            'message' => 'PDF generado',
            'url' => Storage::url($path)
        ]);
    }
}
