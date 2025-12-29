<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Permit;
use App\Models\User;

class PermitSentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private User $receiver;
    private Permit $permit;

    public function __construct(User $receiver, Permit $permit)
    {
        $this->receiver = $receiver;
        $this->permit = $permit;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Permiso enviado a revisión - Acción necesaria',
            to: [
                $this->receiver->email,
            ],
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $isHr = $this->receiver->hasPermissions('permits.seeAllPermits');
        $receiver_name = $this->receiver->name;
        $mail_message = $isHr ? "Este permiso requiere revisión de RH." : "Este permiso requiere revisión del Jefe Inmediato del solicitante.";

        return new Content(
            view: 'permits.emails.sent',
            with: [
                'receiver_name' => $receiver_name,
                'mail_message' => $mail_message,
                'permit' => $this->permit,
                'url' => route('permits.changePermitStatus', $this->permit->id),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
