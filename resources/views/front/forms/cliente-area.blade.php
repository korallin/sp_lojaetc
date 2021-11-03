@extends('front.'.\Illuminate\Support\Facades\Session::get('loja').'.master')

@section('css')

@endsection

@section('content')

    <div class="breadcrumb-area section-ptb" style="background: #ccc; height: 50px; padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col">

                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Área do Cliente</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->
    <!-- main-content-wrap start -->
    <div class="main-content-wrap section-ptb my-account-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="account-dashboard">
                        <div class="dashboard-upper-info">
                            <div class="row align-items-center no-gutters">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="d-single-info">
                                        <p class="user-name">Olá <span>{{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NmContato }}</span></p>
                                        <p>(não é {{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NmContato }}? <a href="{{ route('front.logout') }}">Saia aqui</a>.)</p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="d-single-info">
                                        <p>Precisa de ajuda? Nos chame no whatsapp.</p>
                                        <p>{{ \Illuminate\Support\Facades\Session::get('loja_whatsapp') }}.</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="d-single-info">
                                        <p>Nos mande um e-mail </p>
                                        <p>{{ \Illuminate\Support\Facades\Session::get('loja_email') }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <div class="d-single-info text-lg-center">
                                        <a href="{{ route('front.carrinho') }}" class="view-cart"><i class="fa fa-cart-plus"></i>Carrinho</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-2">
                                <!-- Nav tabs -->
                                <ul role="tablist" class="nav flex-column dashboard-list">
                                    <li><a href="#dashboard" data-toggle="tab" class="nav-link active">Minha Área</a></li>
                                    <li> <a href="#orders" data-toggle="tab" class="nav-link">Meus Pedidos</a></li>
                                    <li><a href="#address" data-toggle="tab" class="nav-link d-none">Meus Endereços</a></li>
                                    <li><a href="#account-details" data-toggle="tab" class="nav-link d-none">Meu Cadastro</a></li>
                                    <li><a href="{{ route('front.logout') }}" class="nav-link">Sair</a></li>
                                </ul>
                            </div>
                            <div class="col-md-12 col-lg-10">
                                <!-- Tab panes -->
                                <div class="tab-content dashboard-content">
                                    <div class="tab-pane active" id="dashboard">
                                        <h3>Minha Área </h3>
                                        <p>Olá, <span style="color:#b40d1a;">{{ \Illuminate\Support\Facades\Session::get('cliente')[0]->NmContato }}</span> </p>
                                        <p>No painel da sua conta, você pode verificar e visualizar facilmente seus pedidos recentes, gerenciar seus endereços de envio e cobrança e editar sua senha e detalhes de conta.</p>
                                    </div>
                                    <div class="tab-pane fade" id="orders">
                                        <h3>Pedidos</h3>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Pedido</th>
                                                    <th>Data</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($dados['vendas'] as $venda)
                                                <tr>
                                                    <td>{{$venda->CdVenda}}</td>
                                                    <td>{{ date('d/m/Y') }}</td>
                                                    <td>
                                                        @if($venda->CdSituacao == 1) <span class="badge badge-info">Aguardando Pagamento</span> @endif
                                                    </td>
                                                    <td>R$ {{ number_format($venda->VlVenda, 2, ',', '.') }}</td>
                                                    <td><a href="" class="view">Ver</a></td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="downloads">
                                        <h3>Downloads</h3>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Downloads</th>
                                                    <th>Expires</th>
                                                    <th>Download</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Khaki utility boiler jumpsuit</td>
                                                    <td>May 10, 2018</td>
                                                    <td>never</td>
                                                    <td><a href="#" class="view">Click Here To Download File</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Yellow button front tea top</td>
                                                    <td>Sep 11, 2018</td>
                                                    <td>never</td>
                                                    <td><a href="#" class="view">Click Here To Download File</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="address">
                                        <h3>Endereços </h3>
                                        <div class="table-responsive">
                                            <p>The following addresses will be used on the checkout page by default.</p>
                                            <address>
                                                <p><strong>David Malaan</strong></p>
                                                <p>1234 Market ##, Suite 900 <br>
                                                    Lorem Ipsum, ## 12345</p>
                                                <p>Mobile: (123) 123-456789</p>
                                            </address>
                                            <a href="#" class="view">Edit Address</a>

                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="account-details">
                                        <h3>Account details </h3>
                                        <div class="login">
                                            <div class="login-form-container">
                                                <div class="account-login-form">
                                                    <form action="#">
                                                        <p>Already have an account? <a href="#">Log in instead!</a></p>
                                                        <label>Social title</label>
                                                        <div class="input-radio">
                                                            <span class="custom-radio"><input type="radio" value="1" name="id_gender"> Mr.</span>
                                                            <span class="custom-radio"><input type="radio" value="1" name="id_gender"> Mrs.</span>
                                                        </div>
                                                        <div class="account-input-box">
                                                            <label>First Name</label>
                                                            <input type="text" name="first-name">
                                                            <label>Last Name</label>
                                                            <input type="text" name="last-name">
                                                            <label>Email</label>
                                                            <input type="text" name="email-name">
                                                            <label>Password</label>
                                                            <input type="password" name="user-password">
                                                            <label>Birthdate</label>
                                                            <input type="text" placeholder="MM/DD/YYYY" value="" name="birthday">
                                                        </div>
                                                        <div class="example">
                                                            (E.g.: 05/31/1970)
                                                        </div>
                                                        <div class="custom-checkbox">
                                                            <input type="checkbox" value="1" name="optin">
                                                            <label>Receive offers from our partners</label>
                                                        </div>
                                                        <div class="custom-checkbox">
                                                            <input type="checkbox" value="1" name="newsletter">
                                                            <label>Sign up for our newsletter<br><em>You may unsubscribe at any moment. For that purpose, please find our contact info in the legal notice.</em></label>
                                                        </div>
                                                        <div class="button-box">
                                                            <button class="btn default-btn" type="submit">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-content-wrap end -->

@endsection

@section('js')

@endsection
