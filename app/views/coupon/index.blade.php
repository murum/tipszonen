@extends('layout.master')

@section('content')
    <h1>Kuponger hos Tipszonen</h1>
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="row">
                <div class="col-xs-12">
                    <h3>Skapa ny kupong</h3>
                    <a class="btn btn-lg btn-success" href="{{ route('own_files') }}">
                        Med Egna Filer
                    </a>
                </div>
            </div>

            <div class="spacer"></div>

            <div class="row">
                <div class="col-xs-12">
                    @foreach($products as $product)
                        <a class="btn btn-lg btn-success btn-{{$product->slug}}" href="{{ route('coupon.new', [$product->id] ) }}">
                            {{ $product->name }}
                        </a>
                    @endforeach
                </div>
            </div>
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