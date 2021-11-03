<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoTemp extends Model
{
    use HasFactory;
    protected $connection= 'mysql_loja';
    public $timestamps = false;
    protected $primaryKey = 'CdTemp';
    protected $table = 'produto_temp';
    protected $fillable = [
        'CdMovimento',
        'CdEstabel',
        'CdCliente',
        'NuSessao',
        'CdProduto',
        'CdDetalhe',
    ];
}
