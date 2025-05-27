<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'email' => 'required|email',
            'mensaje' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Datos inválidos', 'errors' => $validator->errors()], 422);
        }

        try {
           Mail::to('soporte.fastfix1@gmail.com')->send(new ContactFormMail($request->all()));

            return response()->json(['message' => 'Mensaje enviado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al enviar el correo.', 'error' => $e->getMessage()], 500);
        }
    }
}
