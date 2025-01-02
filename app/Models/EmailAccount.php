<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class EmailAccount extends Model
{
    protected $fillable = [
        'name', 'host', 'port', 'encryption', 'validate_cert',
        'username', 'password', 'protocol',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'email_account_user');
    }
}