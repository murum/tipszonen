@extends('layout.admin')

@section('content')
    <h1>Adminpanel</h1>
    {{ link_to_route('admin.liverattning', 'Kuponger', null, ['class' => 'btn btn-lg btn-success']) }}
    {{ link_to_route('admin.users', 'Medlemmar', null, ['class' => 'btn btn-lg btn-success']) }}

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