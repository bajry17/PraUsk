@extends('layouts.app')

@section('content')
<div class="container col-md-8">         
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @foreach ($reports as $report)
        <div class="card">
            <div class="card-header text-center fw-bold">
                {{ $report->user->name }}
            </div>
            <div class="card-body">
                <div class="fw-bold">
                    {{ $report->order_id }}
                </div>
                <div class="row">
                    <div class="col-6">
                        {{ $report->created_at }}
                    </div>
                    <div class="col-2">
                        {{ $report->product->name }}
                    </div>
                    <div class="col">
                        {{ $report->product->price }} x {{ $report->quantity}}
                    </div>
                </div>
            </div>
            @endforeach
            <div class="card-footer">
                <div class="row">
                    <div class="col-8"></div>
                    <div class="col">{{ $total }}</div>
                </div>
            </div>
        </div>
        <script>
            window.print();
        </script>
</div>
@endsection
