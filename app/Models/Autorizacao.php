<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autorizacao extends Model
{
    protected $table = 'autorizacoes';
    public $primaryKey = 'AUTORIZACAO_ID';
    public $timestamps = false;
}
