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
                        <li class="breadcrumb-item active">Fale Conosco</li>
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
                    <h4 class="content-text mb-1">Telefone</h4>
                    <p class="mb-3 pt-0">
                        <i class="fas fa-phone"></i> (24) 2248-3799<br>
                        <i class="fas fa-phone"></i> (24) 2248-3506 <bR>
                        <a href="https://api.whatsapp.com/send?phone=+5524988018819&text=Olá gostaria de um contato." target="_blank"><i class="fab fa-whatsapp"></i>  (24) 98801-8819</a>
                    </p>
                    <h4 class="content-text mb-1">E-mail</h4>
                    <p class="mb-3 pt-0"><a href="mailto:{{ $estabel->NmEmail }}"><i class="fa fa-envelope"></i> {{ $estabel->NmEmail }}</p></a>
                    <h4 class="content-text mb-1">Endereço</h4>
                    <p class="mb-3 pt-0"><i class="fa fa-map-marker"></i> {{ $estabel->NmEndereco }} {{ $estabel->NuEndereco }} {{ $estabel->NmCompleEnd }}
                        {{ $estabel->NmCidade }} / {{ $estabel->SgEstado }}</p>
                    <h4 class="content-text mb-1">Horario de funcionamento</h4>
                    <p class="mb-3 pt-0"><i class="far fa-clock"></i> Seg. a Qui. de 07 as 18:05h 12 as 13 almoço e Sex de 07 as 12:55</p>

                    <div class="google-map-area">
                        <div id="map-inner" class="map" style="max-height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-content-wrap end -->

@endsection

@section('js')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDz97C4R2FizQEK2h28RlQyJTBgFjY5Spc"></script>
    <script>
        function initMap() {
            const myLatLng = { lat: -22.53124836733058, lng: -43.17897331572471 };
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
