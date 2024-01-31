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
                    @forelse($transactions as $date => $transaction)
                    <div class="flex text-center gap-3 mb-3 mt-3">
                        <span class="fw-bold fs-5">
                            {{ $date }}
                        </span>
                        <a class="rounded-full btn btn-primary mx-3" target="_blank" href="{{ route('transaksi-harian', $date) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-arrow-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708z"/>
                                <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                            </svg>
                        </a>
                    </div>
                    @foreach($transaction as $report)
                    
                    <div class="card mt-2 text-bg-dark">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10">
                                    <div class="fw-bold">{{$report->order_id}} || {{$report->status}} || {{$report->created_at}}</div>
                                    <div>{{ $report->product->name}} ({{$report->quantity}}) * {{ $report->product->price}}</div>
                                </div>
                                @if($report->status == 'diambil')
                                <div class="col">
                                    <div class="col d-flex justify-content-end align-items-center">
                                        <a href="{{ route('download', $report->order_id) }}" class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-arrow-down" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708z"/>
                                                <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @empty
                    <span class="btn text-center">Keranjang kosong</span>
                    @endforelse
                </div>

                {{-- Dompet --}}
                <div class="col">
                    <h1>Mutasi Wallet</h1>
                    @forelse($wallets as $date => $wallet)
                    <div class="flex text-center gap-3 mb-3 mt-3">
                        <span class="fw-bold fs-5">
                            {{ $date }}
                        </span>
                    </div>
                    @foreach($wallet as $mutasi) 
                    @if ($mutasi->status == 'diterima')
                    <div class="card mt-2 text-bg-success">
                        <div class="card-body">
                            <div class="fw-bold">{{$mutasi->desc}} || {{$mutasi->status}} || {{$mutasi->created_at}}</div>
                            <div>{{ $mutasi->credit ? '+':''}}{{$mutasi->credit}} {{ $mutasi->debit ? '-':''}}{{$mutasi->debit}}</div>
                        </div>
                    </div>
                    @endif
                    @if ($mutasi->status =='proses')
                    <div class="card mt-2 text-bg-warning">
                        <div class="card-body">
                            <div class="fw-bold">{{$mutasi->desc}} || {{$mutasi->status}} || {{$mutasi->created_at}}</div>
                            <div>{{ $mutasi->credit ? '+':''}}{{$mutasi->credit}} {{ $mutasi->debit ? '-':''}}{{$mutasi->debit}}</div>
                        </div>
                    </div>
                    @endif
                    @if($mutasi->status =='ditolak')
                    <div class="card mt-2 text-bg-danger">
                        <div class="card-body">
                            <div class="fw-bold">{{$mutasi->desc}} || {{$mutasi->status}} || {{$mutasi->created_at}}</div>
                            <div>{{ $mutasi->credit ? '+':''}}{{$mutasi->credit}} {{ $mutasi->debit ? '-':''}}{{$mutasi->debit}}</div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @empty
                    <span>Mutasi Kosong</span>
                    @endforelse
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
