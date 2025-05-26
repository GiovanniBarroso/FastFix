<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends Notification
{
    public $token;

    /**
     * Crear nueva instancia.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Canal de envío.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Contenido del mensaje.
     */
    public function toMail($notifiable)
    {
        $url = 'http://localhost:5173/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->getEmailForPasswordReset());

        return (new MailMessage)
            ->subject('🔐 Recupera el acceso a tu cuenta FastFix')
            ->greeting('¡Hola, ' . $notifiable->nombre . ' 👋!')
            ->line('Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en **FastFix**.')
            ->line('Si fuiste tú, haz clic en el botón de abajo para continuar:')
            ->action('🔁 Restablecer contraseña', $url)
            ->line('⚠️ Este enlace estará activo durante los próximos **60 minutos**.')
            ->line('Si no solicitaste este cambio, puedes ignorar este correo. Tu cuenta sigue segura 💙')
            ->salutation('— El equipo de FastFix 🔧');
    }
}
