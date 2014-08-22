@extends('layout.master')

@section('content')
    <h1>Kupong {{ $coupon->name }}</h1>
    <div class="row row-margin">
        <div class="col-xs-12 col-xs-8">
            <h4>Uppdateras automatiskt om <span class="update-seconds">20</span>sekunder..</h4>
        </div>
        <div class="col-xs-12 col-xs-4">
            <label for="share-link">Dela kupongen till dina vänner</label>
            <input type="text" id="share-link" class="form-control" readonly value="{{ Request::url() }}" />
            <label for="no-sound">Stäng av ljud</label>
            <input type="checkbox" id="no-sound"/>
        </div>
    </div>
    <div id="coupon-wrapper" data-id="{{ $coupon->id }}">
        @include('/coupon/partials/_show_coupon')
    </div>
@stop