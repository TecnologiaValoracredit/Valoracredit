<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\Role;
use App\Models\Branch;
use App\Models\Departament;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Email;
use Webklex\PHPIMAP\ClientManager;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        $user = auth()->user();
        $clientManager = new ClientManager();
        $config = [
            'host'          => 'imap.ionos.mx',
            'port'          => 993,
            'encryption'    => 'ssl', // ssl o tls
            'validate_cert' => true,
            'username'      => 'auxtecnologia@valoracredit.mx',
            'password'      => '4Ca5uWh5BI5D',
            'protocol'      => 'imap', // Asegúrate de que sea en minúsculas
        ];
        $config['debug'] = true;


        // Crear el cliente
        $client = $clientManager->make($config);

        // Conectar al servidor
        try {
             // Obtener los mensajes
             $messages = $client->getFolder('INBOX')->messages()->all()->get();

             foreach ($messages as $message) {
                // Guardar el correo en la base de datos (si no existe)
                $email = Email::firstOrCreate(
                    ['message_id' => $message->getMessageId()],
                    [
                        'user_id' => $user->id,
                        'email_account_id' => 1,
                        'subject' => $message->getSubject(),
                        'from' => $message->getFrom()[0]->mail,
                        'body' => $message->getTextBody(),
                        'date' => $message->getDate(),
                        'is_read' => false
                    ]
                );
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        // $user = auth()->user();

        // $client = ClientManager::account('default');
        // $client->connect();

        // foreach ($user->emailAccounts as $account) {
        //     // Configura el cliente IMAP o POP3
        //     $client = (new ClientManager())->make([
        //         'host'          => $account->host,
        //         'port'          => $account->port,
        //         'encryption'    => $account->encryption,
        //         'validate_cert' => $account->validate_cert,
        //         'username'      => $account->username,
        //         'password'      => decrypt($account->password),
        //         'protocol'      => $account->protocol,
        //     ]);

        //     $client->connect();

        //     // Obtén los mensajes de la bandeja de entrada
        //     $messages = $client->getFolder('INBOX')->messages()->all()->get();

        //     // Guarda los correos en la base de datos
        //     foreach ($messages as $message) {
        //         // Usa firstOrCreate para evitar duplicados
        //         Email::firstOrCreate(
        //             ['message_id' => $message->getMessageId()],
        //             [
        //                 'user_id' => $user->id,
        //                 'email_account_id' => $account->id,
        //                 'subject' => $message->getSubject(),
        //                 'from' => $message->getFrom()[0]->mail,
        //                 'body' => $message->getTextBody(),
        //                 'date' => $message->getDate(),
        //             ]
        //         );

        //         // Opcional: eliminar el correo del servidor si lo prefieres
        //         // $message->delete();
        //     }
        // }

        // return redirect()->back()->with('success', 'Correos actualizados.');

        // $allowAdd = auth()->user()->hasPermissions("users.create");
        // return $dataTable->render('users.index', compact("allowAdd"));
    }

    public function create()
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        return view('users.create', compact('roles', 'branches','departaments'));
    }

    
    public function store(UserRequest $request)
    {
        $status = true;
		$user = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role_id" => $request->role_id,
            'is_active' => !is_null($request->is_active),
		]);
        
		try {
            $user = User::create($params);
            $message = "Usuario creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'roles');
		}
        return $this->getResponse($status, $message, $user);
        
    }
    
    public function edit(User $user)
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        return view('users.edit', compact("user", "roles", "branches","departaments"));
    }
    
    public function update(UserRequest $request, User $user)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "email" => $request->email,
            "role_id" => $request->role_id,
            'is_active' => !is_null($request->is_active),
		]);
        unset($params["password"]);
        if ($request->password) {
            $params["password"] = Hash::make($request->password);
        }

        try {
            $user->update($params);
            $message = "Usuario modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'users');
        }
        return $this->getResponse($status, $message, $user);
    
    }

    public function destroy(User $user)
    {
        $status = true;
        try {
            $user->update(["is_active" => false]);
            $message = "Usuario desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'users');
        }
        return $this->getResponse($status, $message);
    }
    
}
