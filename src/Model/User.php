<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = 'users';
    protected $fillable = [
        'nom',
        'prenom',
        'role',
        'email',
        'password',
    ];
 
}