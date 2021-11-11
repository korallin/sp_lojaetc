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
                <div class="col-lg-6">
                    <div class="contact-info-wrapper">
                        <h2>Deixe sua mensagem</h2>
                        <p>Entre em contato conosco preenchendo o formulário.</p>

                        @if(\Session::has('sucesso'))
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ \Session::get('sucesso') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                </div>
                            </div>

                        @endif

                        <div class="contact-form-warp">
                            <form  action="{{ route('front.contato_grava') }}" method="post">
                                @csrf
                                @method('post')
                                <div class="row">
                                    <div class="col-lg-10">
                                        <input type="text" name="nome" value="{{ old('nome') }}" required="required" class="form-control input-lg {{ ($errors->has('nome') ? 'is-invalid' : '') }}" placeholder="Nome Completo*" required>
                                    </div>
                                    <div class="col-lg-10">
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control input-lg {{ ($errors->has('email') ? 'is-invalid' : '') }}" placeholder="E-mail *" required>
                                    </div>
                                    <div class="col-lg-10">
                                        <input type="phone" name="celular" value="{{ old('celular') }}" class="form-control celular input-lg {{ ($errors->has('celular') ? 'is-invalid' : '') }}" placeholder="Celular*" required>
                                    </div>
                                    <div class="col-lg-10">
                                        <input type="text" name="assunto" value="{{ old('assunto') }}" class="form-control input-lg {{ ($errors->has('assunto') ? 'is-invalid' : '') }}" placeholder="Assunto*" required>
                                    </div>
                                    <div class="col-lg-10">
                                        <textarea name="mensagem" required="required" class="form-control input-lg {{ ($errors->has('mensagem') ? 'is-invalid' : '') }}" placeholder="Sua Mensagem*">{{ old('mensagem') }}</textarea>
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

                    <h3 class="content-text mb-1">Telefone</h3>
                    <p class="mb-3 pt-0"> <i class="fa fa-phone"></i> {{ \App\Http\Controllers\Auxiliar::mask('(##) ####-#####', $estabel->NuTelefone) }}</p>
                    <h3 class="content-text mb-1">E-mail</h3>
                    <p class="mb-3 pt-0"><i class="fa fa-envelope"></i> {{ $estabel->NmEmail }}</p>
                    <h3 class="content-text mb-1">Endereço</h3>
                    <p class="mb-3 pt-0"><i class="fa fa-map-marker"></i> {{ $estabel->NmEndereco }} {{ $estabel->NuEndereco }} {{ $estabel->NmCompleEnd }}
                    {{ $estabel->NmCidade }} / {{ $estabel->SgEstado }}</p>


                    <div class="google-map-area">
                        <div id="map-inner" class="map" style="max-height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-content-wrap end -->

@endsection

@section('js')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDz97C4R2FizQEK2h28RlQyJTBgFjY5Spc"></script>
    <script src="/assets/js/jquery.mask.min.js" type="text/javascript"></script>

    <script>
        $(document).ready(function(e){

            $('.cep').mask('00.000-000');
            $('.telefone').mask('(00) 0000-0000');
            $('.celular').mask('(00) 0 0000-0000');
            $('.cpf').mask('000.000.000-00');
        });

        function initMap() {
            const myLatLng = { lat: -22.399577266514758, lng: -43.13381412592666 };
            const map = new google.maps.Map(document.getElementById("map-inner"), {
                zoom: 14,
                center: myLatLng,
            });

            new google.maps.Marker({
                position: myLatLng,
                map,
                title: "Trama Home",
            });
        }

        google.maps.event.addDomListener(window, 'load', initMap);
    </script>

@endsection
