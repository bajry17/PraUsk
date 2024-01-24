@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-7">
                    <h1 class="fw-bold">Daftar Permintaan Saldo</h1>
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
                                    <label for="user_id">Nasabah</label>
                                    <select name="user_id" class="form-control">
                                        <option value=""><-- Pilih User --></option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="desc" value="Top Up">
                                    <input type="hidden" name="status" value="diterima">
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
                                <h1 class="modal-title fs-5" id="tariktunaiLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form action="{{ route('topup')}}" method="post">
                                    @csrf
                                    <label for="user_id">Nasabah</label>
                                    <select name="user_id" class="form-control">
                                        <option value=""><-- Pilih User --></option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="status" value="diterima">
                                    <input type="hidden" name="desc" value="Tarik Tunai">
                                    <label for="debit"></label>
                                    <input type="number" name="debit" class="form-control" value="10000" min="10000">
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
            <div class="row">
                @foreach($wallets as $wallet)
                <div class="col-6 mt-3">
                    <div class="card text-bg-dark">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="row">
                                        <div class="fw-bold">
                                        {{$wallet->user->name}}
                                        </div>
                                        <div class="col">{{$wallet->desc}} {{ $wallet->credit ? '+':''}}{{$wallet->credit}} {{ $wallet->debit ? '-':''}}{{$wallet->debit}}</div>
                                    </div>
                                </div>
                                <div class="col text-end">
                                    <div class="row">
                                        <div class="col">
                                            <form action="{{ route('acceptsaldo', $wallet->id)}}" method="post">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="id" value="{{$wallet->id}}">
                                                <button type="submit" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                                    <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                                </svg>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <form action="{{ route('cancelsaldo', $wallet->id)}}" method="post">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="id" value="{{$wallet->id}}">
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
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
