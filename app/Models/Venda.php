<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;
    protected $connection= 'mysql_loja';
    public $timestamps = false;
    protected $primaryKey = 'CdVenda';
    protected $table = 'venda';
    protected $fillable = [
        'CdEstabel ',
        'NuCaixa',
        'CdTipo',
        'CdVEnda',
    ];
}
