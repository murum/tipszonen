{{ Form::open(['route' => 'sessions.store', 'class' => 'form form-horizontal']) }}
<div class="form-group">
    <div class="col-xs-12">
        {{ Form::label('email', 'E-post adress', ['class' => 'control-label']) }}
        {{ Form::text('email', null, ['placeholder' => 'E-post adress', 'class' => 'form-control']) }}
    </div>
</div>

<div class="form-group">
    <div class="col-xs-12">
        {{ Form::label('password', 'Lösenord', ['class' => 'control-label']) }}
        {{ Form::password('password', ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group">
    <div class="col-xs-12">
        {{ Form::submit('Logga in', ['class' => 'btn btn-success']) }}
    </div>
</div>
{{ Form::close() }}

{{ link_to_facebook('login-facebook', 'Logga in med facebook') }}