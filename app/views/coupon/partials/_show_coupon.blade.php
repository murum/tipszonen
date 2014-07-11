<table class="table table-responsive table-coupon">
    <thead>
    <tr>
        <th>#</th>
        <th>Startar</th>
        <th>Hemmalag</th>
        <th>Bortalag</th>
        <th>Resultat</th>
        <th>Tecken</th>
    </tr>
    </thead>
    <tbody>
    @foreach($coupon->coupon_detail->matches as $match)
    <tr class="match match-{{ $match->get_match_status() }}">
        <td>{{ $match->matchnumber }}</td>
        <td>{{ $match->formated_start() }}</td>
        <td>{{ $match->home_team }}</td>
        <td>{{ $match->away_team }}</td>
        <td>{{ $match->home_score }} - {{ $match->away_score }}</td>
        <td>{{ $match->get_result() }}</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6">
            <div class="help-block">
                Förklaring för färger
                <span class="match-not_started">Ej startat</span>
                <span class="match-on_going">Pågår</span>
                <span class="match-pause">Paus</span>
                <span class="match-ended">Avslutad</span>
            </div>
        </td>
    </tr>
    </tfoot>
</table>
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <h2>Dina bästa rader.</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Rad</th>
                <th>Rätt</th>
            </tr>
            </thead>
            <tbody>
            @foreach($best_rows as $row)
            <tr>
                <td>{{ $row['row'] }}</td>
                <td>{{ $row['rights'] }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-xs-12 col-sm-6">
        <h2>Utdelning.</h2>
        @if( $has_dividends )
        <table class="table">
            <thead>
            <tr>
                <th>Antal</th>
                <th>Rätt</th>
                <th>Pris</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dividends as $dividend)
            <tr>
                <td>{{ $dividend['amount'] }})</td>
                <td>{{ $dividend['rights'] }}</td>
                <td>{{ $dividend['price'] }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="alert {{ $win > 0 ? 'alert-success' : 'alert-danger' }}">
            {{ $win > 0 ? 'Din vinst' : 'Din förlust' }}: {{ $win }}kr
        </div>
        @else
        <div class="alert alert-danger">
            Ingen utdelning ännu
        </div>
        @endif
    </div>
</div>