<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuxUfs extends Model
{
    use HasFactory;
    protected $table = 'uf';
    use SoftDeletes;
}
