<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaEntrega extends Model
{
    use HasFactory;
    protected $connection= 'mysql_loja';
    public $timestamps = false;
    protected $table = 'entrega';
}
