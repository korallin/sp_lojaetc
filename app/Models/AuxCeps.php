<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuxCeps extends Model
{
    protected $connection = 'mysql_cep';
    use HasFactory;
    protected $table = 'endereco';

}
