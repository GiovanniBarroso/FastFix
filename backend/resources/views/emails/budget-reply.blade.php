{{-- resources/views/emails/budget-reply.blade.php --}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Respuesta a tu solicitud de presupuesto</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="color: #333;">Hola {{ $nombre }},</h2>

        <p style="color: #555; font-size: 16px;">
            Hemos revisado tu solicitud y te respondemos a continuación:
        </p>

        <blockquote style="border-left: 4px solid #2196F3; padding-left: 15px; color: #444; font-style: italic; margin: 20px 0;">
            {{ $mensaje }}
        </blockquote>

        <p style="color: #555; font-size: 16px;">
            Si tienes cualquier otra duda, no dudes en responder a este correo.
        </p>

        <p style="color: #777; font-size: 14px;">
            Un saludo,<br>
            <strong>El equipo de FastFix</strong>
        </p>
    </div>
</body>
</html>
