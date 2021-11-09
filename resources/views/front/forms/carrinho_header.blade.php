@section('carrinho_header')
    <li class="cart-item">
        <div class="cart-image">
            <a href="{{ route('front.produto', [$item->CdProduto, \Illuminate\Support\Str::slug($item->NmProduto)]) }}">
                @if($item->NmFoto == '')
                    <img style="max-height: 50px; max-width: 80px;" src="/assets/images/no-foto.jpg" alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}">
                @else
                    <img style="max-height: 50px; max-width: 80px;" src="{{\Illuminate\Support\Facades\Session::get('loja_imagens')}}{{ $item->NmFoto }}"  alt="{{$item->NmProduto}}" title="{{$item->NmProduto}}">
                @endif
            </a>
        </div>
        <div class="cart-title">
            <a href="single-product.html"><h4>{{ $item->NmProduto }}</h4></a>
            <span class="quantity">{{$item->QtProduto}} ×</span>
            <div class="price-box"><span class="new-price">R$ {{ number_format($item->VlPrecoTotal, 2, ',', '.') }}</span></div>
        </div>
    </li>
@endsection
