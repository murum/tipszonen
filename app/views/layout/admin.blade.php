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

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-25789815-6', 'auto');
      ga('send', 'pageview');

    </script>
</body>
</html>