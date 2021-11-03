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
                        <li class="breadcrumb-item active">Contato</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->
    <!-- main-content-wrap start -->
    <div class="main-content-wrap section-ptb contact-us-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="single_contact_now">
                        <div class="single_contact_now_inner">
                            <div class="single_contact_now_icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="single_contact_now_content">
                                <h3 class="content-text">Telefone</h3>
                                <p class="m-0 pt-2">+55 (24) 2248-3799</p>
                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="single_contact_now">
                        <div class="single_contact_now_inner">
                            <div class="single_contact_now_icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="single_contact_now_content">
                                <h3 class="content-text">E-mail</h3>
                                <p class="m-0 pt-2">contato@pardal.com.br</p>
                                <p>pardal@pardal.com.br</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="single_contact_now">
                        <div class="single_contact_now_inner">
                            <div class="single_contact_now_icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="single_contact_now_content">
                                <h3 class="content-text">Endereço</h3>
                                <p class="m-0 pt-2">Rua do Imperador 123</p>
                                <p>Petropolis / RJ</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div><br><br>
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-info-wrapper">
                        <h2>Deixe sua mensagem</h2>
                        <p>Entre em contato conosco preenchendo o formulário.</p>

                        <div class="contact-form-warp">
                            <form  action="" method="post">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <input type="text" name="name" placeholder="Nome Completo*" required>
                                    </div>
                                    <div class="col-lg-10">
                                        <input type="email" name="email" placeholder="E-mail *" required>
                                    </div>
                                    <div class="col-lg-10">
                                        <input type="phone" name="phone" placeholder="Celular*" required>
                                    </div>
                                    <div class="col-lg-10">
                                        <input type="text" name="subject" placeholder="Assunto*" required>
                                    </div>
                                    <div class="col-lg-10">
                                        <textarea name="message" placeholder="Sua Mensagem*"></textarea>
                                    </div>
                                </div>
                                <div class="contact-submit-btn">
                                    <button type="submit" class="submit-btn">ENVIAR</button>
                                    <p class="form-messege"></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="google-map-area">
                        <div id="map-inner" class="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-content-wrap end -->

@endsection

@section('js')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlZPf84AAVt8_FFN7rwQY5nPgB02SlTKs"></script>
    <script src="assets/map/map.js"></script>

@endsection
