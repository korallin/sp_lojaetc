<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$a = session_id();
if ($a == '') session_start();
if (!isset($_SESSION['safety']))
{
    session_regenerate_id(true);
    $_SESSION['safety'] = true;
}
$_SESSION['lojaetc_id'] = session_id();


if (strpos(request()->getHttpHost(),"pardal") !== false) {
    config(['database.connections.mysql_loja.database' => 'spcommerce_pardal']);
    config(['database.connections.mysql.database' => 'spcommerce_pardal']);
    Session::put('loja', 'pardal');
    Session::put('loja_email', 'contato@pardal.com.br');
    Session::put('loja_cep', '25730745');
    Session::put('loja_transportadora', ['Correios', 'Jamef', 'Braspress']);
    Session::put('loja_whatsapp', '24 98815-2465');
    Session::put('loja_estabelecimento', 1);
    Session::put('loja_base', 'spcommerce_pardal');
    Session::put('loja_tabelas', '1,2');
    Session::put('loja_caixa', 90);
    Session::put('loja_cielo_estabelecimento', '2810607545');
    Session::put('loja_cielo_merchantid', '7d514873-b94e-429f-baa0-d8108f816bc4');
    Session::put('loja_cielo_softdescriptor', 'PARDALTEC');
    Session::put('loja_imagens', 'https://d.spcommerce.com.br/pardal/produto/');
    Session::put('loja_banners', 'https://d.spcommerce.com.br/pardal/publicidade/');

    /*

     #cielo
     033.271.427-69
     senha:219010
     */

}

if (strpos(request()->getHttpHost(),"casaverde") !== false) {
    config(['database.connections.mysql_loja.database' => 'spcommerce_casaverde']);
    config(['database.connections.mysql.database' => 'spcommerce_casaverde']);
    Session::put('loja', 'casaverde');
    Session::put('loja_email', 'contatotramahome@gmail.com');
    Session::put('loja_cep', '25730745');
    Session::put('loja_transportadora', ['Correios']);
    Session::put('loja_whatsapp', '24 98815-2465');
    Session::put('loja_estabelecimento', 4);
    Session::put('loja_base', 'spcommerce_casaverde');
    Session::put('loja_tabelas', '1,2');
    Session::put('loja_caixa', 90);
    Session::put('loja_imagens', 'https://d.spcommerce.com.br/gsacessorios/produto/');
}

if (strpos(request()->getHttpHost(),"tramahome") !== false) {
    config(['database.connections.mysql_loja.database' => 'spcommerce_tramahome']);
    config(['database.connections.mysql.database' => 'spcommerce_tramahome']);
    Session::put('loja', 'tramahome');
    Session::put('loja_email', 'contatotramahome@gmail.com');
    Session::put('loja_cep', '25730745');
    Session::put('loja_transportadora', ['Correios']);
    Session::put('loja_whatsapp', '24 98815-2465');
    Session::put('loja_base', 'spcommerce_tramahome');
    Session::put('loja_estabelecimento', 1);
    Session::put('loja_caixa', 90);
    Session::put('loja_tabelas', '1,2');
    Session::put('loja_imagens', 'https://d.spcommerce.com.br/tramahome/produto/');
    Session::put('loja_banners', 'https://d.spcommerce.com.br/tramahome/publicidade/');
    Session::put('loja_pagseguro_token', 'a9c5e7b8-6747-4a20-81ee-db9e4be01d50e06c01214b21b970e28fce41f5ad2f3b8b6c-a0f3-48eb-bbdc-2047437f2c41');
    Session::put('loja_pagseguro_email', 'contatotramahome@gmail.com');
    Session::put('loja_pagseguro_ambiente', 'production');
}


Route::get('/', [\App\Http\Controllers\Front\WebControllerDB::class, 'home'])->name('front.home');

Route::get('/contato', [\App\Http\Controllers\Front\Paginas::class, 'contato'])->name('front.contato');
Route::get('/faleconosco', [\App\Http\Controllers\Front\Paginas::class, 'contato'])->name('front.faleconosco');

Route::post('/grava-contato', [\App\Http\Controllers\Front\Paginas::class, 'contato_grava'])->name('front.contato_grava');

