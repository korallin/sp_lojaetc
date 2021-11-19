<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request)
    {


        //dump($_SESSION['lojaetc_id'],session()->getId());

        $departamentos = DB::connection('mysql_loja')->select('
            select 	GX.CdDepartamento, GR.CdDepartamento, GR.CdDepartamentoPai, GR.NmDepartamento, SG.NmDepartamento,
			if(GR.CdDepartamentoPai is not null, GR.CdDepartamentoPai, GR.CdDepartamento ) as CdGrupo,
			if(GR.CdDepartamentoPai is not null, SG.NmDepartamento, GR.NmDepartamento ) as NmGrupo
            from produto PR
            join produto_estoque PE on (PE.CdProduto = PR.CdProduto and PE.CdEstabel = ?  )
            join produto_x_departamento GX on (GX.CdProduto = PR.CdProduto)
            join produto_departamento GR on (GR.CdDepartamento = GX.CdDepartamento)
            left join produto_departamento SG on (GR.CdDepartamentoPai = SG.CdDepartamento)
            where PR.DtDesativacao is null

            group by CdGrupo
            order by NmGrupo;

        ', [Session::get('loja_estabelecimento')]);



        $produtos_populares = DB::connection('mysql_loja')->select('

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
        group by PR.CdProduto
        order by StFoto desc, PR.DtAtualizacao desc, rand() limit 3;

        ', [Session::get('loja_estabelecimento'),Session::get('loja_tabelas')]);

        $paginas_bl1 = DB::connection('mysql_loja')->select('

            select * from mensagem
            where CdTipo = 1
            and CdEstabel = ?
            and StMensagem = 1
            limit 3
        ', [Session::get('loja_estabelecimento')]);

        $paginas_bl2 = DB::connection('mysql_loja')->select('

            select * from mensagem
            where CdTipo = 1
            and CdEstabel = ?
            and StMensagem = 1
            limit 3,8
        ', [Session::get('loja_estabelecimento')]);

        $produtos_carrinho = DB::connection('mysql_loja')->select('
        select  	PT.CdTemp, PR.CdProduto, PR.CdUnidade, PR.NmProduto, PR.NuNcm, PD.PsProduto,
                    PF.NmFoto,
                    if(PF.NmFoto is null, 0,1) as StFoto,
                    UN.NmUnidade, UN.StFracionario, PD.CdDetalhe, PD.NmDetalhe,
                    PT.CdReferencia, PT.QtProduto, PT.VlPreco, PT.VlDesconto, PT.PcDesconto,
                    (PT.QtProduto * (PT.VlPreco - PT.VlDesconto) ) as VlPrecoTotal
        from produto_temp PT
        join produto_detalhe PD on (PT.CdProduto = PD.CdProduto and PT.CdDetalhe = PD.CdDetalhe)
        join produto PR on (PT.CdProduto = PR.CdProduto)
        join produto_unidade UN on (UN.CdUnidade = PR.CdUnidade)
        left join produto_foto PF on (PF.CdProduto = PR.CdProduto and PF.StPrincipal = 1)
        where PT.CdEstabel = ?
        and PT.CdMovimento = 9
            and PT.NuSessao = ?
        and PR.StLojaVirtual = 1
        group by PT.CdProduto, PT.CdDetalhe
        order by PT.CdTemp;
        ', [Session::get('loja_estabelecimento'), $_SESSION['lojaetc_id']]);

        $total = 0;
        $itens = 0;
        $produtos = array();

        foreach($produtos_carrinho as $item){
            $total += $item->VlPrecoTotal;
            $itens += $item->QtProduto;
            $produtos[] = $item;
        }

        $dado_carrinho = [];
        $dado_carrinho['cart_total'] = $total;
        $dado_carrinho['cart_frete'] = 0;
        $dado_carrinho['cart_itens'] = $itens;
        $dado_carrinho['cart_produtos'] = $produtos;

       // dd(Session::get('loja_estabelecimento'),$_COOKIE, session()->getId(),$dado_carrinho,$produtos_carrinho,session());

        view()->share(['departamentos' => $departamentos, 'produtos_populares' => $produtos_populares, 'paginas_bl1' => $paginas_bl1, 'paginas_bl2' => $paginas_bl2, 'dado_carrinho' => $dado_carrinho]);
    }

}
