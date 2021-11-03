<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteEndereco extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $connection = 'mysql_loja';
    protected $primaryKey = ['CdEndereco','CdCliente'];
    public $incrementing = false;
    protected $table = 'cliente_endereco';
}
