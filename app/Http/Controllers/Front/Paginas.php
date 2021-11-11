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

    public function contato_grava(Request $request)
    {
        $estabel = \App\Models\Estabelecimento::first();

        $rules = [
            'nome' => 'required',
            'email' => 'required',
            'celular' => 'required',
            'assunto' => 'required',
            'mensagem' => 'required',
        ];

        $mensages = [
            'nome.required' => 'O Nome tem que ser preenchido.',
            'email.required' => 'O e-mail tem que ser preenchido.',
            'celular.required' => 'O Celular tem que ser preenchido.',
            'assunto.required' => 'Informe o assunto',
            'mensagem.required' => 'Informe a mensagem'
        ];

        $request->validate($rules, $mensages);

        $contato = new \App\Models\Contato();
        $contato->NmAssunto = $request->assunto;
        $contato->NmPessoa = $request->nome;
        $contato->NmEmail = $request->email;
        $contato->NuTelefone = \App\Http\Controllers\Auxiliar::l_int($request->celular);
        $contato->TxObs = htmlentities($request->mensagem);
        $contato->NuIp = $request->ip();
        $contato->DtAtualizacao = date('Y-m-d H:i:s');
        $contato->save();

        return redirect()->route('front.contato')->with('sucesso', 'Em breve um de nossos colaboradores irá responder sua mensagem. Agradecemos seu contato.');

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
