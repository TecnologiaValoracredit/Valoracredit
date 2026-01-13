<?php

namespace App\Notifications\WhatsApp;
use App\Models\Permit;
use App\Models\User;

class PermissionApDnTemplate
{
    public static function build(User $receiver, Permit $permit, $status)
    {
        $receiver_name = $receiver->name;
        $url = route('permits.show', $permit->id);

        return [
            'template' => [
                'name' => 'permiso_aprobado_denegado', //en prod sera permiso_ap_dn
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
                            ['type' => 'text', 'text' => date("d/m/Y", strtotime($permit->permit_date))],
                            ['type' => 'text', 'text' => $status],
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
