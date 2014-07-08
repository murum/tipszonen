@extends('layout.admin')

@section('content')
<h1>Rätta kuponger</h1>
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
<h2>Kommande omgångar</h2>
    <ul class="list-group">
        @foreach($coming_coupons as $coupon)
            <li class="list-group-item">
                {{
                    link_to_route(
                        'admin.liverattning.get_single',
                        $coupon->game_week.' - '.$coupon->product->name,
                        ['id' => $coupon->id],
                        ['class' => 'btn btn-lg btn-success btn-'.$coupon->product->slug]
                    )
                }}
            </li>
        @endforeach
    </ul>
<h2>Avslutade omgångar</h2>
    <ul class="list-group">
        @foreach($ended_coupons as $coupon)
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
@stop