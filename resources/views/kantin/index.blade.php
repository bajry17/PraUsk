@extends('layouts.app')

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
                    <div class="col text-start"><h1>Selamat Datang, {{ Auth::user()->name}}</h1></div>
                    <div class="col">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reqbarang">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                        </svg>
                        </button>
        
                        <!-- Modal -->
                        <div class="modal fade" id="reqbarang" tabindex="-1" aria-labelledby="reqbarangLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="reqbarangLabel">Pengambilan Belanjaan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @foreach($accepts as $accept)
                                    <div class="card text-bg-dark mt-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="row">
                                                        <div class="fw-bold">
                                                            <div>
                                                                {{$accept->order_id}}
                                                            </div>
                                                            <div>
                                                                {{$accept->product->name}}({{$accept->quantity}}) * {{$accept->product->price}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col text-end">
                                                <div class="row">
                                                    <div class="col">
                                                        <form action="{{ route('accept')}}" method="post">
                                                            @csrf
                                                            @method('put')
                                                            <input type="hidden" name="id" value="{{$accept->id}}">
                                                            <button type="submit" class="btn btn-success">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                                                <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                                            </svg>  
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col">
                                                        <form action="{{ route('transaction.destroy',$accept->id)}}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger">
                                                            X
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
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-start">
                        <h2 class="fw-bold">PRODUCT</h2>
                    </div>
                    <div class="col">
                    </div>
                    <div class="col text-end    ">
                        <a href="{{ route('product.create')}}" class="btn btn-primary">Tambah</a>
                    </div>
                </div>     
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
                                        <div class="row">
                                            <div class="col">
                                                <a href="{{ route('product.edit', $product->id)}}" class="btn btn-warning">Edit</a>
                                            </div>
                                            <div class="col">
                                                <form action="{{ route('product.destroy', $product->id)}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>  
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
