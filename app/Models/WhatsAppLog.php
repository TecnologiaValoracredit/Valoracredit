<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class WhatsAppLog extends Model
{
    protected $table = 'whatsapp_logs';

    protected $fillable = [
        'related_type',
        'related_id',
        'to',
        'template_name',
        'status',
        'meta_message_id',
        'error_message',
        'payload',
        'response',
        'sent_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'response' => 'array',
        'sent_at' => 'datetime',
    ];

    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    /* =====================
     | Helpers (opcional)
     ===================== */

    public function markAsSent(array $response = []): void
    {
        $this->update([
            'status' => 'SENT',
            'meta_message_id' => $response['messages'][0]['id'] ?? null,
            'response' => $response,
            'sent_at' => now(),
        ]);
    }

    public function markAsFailed(string $error, array $response = []): void
    {
        $this->update([
            'status' => 'FAILED',
            'error_message' => $error,
            'response' => $response,
        ]);
    }
}
