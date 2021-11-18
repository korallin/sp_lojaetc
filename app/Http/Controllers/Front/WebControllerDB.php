<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

class WebControllerDB extends Controller
{

    public function arrayPaginator($array, $request)
    {
        $page = Input::get('page', 1);
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
    }

    public function home()
    {
        $produtos = DB::connection('mysql_loja')->select('

        select   PR.CdProduto, PR.NmProduto, PR.TxProduto, PC.CdReferencia,
			min(PP.VlPreco) as VlPrecoMin, max(PP.VlPreco) as VlPrecoMax,
			PF.NmFoto,
			if(PF.NmFoto is null, 0,1) as StFoto
        from produto PR
        join produto_detalhe PD on (PR.CdProduto = PD.CdProduto)
        join produto_preco PP on (PP.CdProduto = PR.CdProduto and PP.CdDetalhe = PD.CdDetalhe )
        join produto_estoque PE on (PE.CdProduto = PD.CdProduto and PE.CdDetalhe = PD.CdDetalhe and PE.CdEstabel = ? )
        join produto_codigo PC on (PD.CdProduto = PC.CdProduto and PD.CdDetalhe = PC.CdDetalhe and PC.StPrincipal = 1 )
        left join produto_foto PF on (PF.CdProduto = PR.CdProduto and PF.StPrincipal = 1)

        where PR.DtDesativacao is null
        and PP.CdTabela in (?)
        and PR.StLojaVirtual = 1

        group by PR.CdProduto
        order by StFoto desc, PR.DtAtualizacao desc, rand() limit 9;

        ', [Session::get('loja_estabelecimento'),Session::get('loja_tabelas')]);

        //dd(Session::get('loja'),$produtos);

        $view = 'front.'.Session::get('loja').'.home';

        $banners = DB::connection('mysql_loja')->select('
            select * from publicidade
            where CdEstabel = '.Session::get('loja_estabelecimento').'
            and StPublicidade = 1
            and CdTipo = 1
            and DtInicial <= now()
            and DtFinal >= now()
            order by rand() limit 1;
        ');

        //dump($view);

        return view($view, ['produtos' => $produtos, 'banners' => $banners]);

    }

    public function departamento(Request $request, $id,$nome)
    {

        /*
        $departamento = DB::connection('mysql_loja')->select('

            select 	GX.CdDepartamento, GR.CdDepartamento, GR.CdDepartamentoPai, GR.NmDepartamento as nome_departamento, SG.NmDepartamento,
			if(GR.CdDepartamentoPai is not null, GR.CdDepartamentoPai, GR.CdDepartamento ) as CdGrupo,
			if(GR.CdDepartamentoPai is not null, SG.NmDepartamento, GR.NmDepartamento ) as NmGrupo
            from produto PR
            join produto_estoque PE on (PE.CdProduto = PR.CdProduto and PE.CdEstabel = ? and PE.QtEstoque > 0 )
            join produto_x_departamento GX on (GX.CdProduto = PR.CdProduto)
            join produto_departamento GR on (GR.CdDepartamento = GX.CdDepartamento)
            left join produto_departamento SG on (GR.CdDepartamentoPai = SG.CdDepartamento)
            where PR.DtDesativacao is null
            and if(GR.CdDepartamentoPai is not null, GR.CdDepartamentoPai, SG.CdDepartamento ) = ?
            group by CdGrupo
            order by NmGrupo;

        ', [Session::get('loja_estabelecimento'), $id]);
        */

        $departamento = DB::connection('mysql_loja')->select('

            select
			GR.CdDepartamento as CdGrupo,
			GR.NmDepartamento as NmGrupo
            from produto_departamento GR
            where GR.CdDepartamento = ?

        ', [$id]);

        $produtos = DB::connection('mysql_loja')->select('

        select   PR.CdProduto, PR.NmProduto, PR.TxProduto, PC.CdReferencia,
			min(PP.VlPreco) as VlPrecoMin, max(PP.VlPreco) as VlPrecoMax,
			PF.NmFoto,
			if(PF.NmFoto is null, 0,1) as StFoto
        from produto PR
        join produto_detalhe PD on (PR.CdProduto = PD.CdProduto)
        join produto_preco PP on (PP.CdProduto = PR.CdProduto and PP.CdDetalhe = PD.CdDetalhe )
        join produto_estoque PE on (PE.CdProduto = PD.CdProduto and PE.CdDetalhe = PD.CdDetalhe and PE.CdEstabel = ? )
        join produto_codigo PC on (PD.CdProduto = PC.CdProduto and PD.CdDetalhe = PC.CdDetalhe and PC.StPrincipal = 1 )
        left join produto_foto PF on (PF.CdProduto = PR.CdProduto and PF.StPrincipal = 1)
        join produto_x_departamento GX on (GX.CdProduto = PR.CdProduto)
        where PR.DtDesativacao is null
            and PR.StLojaVirtual = 1
            and PP.CdTabela in (?)
            and GX.CdDepartamento = ?

        group by PR.CdProduto
        order by
                 '.(isset($request->ordem) ? (
                    $request->ordem == 'A' ?  'PR.NmProduto ASC' : (
                        $request->ordem == 'Z' ?  'PR.NmProduto DESC' : (
                            $request->ordem == '0' ?  'min(PP.VlPreco) ASC' : (
                                $request->ordem == '9' ?  'min(PP.VlPreco) DESC' : (
                                "StFoto desc, PR.DtAtualizacao desc, rand()"
                                )
                            )
                        )
                    )
                ) : "StFoto desc, PR.DtAtualizacao desc, rand()").'


        ', [Session::get('loja_estabelecimento'),Session::get('loja_tabelas'),$id]);

        //dd(Session::get('loja'),$produtos);

        $view = 'front.'.Session::get('loja').'.departamento';

        //$paginacao = $this->arrayPaginator($produtos, $request);

        //dd($paginacao);

        return view($view, ['produtos' => $produtos, 'departamento' => $departamento, 'request' => $request]);

    }

    public function busca(Request $request)
    {


        //dd($request);

        $produtos = DB::connection('mysql_loja')->select('

        select   PR.CdProduto, PR.NmProduto, PR.TxProduto, PC.CdReferencia,
			min(PP.VlPreco) as VlPrecoMin, max(PP.VlPreco) as VlPrecoMax,
			PF.NmFoto,
			if(PF.NmFoto is null, 0,1) as StFoto
        from produto PR
        join produto_detalhe PD on (PR.CdProduto = PD.CdProduto)
        join produto_preco PP on (PP.CdProduto = PR.CdProduto and PP.CdDetalhe = PD.CdDetalhe )
        join produto_estoque PE on (PE.CdProduto = PD.CdProduto and PE.CdDetalhe = PD.CdDetalhe and PE.CdEstabel = ? )
        join produto_codigo PC on (PD.CdProduto = PC.CdProduto and PD.CdDetalhe = PC.CdDetalhe and PC.StPrincipal = 1 )
        left join produto_foto PF on (PF.CdProduto = PR.CdProduto and PF.StPrincipal = 1)

        join produto_x_departamento GX on (GX.CdProduto = PR.CdProduto)
        join produto_departamento GR on (GR.CdDepartamento = GX.CdDepartamento)
        left join produto_departamento SG on (GR.CdDepartamentoPai = SG.CdDepartamento)

        where PR.DtDesativacao is null
        and PP.CdTabela in (?)
        and (PR.NmProduto like "%'.$request->busca.'%" OR PR.TxProduto like "%'.$request->busca.'%")
        and PR.StLojaVirtual = 1

        group by PR.CdProduto
        order by
                 '.(isset($request->ordem) ? (
            $request->ordem == 'A' ?  'PR.NmProduto ASC' : (
            $request->ordem == 'Z' ?  'PR.NmProduto DESC' : (
            $request->ordem == '0' ?  'min(PP.VlPreco) ASC' : (
            $request->ordem == '9' ?  'min(PP.VlPreco) DESC' : (
            "StFoto desc, PR.DtAtualizacao desc, rand()"
            )
            )
            )
            )
            ) : "StFoto desc, PR.DtAtualizacao desc, rand()").'


        ', [Session::get('loja_estabelecimento'),Session::get('loja_tabelas'), $request->busca, $request->busca]);






        $view = 'front.'.Session::get('loja').'.busca';

        //$paginacao = $this->arrayPaginator($produtos, $request);

        //dd($paginacao);

        return view($view, ['produtos' => $produtos, 'request' => $request]);

    }

    public function produto(Request $request, $id,$nome)
    {


        $produtos = DB::connection('mysql_loja')->select('

        select   PR.CdProduto, PR.NmProduto, PR.TxProduto, PC.CdReferencia,
			min(PP.VlPreco) as VlPrecoMin, max(PP.VlPreco) as VlPrecoMax,
			PF.NmFoto,
			if(PF.NmFoto is null, 0,1) as StFoto, GX.CdDepartamento as CdDepartamento
        from produto PR
        join produto_detalhe PD on (PR.CdProduto = PD.CdProduto)
        left join produto_preco PP on (PP.CdProduto = PR.CdProduto and PP.CdDetalhe = PD.CdDetalhe )
        left join produto_estoque PE on (PE.CdProduto = PD.CdProduto and PE.CdDetalhe = PD.CdDetalhe and PE.CdEstabel = ? )
        join produto_codigo PC on (PD.CdProduto = PC.CdProduto and PD.CdDetalhe = PC.CdDetalhe and PC.StPrincipal = 1 )
        left join produto_foto PF on (PF.CdProduto = PR.CdProduto and PF.StPrincipal = 1)

        join produto_x_departamento GX on (GX.CdProduto = PR.CdProduto)
        join produto_departamento GR on (GR.CdDepartamento = GX.CdDepartamento)
        left join produto_departamento SG on (GR.CdDepartamentoPai = SG.CdDepartamento)

        where PR.DtDesativacao is null
        and PP.CdTabela in (?)
        and PR.CdProduto = ?
        and PR.StLojaVirtual = 1

        group by PR.CdProduto
        limit 1;

        ', [Session::get('loja_estabelecimento'),Session::get('loja_tabelas'),$id]);

        $produtos_fotos = DB::connection('mysql_loja')->select('
            select * from produto_foto
            where CdProduto = ?
            order by StPrincipal desc

        ', [$id]);



        $produto_detalhe = DB::connection('mysql_loja')->select('
            select 	PD.*, PE.QtEstoque, PC.CdReferencia,
                        (select max(VlPreco) from produto_preco where CdTabela in(?) and CdProduto = PD.CdProduto and CdDetalhe = PD.CdDetalhe ) as VlVenda,
                        (select min(VlPreco) from produto_preco where CdTabela in(?) and CdProduto = PD.CdProduto and CdDetalhe = PD.CdDetalhe ) as VlPromocional
            from produto_detalhe PD
            join produto_codigo PC on (PD.CdProduto = PC.CdProduto and PD.CdDetalhe = PC.CdDetalhe and PC.StPrincipal = 1 )
            left join produto_estoque PE on (PE.CdEstabel = ? and PE.CdProduto = PD.CdProduto and PE.CdDetalhe = PD.CdDetalhe)

            where PD.StDetalhe = 1
            and PD.CdProduto = ?

            group by PD.CdProduto, PD.CdDetalhe
            order by PD.NuOrdem, PD.CdDetalhe;
        ', [Session::get('loja_tabelas'),Session::get('loja_tabelas'),Session::get('loja_estabelecimento'), $id]);

        //dump($produtos,$produto_detalhe);

        $produtos_outros = DB::connection('mysql_loja')->select('

        select   PR.CdProduto, PR.NmProduto, PR.TxProduto, PC.CdReferencia,
			min(PP.VlPreco) as VlPrecoMin, max(PP.VlPreco) as VlPrecoMax,
			PF.NmFoto,
			if(PF.NmFoto is null, 0,1) as StFoto
        from produto PR
        join produto_detalhe PD on (PR.CdProduto = PD.CdProduto)
        join produto_preco PP on (PP.CdProduto = PR.CdProduto and PP.CdDetalhe = PD.CdDetalhe )
        join produto_estoque PE on (PE.CdProduto = PD.CdProduto and PE.CdDetalhe = PD.CdDetalhe and PE.CdEstabel = ? )
        join produto_codigo PC on (PD.CdProduto = PC.CdProduto and PD.CdDetalhe = PC.CdDetalhe and PC.StPrincipal = 1 )
        left join produto_foto PF on (PF.CdProduto = PR.CdProduto and PF.StPrincipal = 1)

        join produto_x_departamento GX on (GX.CdProduto = PR.CdProduto)
        join produto_departamento GR on (GR.CdDepartamento = GX.CdDepartamento)
        left join produto_departamento SG on (GR.CdDepartamentoPai = SG.CdDepartamento)

        where PR.DtDesativacao is null
        and PP.CdTabela in (?)
          and PR.StLojaVirtual = 1

        and PR.CdProduto <> ?
        group by PR.CdProduto
        order by StFoto desc, rand()
        limit 8;

        ', [Session::get('loja_estabelecimento'),Session::get('loja_tabelas'), $id]);



       // dd(Session::get('loja'),$produtos,$produtos_outros);

        $view = 'front.'.Session::get('loja').'.produto';

        //$paginacao = $this->arrayPaginator($produtos, $request);

        //dd($paginacao);

        return view($view, ['produtos' => $produtos, 'produto_detalhe' => $produto_detalhe, 'produto_fotos' => $produtos_fotos, 'produtos_outros' => $produtos_outros, 'request' => $request]);

    }

}
