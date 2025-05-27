<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo mensaje desde FastFix</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            color: #1a202c;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 20px;
        }
        .header h2 {
            color: #2563eb;
        }
        .icon {
            font-size: 48px;
            color: #2563eb;
        }
        .content p {
            line-height: 1.6;
        }
        .label {
            font-weight: 600;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            text-align: center;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">📩</div>
            <h2>Nuevo mensaje recibido desde FastFix</h2>
        </div>
        <div class="content">
            <p><span class="label">Nombre:</span> {{ e($datos['nombre']) }}</p>
            <p><span class="label">Email:</span> <a href="mailto:{{ e($datos['email']) }}">{{ e($datos['email']) }}</a></p>
            <p><span class="label">Mensaje:</span><br>{{ e($datos['mensaje']) }}</p>
        </div>
        <div class="footer">
            Este mensaje ha sido enviado automáticamente desde el sitio web <strong>FastFix</strong>.<br>
            Por favor, no respondas a este mensaje directamente.
        </div>
    </div>
</body>
</html>
