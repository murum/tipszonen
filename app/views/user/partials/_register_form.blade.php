{{ Form::open(['route' => 'user.store', 'class' => 'form form-horizontal']) }}
<div class="form-group">
    <div class="col-xs-12">
        {{ Form::label('username', 'Användarnamn', ['class' => 'control-label']) }}
        {{ Form::text('username', null, ['class' => 'form-control']) }}
        {{ $errors->first('username', '<span class="text-danger">:message</span>') }}
    </div>
</div>

<div class="form-group">
    <div class="col-xs-12">
        {{ Form::label('email', 'E-post adress', ['class' => 'control-label']) }}
        {{ Form::text('email', null, ['class' => 'form-control']) }}
        {{ $errors->first('email', '<span class="text-danger">:message</span>') }}
    </div>
</div>
<div class="form-group">
    <div class="col-xs-12">
        {{ Form::label('email_confirmation', 'E-post adress igen', ['class' => 'control-label']) }}
        {{ Form::text('email_confirmation', null, ['class' => 'form-control']) }}
        {{ $errors->first('email_confirmation', '<span class="text-danger">:message</span>') }}
    </div>
</div>

<div class="form-group">
    <div class="col-xs-12">
        {{ Form::label('password', 'Lösenord', ['class' => 'control-label']) }}
        {{ Form::password('password', ['class' => 'form-control']) }}
        {{ $errors->first('password', '<span class="text-danger">:message</span>') }}
    </div>
</div>

<div class="form-group">
    <div class="col-xs-12">
        {{ Form::label('password_confirmation', 'Lösenord igen', ['class' => 'control-label']) }}
        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
        {{ $errors->first('password_confirmation', '<span class="text-danger">:message</span>') }}
    </div>
</div>

<div class="form-group">
    <div class="col-xs-12">
        {{ Form::submit('Registrera dig', ['class' => 'btn btn-success']) }}
    </div>
</div>
{{ Form::close() }}

<h2>Logga in utan registrering</h2>
{{ link_to_facebook('login-facebook', 'Logga in med facebook') }}