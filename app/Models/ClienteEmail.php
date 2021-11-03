<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteEmail extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $connection = 'mysql_loja';
    protected $primaryKey = ['CdEndereco','CdCliente'];
    public $incrementing = false;
    protected $table = 'cliente_email';
}
