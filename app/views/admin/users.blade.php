@extends('layout.admin')

@section('content')
    @if(count($users) > 0)
        <h2>Användare</h2>
        <ul class="list-group">
            @foreach($users as $user)
            <li class="list-group-item">
                {{
                    link_to_route(
                        'admin.users.get_single',
                        $user->username,
                        ['id' => $user->id],
                        ['class' => 'btn btn-disabled btn-lg btn-success']
                    )
                }}
                <a class="pull-right btn btn-lg btn-danger user-remove" href="{{ route('admin.users.get_remove', $user->id) }}">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            </li>
            @endforeach
        </ul>
    @endif
@stop