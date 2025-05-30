{{-- resources/views/emails/budget-reply.blade.php --}}

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Respuesta a tu solicitud de presupuesto</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 620px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 22px;
            margin: 0;
            font-weight: 600;
        }

        .content {
            padding: 35px 30px;
            color: #1f2937;
            font-size: 16px;
            line-height: 1.6;
        }

        .message {
            border-left: 4px solid #2563eb;
            background: #f9fafb;
            padding: 18px 20px;
            font-style: italic;
            border-radius: 8px;
            color: #374151;
            margin: 24px 0;
        }

        .signature {
            margin-top: 30px;
            color: #4b5563;
            font-size: 15px;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            padding: 20px;
            background: #f9fafb;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Presupuesto de FastFix</h1>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $nombre }}</strong>,</p>

            <p>Gracias por confiar en FastFix. Hemos revisado tu solicitud y te respondemos a continuación:</p>

            <div class="message">
                {{ $mensaje }}
            </div>

            <p>Si tienes cualquier otra duda, no dudes en responder a este correo. Estaremos encantados de ayudarte.</p>

            <div class="signature">
                — El equipo de <strong>FastFix</strong><br />
                Rápido. Profesional. Confiable.
            </div>
        </div>
        <div class="footer">
            Este correo fue enviado automáticamente desde FastFix. Si no solicitaste este presupuesto, puedes ignorarlo.
        </div>
    </div>
</body>

</html>
