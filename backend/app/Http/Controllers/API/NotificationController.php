<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Obtener todas las notificaciones (más recientes primero)
    public function index()
    {
        return response()->json(Notification::latest()->get());
    }

    // Obtener solo las no leídas
    public function unread()
    {
        return response()->json(Notification::where('read', false)->get());
    }

    // Marcar todas como leídas
    public function markAllRead()
    {
        Notification::where('read', false)->update(['read' => true]);
        return response()->json(['message' => '✅ Todas las notificaciones han sido marcadas como leídas.']);
    }

    // Marcar una específica como leída
    public function markRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read' => true]);
        return response()->json(['message' => "📩 Notificación #{$id} marcada como leída."]);
    }
}
