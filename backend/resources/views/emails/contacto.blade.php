<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mensaje recibido | FastFix</title>
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
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            padding: 40px 30px 30px;
            text-align: center;
            color: #ffffff;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            font-weight: 600;
        }

        .content {
            padding: 35px 30px;
        }

        .section {
            margin-bottom: 24px;
        }

        .label {
            font-size: 13px;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .value {
            background-color: #f9fafb;
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 15px;
            color: #111827;
            line-height: 1.6;
            word-break: break-word;
        }

        .value a {
            color: #2563eb;
            text-decoration: none;
        }

        .button-container {
            margin-top: 32px;
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 12px 26px;
            background-color: #2563eb;
            color: white;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .button:hover {
            background-color: #1e3a8a;
        }

        .signature {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #4b5563;
            line-height: 1.5;
        }

        .signature strong {
            color: #111827;
        }

        .meta {
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
            margin-top: 8px;
        }

        .footer {
            margin-top: 20px;
            padding: 18px;
            font-size: 12.5px;
            background-color: #f9fafb;
            color: #6b7280;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>¡Nuevo mensaje recibido desde FastFix!</h1>
        </div>
        <div class="content">
            <div class="section">
                <div class="label">Nombre</div>
                <div class="value">{{ e($datos['nombre']) }}</div>
            </div>

            <div class="section">
                <div class="label">Correo electrónico</div>
                <div class="value">
                    <a href="mailto:{{ e($datos['email']) }}">{{ e($datos['email']) }}</a>
                </div>
            </div>

            <div class="section">
                <div class="label">Mensaje</div>
                <div class="value">{{ e($datos['mensaje']) }}</div>
            </div>

            <div class="button-container">
                <a href="mailto:{{ e($datos['email']) }}" class="button">Responder al usuario</a>
            </div>

            <div class="signature">
                — El equipo de <strong>FastFix</strong><br>
                Rápido. Profesional. Confiable.
            </div>

            <div class="meta">
                Enviado el {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>

        <div class="footer">
            Este mensaje fue generado automáticamente por FastFix. No respondas directamente a este correo.
        </div>
    </div>
</body>

</html>
