@extends('layout.admin')

@section('content')
    <span id="admin-update-coupons"></span>
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
    <h2>Utdelning</h2>
    <ul class="list-group">
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <h4>Antal rätt</h4>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <h4>Vinst</h4>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <h4>Totalt antal rader</h4>
                </div>
            </div>
        </li>

        @foreach($coupon->dividends as $dividend)
        <li class="list-group-item">
            {{ Form::model( $dividend, [ 'route' => [ 'admin.liverattning.update.dividend', $dividend->id ], 'class' => 'form-horizontal' ] ) }}
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="input-group">
                            {{ Form::text('rights', null, ['class' => 'form-control', 'readonly' => true]) }}
                            <div class="input-group-addon">Rätt</div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-3">
                        <div class="input-group">
                            {{ Form::text('win', null, ['class' => 'form-control']) }}
                            <div class="input-group-addon">kr</div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-3">
                        <div class="input-group">
                            {{ Form::text('amount', null, ['class' => 'form-control']) }}
                            <div class="input-group-addon">st</div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-3">
                        {{ Form::submit('Spara', ['class' => 'pull-right btn btn-block btn-success']) }}
                    </div>
                </div>

            {{ Form::close() }}
        </li>
        @endforeach
    </ul>

    <span class="btn btn-lg btn-success btn-block" id="submit-all">Spara samtliga inmatningar<span>
@stop