@extends('layout.master')

@section('content')
    <h1>Uppladdningen av filen klar!</h1>
    @if($svs_button)
        <a class="btn btn-lg btn-success" target="_blank" href="{{$coupon->play_url}}">
            Spela kupongen på svenska spel för {{ $coupon->cost }}kr
        </a>
    @endif
    <a class="btn btn-primary" href="{{ route('coupon.show', ['id' => $coupon->id] ) }}">
        Visa kupong
    </a>
@stop