Route::get('/pagina/{id}/{nome}', [\App\Http\Controllers\Front\Paginas::class, 'paginas'])->name('front.paginas');
Route::get('/departamento/{id}/{nome}', [\App\Http\Controllers\Front\WebControllerDB::class, 'departamento'])->name('front.departamento');
Route::get('/busca', [\App\Http\Controllers\Front\WebControllerDB::class, 'busca'])->name('front.busca');
Route::get('/{id}/{nome}', [\App\Http\Controllers\Front\WebControllerDB::class, 'produto'])->name('front.produto');

Route::get('/carrinho', [\App\Http\Controllers\Front\Carrinho::class, 'lista_carrinho'])->name('front.carrinho');
Route::post('/carrinho/add', [\App\Http\Controllers\Front\Carrinho::class, 'add'])->name('front.carrinho_add');
Route::post('/carrinho/atz', [\App\Http\Controllers\Front\Carrinho::class, 'atz'])->name('front.carrinho_atz');
Route::get('/carrinho/{produto}/{detalhe}', [\App\Http\Controllers\Front\Carrinho::class, 'exc'])->name('front.carrinho_exc');
Route::get('/fechar-compra', [\App\Http\Controllers\Front\Carrinho::class, 'checkout'])->name('front.checkout');
Route::post('/valida-venda', [\App\Http\Controllers\Front\Carrinho::class, 'valida_venda'])->name('front.valida_venda');
Route::get('/recibo', [\App\Http\Controllers\Front\Carrinho::class, 'recibo'])->name('front.recibo');

Route::get('/cliente-login', [\App\Http\Controllers\Front\Cliente::class, 'login'])->name('front.login');
Route::post('/login-senha', [\App\Http\Controllers\Front\Cliente::class, 'login_senha'])->name('front.login_senha');
Route::match(['post', 'get'], '/cliente-login-valida', [\App\Http\Controllers\Front\Cliente::class, 'login_valida'])->name('front.login_valida');
Route::match(['post', 'get'], '/cliente-area', [\App\Http\Controllers\Front\Cliente::class, 'cliente_area'])->name('front.cliente_area');
Route::match(['post', 'get'], '/cliente-area/exclui/endereco', [\App\Http\Controllers\Front\Cliente::class, 'exclui_endereco'])->name('front.exclui_endereco');
Route::match(['post', 'get'], '/cliente-logout', [\App\Http\Controllers\Front\Cliente::class, 'logout'])->name('front.logout');
Route::post('/cliente-cadastro', [\App\Http\Controllers\Front\Cliente::class, 'cadastro_temp'])->name('front.cadastro_temp');
Route::get('/cliente-cadastro-form', [\App\Http\Controllers\Front\Cliente::class, 'cadastro_form'])->name('front.cadastro_form');
Route::post('/cliente-cadastro-form-grava', [\App\Http\Controllers\Front\Cliente::class, 'cadastro_grava'])->name('front.cadastro_grava');
Route::post('/cliente-cadastro-edita-grava', [\App\Http\Controllers\Front\Cliente::class, 'cadastro_edita'])->name('front.cadastro_edita');

//apis
# retorno cielo
Route::any('/retorno-cielo', [\App\Http\Controllers\CieloCheckout::class, 'retorno'])->name('retorno.cielo');
Route::any('/retorno-pagseguro', [\App\Http\Controllers\PagSeguroController::class, 'retorno'])->name('retorno.pagseguro');
Route::any('/retorno-pagseguro-auto', [\App\Http\Controllers\PagSeguroController::class, 'verificaNotificacao'])->name('retorno.pagseguro_auto');

# cep
Route::post('/cep', [\App\Http\Controllers\Auxiliar::class, 'cep_f'])->name('front.cep');
Route::post('/frete', [\App\Http\Controllers\FreteNet::class, 'consulta'])->name('front.frete');
Route::post('/salva-endereco', [\App\Http\Controllers\Front\Cliente::class, 'salva_endereco'])->name('front.salva_endereco');
Route::get('/troca-endereco', [\App\Http\Controllers\Front\Cliente::class, 'troca_endereco'])->name('front.troca_endereco');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
