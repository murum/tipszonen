{{ Form::open(['route' => ['coupon.store', $coupon->id], 'class' => 'form form-horizontal']) }}
<div class="form-group">
    <div class="col-xs-12">
        {{ Form::label('name', 'Namn', ['class' => 'control-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control', 'required' => true]) }}
        {{ $errors->first('name', '<span class="text-danger">:message</span>') }}
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

<div class="hidden-xs coupon-headers">
    <div class="row">
        <div class="col-sm-offset-7 col-sm-3 text-center">
            <div class="col-xs-4">1</div>
            <div class="col-xs-4">X</div>
            <div class="col-xs-4">2</div>
        </div>
    </div>
</div>
<ul class="list-group" id="coupon-matches">
    @foreach($coupon->matches as $match)
    <li class="list-group-item">
        <div class="row">
            <div class="col-xs-1">
                {{ $match->matchnumber }}
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="col-xs-4">
                    {{ $match->home_team }}
                </div>
                <div class="col-xs-4">
                    {{ $match->away_team }}
                </div>
                <div class="col-xs-4">
                    {{ $match->coupon_format_start() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-3 text-center">
                <div class="col-xs-4">
                    <input type="checkbox" name="game{{ $match->matchnumber }}[]" value="1" />
                </div>
                <div class="col-xs-4">
                    <input type="checkbox" name="game{{ $match->matchnumber }}[]" value="X" />
                </div>
                <div class="col-xs-4">
                    <input type="checkbox" name="game{{ $match->matchnumber }}[]" value="2" />
                </div>
            </div>
        </div>
    </li>
    @endforeach
</ul>

<div id="rows-container" class="alert alert-danger">
    Din kupong är just nu på <span class="row-numbers">0</span> rader
</div>

<div id="coupon-submit-container">
    {{ Form::submit('Skapa kupong', ['class' => 'btn btn-success']) }}
    <span class="help-block">Ifall din kupong innehåller över många rader kan det ta några skunder att skapa kupongen.</span>
</div>
{{ Form::close() }}