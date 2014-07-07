@extends('layout.admin')

@section('content')
    <h1>Rätta kupongen</h1>
    <h2>Matcher</h2>
    <ul class="list-group">
        @foreach($coupon->matches as $match)
            <li class="list-group-item">
            {{ Form::model( $match, [ 'route' => [ 'admin.liverattning.update.match', $match->id ], 'class' => 'form-horizontal' ] ) }}
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="input-group">
                            <div class="input-group-addon">{{$match->home_team}}</div>
                            {{ Form::text('home_score', null, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="input-group">
                            <div class="input-group-addon">{{$match->away_team}}</div>
                            {{ Form::text('away_score', null, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-2">
                        <div class="input-group">
                            <div class="input-group-addon">Tid</div>
                            {{ Form::text('time', null, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-2">
                        <div class="checkbox">
                            <label for="ended">
                                {{ Form::checkbox('ended') }}
                                Avslutad
                            </label>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2">
                        {{ Form::submit('Spara', ['class' => 'pull-right btn btn-block btn-success']) }}
                    </div>
                </div>
            {{ Form::close() }}
            </li>
        @endforeach
    </ul>
@stop