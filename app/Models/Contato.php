<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;
    protected $connection= 'mysql_loja';
    public $timestamps = false;
    protected $primaryKey = 'CdContato';
    protected $table = 'contato';
}
