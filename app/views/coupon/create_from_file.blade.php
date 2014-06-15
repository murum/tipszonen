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
                {{ Form::label('svs_card', 'Spelkortsnummer', ['class' => 'control-label']) }}
                @if( isset(Auth::user()->svs_card) )
                    {{ Form::text('svs_card', Auth::user()->svs_card, ['class' => 'form-control', 'readonly' => true]) }}
                @else
                    {{ Form::text('svs_card', null, ['class' => 'form-control']) }}
                    <span class="help-block">Du kan lägga till ditt spelkortsnummer genom din {{ link_to_route('member.edit', 'profil', Auth::user()->id ) }} för att slippa skriva in det varje gång du skapar en ny kupong.</span>
                @endif
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