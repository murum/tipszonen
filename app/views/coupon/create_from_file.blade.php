@extends('layout.master')

@section('content')
    <h1>Skapa en kupong med egna filer.</h1>
    {{ Form::open(['route' => 'post_own_file', 'files' => true, 'class' => 'form form-horizontal']) }}

        <div class="form-group">
            <div class="col-xs-12">
                {{ Form::label('name', 'Namn', ['class' => 'control-label']) }}
                {{ Form::text('name', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                {{ Form::label('own_file', 'Fil', ['class' => 'control-label']) }}
                {{ Form::file('own_file', ['class' => 'form-control']) }}
            </div>
        </div>

        {{ Form::submit('Skapa kupong', ['class' => 'btn btn-success']) }}
    {{ Form::close() }}
@stop