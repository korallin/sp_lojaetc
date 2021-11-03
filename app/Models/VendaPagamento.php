<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendaPagamento extends Model
{
    use HasFactory;
    protected $connection= 'mysql_loja';
    public $timestamps = false;
    protected $primaryKey = 'CdVendaPag';
    protected $table = 'venda_pagamento';
    protected $fillable = [
        'CdEstabel ',
        'NuCaixa',
        'CdTipo',
        'CdVEnda',
    ];
}
