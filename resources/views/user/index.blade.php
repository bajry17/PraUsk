@extends('layouts.app_user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row">
                <div class="row">
                    <div class="col-7">
                        <div><h1>Selamat Datang, {{ Auth::user()->name}}</h1></div> 
                        <div><p class="opacity-75">Saldo Anda : Rp.{{number_format($saldo)}}</p></div>  
                    </div>
                    <div class="col">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#cart">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                            </svg>
                        </button>
        
                        <!-- Modal -->
                        <div class="modal fade" id="cart" tabindex="-1" aria-labelledby="cartLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="cartLabel">Keranjang</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                @foreach($carts as $cart)
                                    <div class="card text-bg-dark mt-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="row">
                                                        <div class="fw-bold">
                                                            <div>
                                                                {{$cart->order_id}}
                                                            </div>
                                                            <div>
                                                                {{$cart->product->name}}({{$cart->quantity}}) * {{$cart->product->price}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col text-end">
                                                    <div class="row">
                                                        <div class="col">
                                                            <form action="{{ route('paynow')}}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{$cart->product->id}}">
                                                                <input type="hidden" name="id" value="{{$cart->id}}">
                                                                <input type="hidden" name="quantity" value="{{$cart->quantity}}">
                                                                <button type="submit" class="btn btn-success">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                                                </svg>  
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#topup">
                        Top Up Saldo
                        </button>
        
                        <!-- Modal -->
                        <div class="modal fade" id="topup" tabindex="-1" aria-labelledby="topupLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="topupLabel">Top Up</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('topup')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                        <input type="hidden" name="desc" value="Top Up">
                                        <label for="credit"></label>
                                        <input type="number" name="credit" class="form-control" value="10000" min="10000">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tariktunai">
                        Tarik Tunai
                        </button>
        
                        <!-- Modal -->
                        <div class="modal fade" id="tariktunai" tabindex="-1" aria-labelledby="tariktunaiLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="tariktunaiLabel">Tarik Tunai</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form action="{{ route('topup')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                        <input type="hidden" name="desc" value="Tarik Tunai">
                                        <label for="debit"></label>
                                        <input type="number" name="debit" class="form-control" value="10000" min="10000" max="{{$saldo}}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div><h2 class="fw-bold">PRODUCT</h2></div>
                @foreach($products as $product)
                <div class="col-4">
                    <div class="card text-bg-dark">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <img height="150px" width="100%" src="{{ $product->photo }}" alt="">
                                </div>
                                <div class="col">
                                    <div class="fw-bold">{{ $product->name }}</div>
                                    <div>Rp. {{ number_format($product->price)}}</div>
                                    <div>Stok : {{$product->stock}}</div>
                                    <div class="opacity-50" style="font-size: 13px;">{{ $product->desc}}</div>
                                    <div class="mt-2">
                                        <form action="{{ route('AddToCart')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-7">
                                                    <input type="number" name="quantity" value="1" min="1" class="form-control">
                                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                                </div>
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary">+</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
