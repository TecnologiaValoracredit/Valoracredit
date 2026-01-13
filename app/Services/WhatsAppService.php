<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Exceptions\WhatsAppException;

class WhatsAppService
{
    protected string $endpoint;

    public function __construct()
    {
        $this->endpoint = 'https://graph.facebook.com/v24.0/' .
            config('services.whatsapp.phone_id') . '/messages';
    }

    public function sendTemplate(string $to, array $payload)
    {
        $response = Http::withToken(config('services.whatsapp.token'))
            ->post($this->endpoint, [
                'messaging_product' => 'whatsapp',
                'to' => preg_replace('/\D/', '', $to),
                'type' => 'template',
            ] + $payload);

        $data = $response->json();

        //META error aunque sea 200
         if (isset($data['error']) || $response->failed()) {
            throw new WhatsAppException($data);
        }

        return $data;

    }
   
}
