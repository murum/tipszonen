@extends('layout.master')

@section('content')
    <h1>Kupong {{ $coupon->name }}</h1>
    <h4>Uppdateras automatiskt om <span class="update-seconds">20</span>sekunder..</h4>
    <div id="coupon-wrapper" data-id="{{ $coupon->id }}">
        @include('/coupon/partials/_show_coupon')
    </div>
@stop