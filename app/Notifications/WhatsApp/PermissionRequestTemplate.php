<?php

namespace App\Notifications\WhatsApp;
use App\Models\Permit;
use App\Models\User;

class PermissionRequestTemplate
{
    public static function build(User $receiver, Permit $permit)
    {
        $isHr = $receiver->hasPermissions('permits.seeAllPermits');
        $receiver_name = $receiver->name;
        $message = $isHr ? "Este permiso requiere revisión de RH." : "Este permiso requiere revisión del Jefe Inmediato del solicitante.";
        $url = route('permits.changePermitStatus', $permit->id);

        return [
            'template' => [
                'name' => 'solicitud_permiso',
                'language' => [
                    'code' => 'es_MX',
                ],
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            ['type' => 'text', 'text' => $permit->id],
                        ],
                    ],
                    [
                        'type' => 'body',
                        'parameters' => [
                            ['type' => 'text', 'text' => $receiver_name],
                            ['type' => 'text', 'text' => $permit->id],
                            ['type' => 'text', 'text' => $message],
                            ['type' => 'text', 'text' => $permit->user->name],
                            ['type' => 'text', 'text' => $permit->departament->name],
                            ['type' => 'text', 'text' => $permit->jobPosition->name],
                        ],
                    ],
                    [
                        'type' => 'button',
                        'sub_type' => 'url',
                        'index' => '0',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => (string) $url,
                            ],
                        ],
                    ],
                ],
            ]
        ];
    }
}
