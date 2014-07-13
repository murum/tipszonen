@extends('layout.master')

@section('content')
<h1>Sökresultat för '{{ $query }}'</h1>
<div class="row">
    <div class="col-xs-12 col-sm-8">
        <h3>Kuponger</h3>
        @foreach($coupons as $coupon)
            @include('coupon/partials/_coupon')
        @endforeach
    </div>
    <div class="col-xs-12 col-sm-4">
        <h3>Hitta kupong</h3>
        @include('coupon/partials/_search_coupon')

        <div class="spacer-40"></div>

        <h3>Skapa ny kupong</h3>
        @include('coupon/partials/_create_coupon_file_form')

        <div class="spacer"></div>

        <div class="row">
            <div class="col-xs-12">
                <h3>... eller skapa ett matematiskt</h3>
                @foreach(Product::all() as $product)
                <a class="btn btn-block btn-lg btn-success btn-{{$product->slug}}" href="{{ route('coupon.new', [$product->id] ) }}">
                    {{ $product->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop