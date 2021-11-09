<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estabelecimento extends Model
{

    use HasFactory;
    public $timestamps = false;
    protected $connection = 'mysql_loja';
    protected $primaryKey = 'CdEstabel';
    protected $table = 'estabelecimento';
}
