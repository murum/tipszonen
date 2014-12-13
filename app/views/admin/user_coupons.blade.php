@extends('layout.admin')

@section('content')
    @if(count($coupons) > 0)
        <h2>Medlemskuponger</h2>
        <ul class="list-group">
            @foreach($coupons as $coupon)
            <li class="list-group-item">
                {{
                    link_to_route(
                        'admin.users.get_single',
                        $coupon->name,
                        ['id' => $coupon->id],
                        ['class' => 'btn btn-disabled btn-lg btn-success']
                    )
                }}
                <a class="pull-right btn btn-lg btn-danger coupon-remove" href="{{ route('admin.coupon.get_remove', $coupon->id) }}">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            </li>
            @endforeach
        </ul>
    @endif
@stop