<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteTelefone extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $connection = 'mysql_loja';
    protected $primaryKey = ['CdTelefone','CdCliente'];
    public $incrementing = false;
    protected $table = 'cliente_telefone';
}
