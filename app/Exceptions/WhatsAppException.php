<?php

namespace App\Exceptions;

use Exception;

class WhatsAppException extends Exception
{
    public array $response;

    public function __construct(array $response)
    {
        $this->response = $response;
        parent::__construct(
            $response['error']['message'] ?? 'Error desconocido en WhatsApp'
        );
    }
}
