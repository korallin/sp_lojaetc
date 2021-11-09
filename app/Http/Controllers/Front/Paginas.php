<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Paginas extends Controller
{
    public function contato()
    {
        $estabel = \App\Models\Estabelecimento::first();
        $view = 'front.'.Session::get('loja').'.contato';
        return view($view, ['estabel' => $estabel]);
    }

    public function paginas(Request $request, $id, $nome)
    {

        $paginas = DB::connection('mysql_loja')->select('

            select * from mensagem
            where CdTipo = 1
            and CdMensagem = ?
            and CdEstabel = ?
            and StMensagem = 1;
        ', [$id, Session::get('loja_estabelecimento')]);


        $view = 'front.'.Session::get('loja').'.paginas';
        return view($view, ['dado' => $paginas[0]]);

    }

}
