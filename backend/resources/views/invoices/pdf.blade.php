<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $invoice->numero_factura }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            color: #2c3e50;
            margin: 0;
            padding: 40px;
            background: #fdfdfd;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        header img {
            width: 140px;
        }

        .company-info {
            text-align: right;
            font-size: 13px;
            line-height: 1.6;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 10px;
            color: #007bff;
        }

        .client-info {
            margin-bottom: 30px;
            padding: 15px;
            background: #f8f9fa;
            border-left: 4px solid #007bff;
        }

        .client-info strong {
            display: inline-block;
            width: 140px;
            color: #34495e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background-color: #007bff;
            color: white;
            text-align: left;
        }

        .totals {
            margin-top: 20px;
            float: right;
            width: 40%;
        }

        .totals td {
            padding: 8px;
            border: none;
        }

        .totals tr td:first-child {
            text-align: left;
        }

        .totals tr td:last-child {
            text-align: right;
        }

        .footer {
            clear: both;
            margin-top: 50px;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #ccc;
            padding-top: 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <header style="display: flex; align-items: center; justify-content: space-between;">
        <img src="{{ public_path('logoFastFix.png') }}" alt="FastFix" style="width: 90px;">
        <div class="company-info">
            <strong>FastFix - Servicio Técnico de Confianza</strong><br>
            CIF: B12345678<br>
            Calle Reparaciones 123, 41001 Sevilla<br>
            Tel: +34 955 123 456<br>
            Email: contacto@fastfix.com
        </div>
    </header>

    <h1>Factura #{{ $invoice->numero_factura }}</h1>

    <div class="client-info">
        <p><strong>Fecha de emisión:</strong> {{ $invoice->fecha_emision }}</p>
        <p><strong>Cliente:</strong> {{ $invoice->order->user->nombre }} {{ $invoice->order->user->apellidos ?? '' }}
        </p>
        <p><strong>Email:</strong> {{ $invoice->order->user->email }}</p>
        <p><strong>Teléfono:</strong> {{ $invoice->order->user->telefono ?? '-' }}</p>
        <p><strong>Dirección:</strong> {{ $invoice->order->address->direccion }},
            {{ $invoice->order->address->codigo_postal }} {{ $invoice->order->address->ciudad }},
            {{ $invoice->order->address->provincia }} ({{ $invoice->order->address->pais }})</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal = 0; @endphp
            @foreach ($invoice->order->products as $product)
                @php
                    $lineTotal = $product->pivot->cantidad * $product->precio;
                    $subtotal += $lineTotal;
                @endphp
                <tr>
                    <td>{{ $product->nombre }}</td>
                    <td>€{{ number_format($product->precio, 2, ',', '.') }}</td>
                    <td>{{ $product->pivot->cantidad }}</td>
                    <td>€{{ number_format($lineTotal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $iva = $subtotal * 0.21;
        $total = $subtotal + $iva;
    @endphp

    <table class="totals">
        <tr>
            <td><strong>Subtotal:</strong></td>
            <td>€{{ number_format($subtotal, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>IVA (21%):</strong></td>
            <td>€{{ number_format($iva, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total a pagar:</strong></td>
            <td><strong>€{{ number_format($total, 2, ',', '.') }}</strong></td>
        </tr>
    </table>

    <div class="footer">
        Gracias por confiar en FastFix.<br>
        Esta factura es válida como justificante de compra. No se admiten devoluciones sin justificante en un plazo de
        14 días.
    </div>
</body>

</html>
