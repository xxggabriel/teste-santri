<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public $timestamps = false;
    public $primaryKey = 'USUARIO_ID';
    protected $hidden = [
        'SENHA',
    ];
}
