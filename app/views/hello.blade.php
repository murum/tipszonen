@extends('layout.master')

@section('content')
    <div class="jumbotron">
        <h1>Lajvrättning</h1>
        <h2>En del av Tipszonen.se</h2>
        <p>
            Här kan du ladda upp dina kuponger och samtidigt lämna in dem hos svenska spel.
            För att göra detta krävs det att du registrerar ett konto och loggar in.
        </p>
        <p>
            {{ link_to_route('register', 'Registrera dig', null, ['class' => 'btn btn-lg btn-success']) }}
            <span class="btn btn-lg btn-default" data-toggle='modal' data-target='#loginModal'>Logga in</span>
        </p>
    </div>
@stop