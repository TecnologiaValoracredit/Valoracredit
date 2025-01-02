<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\EmailAccount;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email_account_id',
        'message_id',
        'subject',
        'from',
        'body',
        'date',
        'is_raed'
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con la cuenta de correo
    public function emailAccount()
    {
        return $this->belongsTo(EmailAccount::class);
    }
}
