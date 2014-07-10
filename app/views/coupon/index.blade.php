@extends('layout.master')

@section('content')
    <h1>Kuponger hos Tipszonen</h1>
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <h3>Snabbuppladdning med egna filer</h3>
            @include('coupon/partials/_create_coupon_file_form')

            <div class="spacer"></div>

            <div class="row">
                <div class="col-xs-12">
                    <h3>... eller skapa matematiskt system</h3>
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
                @foreach($recent_coupons as $coupon)
                    <a href="{{ route('coupon.show', ['id' => $coupon->id]) }}" class="list-group-item">
                        {{ $coupon->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@stop