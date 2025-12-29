<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    // Para la verificación inicial del webhook
    public function verify(Request $request)
    {
        $verifyToken = 'EAASrMa35oVgBQDIXj4ZCL8kSi5nfLhXCcTEORbquWv6JgZCD9T0DAcjWnHZAagF9o0uRqkCLumELAjW2vKrTaftvd29ZAdRgF3jldoAqSqyGH63vfvZC8Yk1H4NxrNsTceAAZCUg3ZAOwbdvOXq6mAqGEZAXsc93pZBGNWoWJSKRhzz5qZBmnwC7eZBr5tcu70fhzYX4OJbYhc6VWOqvkeyqRhSBMC1ymRMhC6EwRT2ZC1FtLECytUG3HMqhWJ8ZCZCEStwUJUijiM3UdqZAYSc43Gr2Ee9OeYy';

        if ($request->hub_verify_token === $verifyToken) {
            return $request->hub_challenge;
        }

        return response('Token inválido', 403);
    }

    // Para recibir mensajes reales desde WhatsApp
    public function handle(Request $request)
    {
        Log::info('Webhook recibido:', $request->all());

        // Extraer el mensaje
        $data = $request->all();
        
        $message = $data['entry'][0]['changes'][0]['value']['messages'][0] ?? null;

        if ($message) {
            $from = $message['from']; // número del usuario
            $text = $message['text']['body'] ?? ''; // mensaje recibido

            // Enviar respuesta
            $this->sendMessage($from, "Recibí tu mensaje: $text");
        }

        return response()->json(['status' => 'ok']);
    }

    // Enviar mensaje de WhatsApp
    private function sendMessage($to, $body)
    {
        return Http::withToken(env('WHATSAPP_TOKEN'))
            ->post("https://graph.facebook.com/v24.0/" . env('WHATSAPP_PHONE_ID') . "/messages", [
                "messaging_product" => "whatsapp",
                "to" => $to,
                "type" => "text",
                "text" => [
                    "body" => $body
                ]
            ]);
    }
}
