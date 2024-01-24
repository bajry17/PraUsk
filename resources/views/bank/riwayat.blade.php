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
                <div class="col">
                    <h1>Riwayat Transaksi</h1>
                    @foreach($transactions as $transaction)
                    <div class="card mt-2 text-bg-dark">
                        <div class="card-body">
                            <div>{{$transaction->user->name}}</div>
                            <div class="fw-bold">{{$transaction->order_id}} || {{$transaction->status}} || {{$transaction->created_at}}</div>
                            <div>{{ $transaction->product->name}} ({{$transaction->quantity}}) * {{ $transaction->product->price}}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col">
                    <h1>Mutasi Wallet</h1>
                    @foreach($wallets as $wallet)
                    @if ($wallet->status == 'diterima')
                    <div class="card mt-2 text-bg-success">
                        <div class="card-body">
                            <div>{{$wallet->user->name}}</div>
                            <div class="fw-bold">{{$wallet->desc}} || {{$wallet->status}} || {{$wallet->created_at}}</div>
                            <div>{{ $wallet->credit ? '+':''}}{{$wallet->credit}} {{ $wallet->debit ? '-':''}}{{$wallet->debit}}</div>
                        </div>
                    </div>
                    @endif
                    @if ($wallet->status =='proses')
                    <div class="card mt-2 text-bg-warning">
                        <div class="card-body">
                            <div>{{$wallet->user->name}}</div>
                            <div class="fw-bold">{{$wallet->desc}} || {{$wallet->status}} || {{$wallet->created_at}}</div>
                            <div>{{ $wallet->credit ? '+':''}}{{$wallet->credit}} {{ $wallet->debit ? '-':''}}{{$wallet->debit}}</div>
                        </div>
                    </div>
                    @endif
                    @if($wallet->status =='ditolak')
                    <div class="card mt-2 text-bg-danger">
                        <div class="card-body">
                            <div>{{$wallet->user->name}}</div>
                            <div class="fw-bold">{{$wallet->desc}} || {{$wallet->status}} || {{$wallet->created_at}}</div>
                            <div>{{ $wallet->credit ? '+':''}}{{$wallet->credit}} {{ $wallet->debit ? '-':''}}{{$wallet->debit}}</div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
    