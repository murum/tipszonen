<!doctype html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Tipszonen.se</title>
    {{ HTML::style('/css/main.css') }}
</head>
<body>
@include('layout.includes.admin.nav')

@include('partials/_flash')

<div class="container">
    <div class="row content">
        <div class="col-xs-12">
            @yield('content')
        </div>
    </div>
</div>
{{ HTML::script('/js/libs.js') }}
{{ HTML::script('/js/main.js') }}
</body>
</html>