@extends('layout.admin')

@section('content')
<h1>Adminpanel</h1>
    {{ link_to_route('admin.liverattning', 'Kuponger', null, ['class' => 'btn btn-lg btn-success']) }}
    {{ link_to_route('admin.users', 'Medlemmar', null, ['class' => 'btn btn-lg btn-success']) }}
    {{ link_to_route('admin.coupon', 'Medlemskuponger', null, ['class' => 'btn btn-lg btn-success']) }}

    {{-- OM DET FINNS NÅGRA PÅGÅENDE OMGÅNGAR--}}
    @if(isset($ongoing_coupons) && count($ongoing_coupons) > 0)
        <h2>Pågående omgångar</h2>
        <ul class="list-group">
            @foreach($ongoing_coupons as $coupon)
            <li class="list-group-item">
                {{
                    link_to_route(
                        'admin.liverattning.get_single',
                        $coupon->game_week.' - '.$coupon->product->name,
                        ['id' => $coupon->id],
                        ['class' => 'btn btn-disabled btn-lg btn-success btn-'.$coupon->product->slug]
                    )
                }}
            </li>
            @endforeach
        </ul>
    @endif
@stop