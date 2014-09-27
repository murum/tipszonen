<!doctype html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Liverättning Svenskapspel - Lajvrättning.se</title>
    {{ HTML::style('/css/main.css') }}
</head>
<body>
    @include('layout.includes.master.nav')

    @include('partials/_flash')
    @include('partials/_errors')

    <div class="container">
        <div class="row content">
            <div class="col-xs-12">
                @yield('content')
            </div>
        </div>
    </div>

    @include('session/modals/_login')

    {{ HTML::script('/js/libs.js') }}
    {{ HTML::script('/js/main.js') }}
</body>
</html>