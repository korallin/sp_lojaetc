<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendaProdutos extends Model
{
    use HasFactory;
    protected $connection= 'mysql_loja';
    public $timestamps = false;
    protected $primaryKey = [
        'CdEstabel ',
        'NuCaixa',
        'CdTipo',
        'CdVEnda',
        'NuItem',
    ];
    protected $table = 'venda_produto';
    protected $fillable = [
        'CdEstabel ',
        'NuCaixa',
        'CdTipo',
        'CdVEnda',
        'NuItem',
    ];
}
