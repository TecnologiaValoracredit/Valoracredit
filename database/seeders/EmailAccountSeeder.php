<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailAccount;
use App\Models\User;

class EmailAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmailAccount::create([
            'name' => 'Cuenta 1',
            'host' => 'pop.ionos.mx',
            'port' => 995,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'username' => 'tecnologia@valoracredit.mx',
            'password' => bcrypt('VZ;rh]Nc9O}:U{87'),
            'protocol' => 'POP3',
        ]);

        $user = User::find(1);
        $user->emailAccounts()->sync([1]);
    }
}
