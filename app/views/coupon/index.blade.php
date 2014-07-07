@extends('layout.master')

@section('content')
    <h1>Kuponger hos Tipszonen</h1>
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <h3>Skapa ny kupong</h3>
            <a class="btn btn-lg btn-success" href="{{ route('own_files') }}">
                Med Egna Filer
            </a>
            <h4>(Under utveckling)</h4>
            @foreach($products as $product)
                <a class="disabled btn btn-lg btn-success" href="{{ route('coupon.new', [$product->id] ) }}">
                    {{ $product->name }}
                </a>
            @endforeach
        </div>
        <div class="col-xs-12 col-sm-4">
            <h3>Senaste kupongerna</h3>
            <div class="list-group">
                @foreach(Coupon::recent_coupons() as $coupon)
                    <a href="{{ route('coupon.show', ['id' => $coupon->id]) }}" class="list-group-item">
                        {{ $coupon->name }}
                        <span class="badge">{{ $coupon->coupon_rows->count() }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@stop