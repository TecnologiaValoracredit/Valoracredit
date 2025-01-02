<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Email;
use Webklex\IMAP\ClientManager;

class EmailAccountController extends Controller
{
    public function refreshEmails()
    {
        // Obtén el usuario autenticado y sus cuentas de correo
        $user = auth()->user();

        // Asegúrate de que el usuario tenga cuentas de correo
        if (!$user->emailAccounts->count()) {
            return redirect()->back()->with('error', 'No tienes cuentas de correo asociadas.');
        }

        // Procesar todas las cuentas de correo del usuario
        foreach ($user->emailAccounts as $account) {
            // Configura el cliente IMAP o POP3
            $client = (new ClientManager())->make([
                'host'          => $account->host,
                'port'          => $account->port,
                'encryption'    => $account->encryption,
                'validate_cert' => $account->validate_cert,
                'username'      => $account->username,
                'password'      => decrypt($account->password),
                'protocol'      => $account->protocol,
            ]);

            $client->connect();

            // Obtén los mensajes de la bandeja de entrada
            $messages = $client->getFolder('INBOX')->messages()->all()->get();

            // Guarda los correos en la base de datos
            foreach ($messages as $message) {
                // Usa firstOrCreate para evitar duplicados
                Email::firstOrCreate(
                    ['message_id' => $message->getMessageId()],
                    [
                        'user_id' => $user->id,
                        'email_account_id' => $account->id,
                        'subject' => $message->getSubject(),
                        'from' => $message->getFrom()[0]->mail,
                        'body' => $message->getTextBody(),
                        'date' => $message->getDate(),
                        'is_read' => false,
                    ]
                );

                // Opcional: eliminar el correo del servidor si lo prefieres
                // $message->delete();
            }
        }

        return redirect()->back()->with('success', 'Correos actualizados.');
    }
}
