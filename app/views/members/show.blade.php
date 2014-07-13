@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-3">
            <img class="img-responsive img-rounded" src="{{ gravatar_url($member->email, false) }}" alt="User profile" />
            <div class="caption">
                <p>Profilbild från <a href="http://gravatar.com">Gravatar</a></p>
            </div>

            <ul class="list-group"l>
                <li class="list-group-item">Blev medlem för {{ relative_time($member->created_at) }}</li>
            </ul>
        </div>

        <div class="col-xs-12 col-sm-6">
            <h2>{{ $member->username }}</h2>
        </div>

        <div class="col-xs-12 col-sm-3">
            <h3>Kuponger</h3>
            @if( $member->hasCoupons() )
                @foreach($member->coupons as $coupon)
                    @include('coupon/partials/_coupon')
                @endforeach
            @else
                <div class="alert alert-info">
                    Användaren har inte skapat några kuponger.
                </div>
            @endif
        </div>
    </div>
@stop