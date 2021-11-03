<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    const CREATED_AT = 'DtCadastro';
    const UPDATED_AT = 'DtAtualizacao';
    use HasFactory;
    protected $connection = 'mysql_loja';
    protected $primaryKey = 'CdCliente';
    protected $table = 'cliente';
}
