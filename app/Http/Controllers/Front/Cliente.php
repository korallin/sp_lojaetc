<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class Cliente extends Controller
{

    public function exc(Request $request, $produto, $detalhe)
    {
        $cart = \App\Models\ProdutoTemp::where(array('NuSessao' => $_SESSION['lojaetc_id'], 'CdProduto' => $produto, 'CdDetalhe' => $detalhe))->delete();
        return redirect()->route('front.carrinho');
    }

    public function login(Request $request)
    {
        $view = 'front.forms.login';

        return view($view);

    }

    public function logout(Request $request)
    {

        Session::put(['login_status' => 0, 'login' => array('nome' => 'Visitante', 'login_id' => 0)]);
        Session::remove('cliente');
        Session::remove('cliente_endereco');
        Session::remove('cliente_telefone');
        $view = 'front.forms.login';
        return view($view);

    }

    public function cliente_area(Request $request)
    {

        $dados['vendas'] = \App\Models\Venda::where(['CdEstabel' => Session::get('loja_estabelecimento'), 'NuCaixa' => Session::get('loja_caixa'), 'CdCliente' => Session::get('login')['login_id']])->orderBy('DtVenda', 'desc')->get();

        //dd($dados, Session::all());

        $view = 'front.forms.cliente-area';
        return view($view, ['dados' => $dados]);
    }

    public function login_senha(Request $request)
    {
        return Redirect::back()->with(['success' => 'Sua solicitação para uma nova senha foi enviada, não esqueça de verificar a caixa de spam']);
    }

    public function login_valida(Request $request)
    {

        $doc_int = \App\Http\Controllers\Auxiliar::l_int($request->login);
        $valida_cliente = \App\Models\Cliente::where('NuCpfCnpj',$doc_int)->first();
        $login = 0;
        if($valida_cliente){
            if(isset($request->chave) and $request->chave != ''){
                $login = 1;
            } else {
                $senha_temp = md5(sha1(md5($request->senha)));

                if(isset($request->senha) and $senha_temp == $valida_cliente->NmSenha){
                    $login = 1;
                } else {
                    $login = 0;
                }
            }
        } else {
            return Redirect::back()->withErrors(['msg' => 'Login e/ou senha inválidos!']);
        }

        //dd($valida_cliente,$request,$login);

        if($login == 0){
            return Redirect::back()->withErrors(['msg' => 'Login e/ou senha inválidos!']);
        }

        $cliente = DB::connection('mysql_loja')->select('
            select * from cliente a
                join cliente_email b on a.CdCliente = b.CdCliente
                join cliente_telefone c on a.CdCliente = c.CdCliente
            where a.CdCliente = ?
        ', [$valida_cliente->CdCliente]);

        $cliente_endereco = DB::connection('mysql_loja')->select('
            select * from cliente_endereco a
            where a.CdCliente = ?
        ', [$valida_cliente->CdCliente]);

        $cliente_telefone = DB::connection('mysql_loja')->select('
            select * from cliente_telefone a
            where a.CdCliente = ?
        ', [$valida_cliente->CdCliente]);

        $cart = \App\Models\ProdutoTemp::where('NuSessao', $_SESSION['lojaetc_id'])->get();
        foreach ($cart as $aj){
            $ajcart = \App\Models\ProdutoTemp::where('NuSessao', $_SESSION['lojaetc_id'])->where('CdTemp', $aj->CdTemp)->where('CdProduto', $aj->CdProduto)->first();
            $ajcart->CdCliente = $valida_cliente->CdCliente;
            $ajcart->DtAtualizacao = date('Y-m-d H:i:s');
            $ajcart->save();
        }


        Session::put(['login_status' => $valida_cliente->CdCliente, 'cliente' => $cliente, 'cliente_endereco' => $cliente_endereco, 'cliente_telefone' => $cliente_telefone, 'login' => array('nome' => $valida_cliente->NmContato, 'login_id' => $valida_cliente->CdCliente)]);

        return redirect()->route('front.cliente_area');

    }

    public function cadastro_temp(Request $request)
    {

        $rules = [
            'cpfcnpj' => ['required','CpfCnpj'], //'required|CpfCnpj',
            'email' => 'required|email',
            'cep' => 'required',
        ];

        $mensages = [
            'cpfcnpj.required' => 'O cpf tem que ser preenchido.',
            'cpfcnpj.cpfcnpj' => 'O cpf está inválido.',
            'email.required' => 'O email tem que ser preenchido',
            'email.email' => 'O email está inválido',
        ];

        $request->validate($rules, $mensages);

        $doc_int = \App\Http\Controllers\Auxiliar::l_int($request->cpfcnpj);
        $valida_cliente = \App\Models\Cliente::where('NuCpfCnpj',$doc_int)->first();
        if($valida_cliente){
            return Redirect::back()->withErrors(['msg' => 'Seu CPF/CNPJ já consta em nossos registros, tente solicitar uma nova senha!']);
        }

        $valida_cliente = \App\Models\ClienteEmail::where('NmEmail',$request->email)->first();
        if($valida_cliente){
            return Redirect::back()->withErrors(['msg' => 'Seu E-MAIL já consta em nossos registros, tente solicitar uma nova senha!']);
        }

        $endereco = \App\Http\Controllers\Auxiliar::cep_cad($request->cep);
        $pessoa_endereco = json_decode($endereco,false);

        $pessoa = new \App\Models\Cliente();
        $pessoa->TpCliente = ($request->tipo == 1 ? 'F' : 'J');
        $pessoa->TpClassificacao = '77';
        $pessoa->NuCpfCnpj = $doc_int;
        $pessoa->DtCadastro = date('Y-m-d H:i:s');
        $pessoa->DtAtualizacao = date('Y-m-d H:i:s');
        $pessoa->StCliente = 9;
        $pessoa->save();

        $pessoa_email = new \App\Models\ClienteEmail();
        $pessoa_email->CdCliente = $pessoa->CdCliente;
        $pessoa_email->NmTipoEmail = 'Principal';
        $pessoa_email->NmEmail = $request->email;
        $pessoa_email->StPadrao = 1;
        $pessoa_email->DtCadastro = date('Y-m-d H:i:s');
        $pessoa_email->save();

        $dados['pessoa'] = $pessoa;

        $dados['pessoa_email'] = new \stdClass();
        $dados['pessoa_email']->NmEmail = $request->email;

        $dados['pessoa_telefone'] = new \stdClass();
        $dados['pessoa_telefone']->NuCelular = '';
        $dados['pessoa_telefone']->NuTelefone = '';

        $dados['pessoa_endereco'] = new \stdClass();
        $dados['pessoa_endereco']->CdCliente = $pessoa->CdCliente;
        $dados['pessoa_endereco']->CdEndereco = 1;
        $dados['pessoa_endereco']->NmTipoEndereco = 'Cadastro';
        $dados['pessoa_endereco']->NmEndereco = $pessoa_endereco->nome;
        $dados['pessoa_endereco']->NuEndereco = '';
        $dados['pessoa_endereco']->NmComplemento = '';
        $dados['pessoa_endereco']->NmBairro = $pessoa_endereco->bairro;
        $dados['pessoa_endereco']->NmCidade = $pessoa_endereco->cidade;
        $dados['pessoa_endereco']->SgEstado = $pessoa_endereco->id_uf;
        $dados['pessoa_endereco']->NuCep = $pessoa_endereco->cep;
        $dados['pessoa_endereco']->DtCadastro = date('Y-m-d H:i:s');
        $dados['pessoa_endereco']->id_endereco = $pessoa_endereco->id_endereco;
        $dados['pessoa_endereco']->id_bairro = $pessoa_endereco->id_bairro;
        $dados['pessoa_endereco']->id_cidade = $pessoa_endereco->id_cidade;
        $dados['pessoa_endereco']->id_uf = $pessoa_endereco->id_uf;

        Session::put('cliente_pre', $dados);

        return \redirect()->route('front.cadastro_form');

    }

    public function salva_endereco(Request $request)
    {

        $cliente = Session::get('cliente')[0];

        $dados['pessoa_endereco'] = new \App\Models\ClienteEndereco();
        $dados['pessoa_endereco']->CdCliente = $cliente->CdCliente;
        $dados['pessoa_endereco']->NmTipoEndereco = $request->NmTipoEndereco;
        $dados['pessoa_endereco']->NmEndereco = $request->NmEndereco;
        $dados['pessoa_endereco']->NuEndereco = $request->NuEndereco;
        $dados['pessoa_endereco']->NmComplemento = $request->NmComplemento;
        $dados['pessoa_endereco']->NmBairro = $request->NmBairro;
        $dados['pessoa_endereco']->NmCidade = $request->NmCidade;
        $dados['pessoa_endereco']->SgEstado = $request->SgEstado;
        $dados['pessoa_endereco']->NuCep = \App\Http\Controllers\Auxiliar::l_int($request->NuCep);
        $dados['pessoa_endereco']->DtCadastro = date('Y-m-d H:i:s');
        //$dados['pessoa_endereco']->id_endereco = $request->CdCepCep;
        //$dados['pessoa_endereco']->id_bairro = $request->CdCepBairro;
        //$dados['pessoa_endereco']->id_cidade = $request->CdCepCidade;
        //$dados['pessoa_endereco']->id_uf = $request->CdCepUf;
        $dados['pessoa_endereco']->save();

        return \redirect()->route('front.checkout');
    }

    public function troca_endereco(Request $request)
    {

        $cliente = Session::get('cliente')[0];

        $cliente_endereco = DB::connection('mysql_loja')->select('
            select * from cliente_endereco a
            where a.CdCliente = ? and CdEndereco = ?
        ', [$cliente->CdCliente, $request->endereco]);

        Session::put('cliente_endereco', $cliente_endereco);

        return \redirect()->route('front.checkout');
    }

    public function cadastro_form(Request $request)
    {
        $dados = Session::get('cliente_pre');
        //dd($dados);
        $view = 'front.forms.cliente-cadastro';
        return view($view, ['dado' => $dados]);
    }


    public function cadastro_grava(Request $request)
    {



        $rules = [
            'NmCliente' => 'required',
            'NmContato' => 'required',
            'password' => 'required|confirmed|min:6',
            'NuCelular' => 'required',
            'NuCep' => 'required',
            'NmEndereco' => 'required',
            'NuEndereco' => 'required',
            'NmBairro' => 'required',

        ];

        $mensages = [
            'NmCliente.required' => 'O Nome/Razão tem que ser preenchido.',
            'NmContato.required' => 'O Apelido/Contato tem que ser preenchido.',
            'NuCelular.required' => 'O Celular tem que ser preenchido.',
            'NuCep.required' => 'Informe o CEP',
            'NmEndereco.required' => 'Informe o endereço',
            'NuEndereco.required' => 'Informe o número',
            'NmBairro.required' => 'Informe o bairro',
        ];

        $request->validate($rules, $mensages);

        //dd($request->all());

        $doc_int = \App\Http\Controllers\Auxiliar::l_int($request->NuCpfCnpj);
        $valida_cliente = \App\Models\Cliente::where('NuCpfCnpj',$doc_int)->first();

        $pessoa = \App\Models\Cliente::find($valida_cliente->CdCliente);
        $pessoa->TpClassificacao = '1,77';
        $pessoa->NmCliente = $request->NmCliente ;
        $pessoa->NmContato = $request->NmContato ;
        $pessoa->NmSenha = md5(sha1(md5($request->password)));
        if($pessoa->TpCliente == 'F'){
            $pessoa->NuIdentidade = $request->NuIdentidade ;
        } else {
            $pessoa->NuInscricaoEstadual = $request->NuInscricaoEstadual ;
        }
        $pessoa->DtAtualizacao = date('Y-m-d H:i:s');
        $pessoa->StCliente = 1;
        $pessoa->save();

        $dados['pessoa_endereco'] = new \App\Models\ClienteEndereco();
        $dados['pessoa_endereco']->CdCliente = $pessoa->CdCliente;
        $dados['pessoa_endereco']->NmTipoEndereco = 'Cadastro';
        $dados['pessoa_endereco']->NmEndereco = $request->NmEndereco;
        $dados['pessoa_endereco']->NuEndereco = $request->NuEndereco;
        $dados['pessoa_endereco']->NmComplemento = $request->NmComplemento;
        $dados['pessoa_endereco']->NmBairro = $request->NmBairro;
        $dados['pessoa_endereco']->NmCidade = $request->NmCidade;
        $dados['pessoa_endereco']->SgEstado = $request->SgEstado;
        $dados['pessoa_endereco']->NuCep = \App\Http\Controllers\Auxiliar::l_int($request->NuCep);
        $dados['pessoa_endereco']->DtCadastro = date('Y-m-d H:i:s');
        //$dados['pessoa_endereco']->id_endereco = $request->CdCepCep;
        //$dados['pessoa_endereco']->id_bairro = $request->CdCepBairro;
        //$dados['pessoa_endereco']->id_cidade = $request->CdCepCidade;
        //$dados['pessoa_endereco']->id_uf = $request->CdCepUf;
        $dados['pessoa_endereco']->save();

        //CELULAR
        $celular = \App\Http\Controllers\Auxiliar::l_int($request->NuCelular);
        if($celular != '') {

            $dadosCelular = \App\Models\ClienteTelefone::where('CdCliente', $pessoa->CdCliente)->where('NuTelefone', $celular)->first();
            if(!$dadosCelular){
                $dadosCelular = new \App\Models\ClienteTelefone();
                $dadosCelular->CdCliente = $pessoa->CdCliente;
                $dadosCelular->NmTipoTelefone = 'CELULAR';
                $dadosCelular->NuTelefone = $celular;
                $dadosCelular->StPadrao = 1;
                $dadosCelular->DtCadastro = date('Y-m-d H:i:s');
                $dadosCelular->save();
            }
        }

        //CELULAR
        $fixo = \App\Http\Controllers\Auxiliar::l_int($request->NuTelefone);
        if($fixo != '') {
            $dadosFixo = \App\Models\ClienteTelefone::where('CdCliente', $pessoa->CdCliente)->where('NuTelefone', $fixo)->first();
            if(!$dadosFixo){
                $dadosFixo = new \App\Models\ClienteTelefone();
                $dadosFixo->CdCliente = $pessoa->CdCliente;
                $dadosFixo->NmTipoTelefone = 'FIXO';
                $dadosFixo->NuTelefone = $fixo;
                $dadosFixo->DtCadastro = date('Y-m-d H:i:s');
                $dadosFixo->save();
            }

        }
        return redirect()->route('front.login_valida', ['login' => $pessoa->NuCpfCnpj, 'chave' => md5(sha1(md5(sha1($request->NmSenha))))]);

    }

}


