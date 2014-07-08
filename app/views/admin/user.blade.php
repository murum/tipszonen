@extends('layout.admin')

@section('content')
    <h1>{{$user->username}}</h1>
    {{ Form::model($user, ['route' => [ 'admin.users.post_single', $user->id ] ], ['class' => 'form-horizontal', 'role' => 'form']) }}

        <div class="form-group">
            {{ Form::label('Roller') }}
            {{ Form::select('roles[]', Role::lists('title', 'id'), $user->roles->lists('id'), array('class' => 'form-control', 'multiple')) }}
        </div>

        <div class="form-group">
            {{ Form::submit('Spara', ['class' => 'btn btn-success']) }}
        </div>
    {{ Form::close() }}
@stop