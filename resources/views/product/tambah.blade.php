@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card ">
                <div class="card-header text-bg-dark">Tambah Produk</div>

                <div class="card-body">
                    <form action="{{ route('product.store')}}" method="post">
                        @csrf
                        <label for="name">Nama Barang</label>
                        <input type="text" name="name" class="form-control">
                        <label for="price">Harga</label>
                        <input type="number" name="price" class="form-control">
                        <label for="stock">Stok</label>
                        <input type="number" name="stock" class="form-control">
                        <label for="photo">Photo</label>
                        <input type="text" name="photo" class="form-control">
                        <label for="desc">Desc Product</label>
                        <textarea name="desc" class="form-control" cols="30" rows="5"></textarea>
                        <div class="row d-grip gap-2 mt-2">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
