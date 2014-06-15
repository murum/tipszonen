@extends('layout.master')

@section('content')
    <h1>Uppdatera din profil</h1>
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            @include('members.partials._update_form')
        </div>
    </div>
@stop