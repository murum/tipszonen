<table class="table table-responsive table-coupon">
    <thead>
    <tr>
        <th>#</th>
        <th>Startar</th>
        <th>Hemmalag</th>
        <th>Bortalag</th>
        <th>Resultat</th>
        <th>Tecken</th>
        <th>Tid</th>
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
        <td>{{$match->get_match_time()}}'</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6">
            <div class="help-block">
                Förklaring för färger
                <span class="match-help-not_started">Ej startat</span>
                <span class="match-help-on_going">Pågår</span>
                <span class="match-help-pause">Paus</span>
                <span class="match-help-ended">Avslutad</span>
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
                @foreach($coupon->coupon_detail->matches as $match)
                <th>
                    {{ $match->matchnumber }}
                </th>
                @endforeach
                <th class="text-right">Rätt</th>
                <th class="text-right">Kan få</th>
            </tr>
            </thead>
            <tbody>
            @foreach($best_rows as $row)
            <tr>
                @foreach($row['row'] as $match_number)
                <td>
                    @if(gettype($match_number['right']) == 'boolean')
                        <span class="{{ ($match_number['right']) ? 'match-help-on_going' : 'match-help-ended' }}">
                    @else
                        <span>
                    @endif

                        {{ $match_number['bet'] }}
                    </span>
                </td>
                @endforeach
                <td align="right">{{ $row['rights'] }}</td>
                <td align="right">{{ $row['potential'] }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-xs-12 col-sm-6">
        <h2>Utdelning.</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Totalt antal</th>
                <th>Din kupong</th>
                <th>Rätt</th>
                <th>Vinst</th>
            </tr>
            </thead>
            <tbody>
                @foreach($coupon->coupon_detail->dividends as $dividend)
                <tr>
                    <td>{{ number_format($dividend->amount, 0, '.', '.') }} st</td>
                    <td>{{ $coupon->get_rows_from_rights($dividend->rights) }} st</td>
                    <td>{{ $dividend->rights }} rätt</td>
                    <td>{{ number_format($dividend->win, 0, '.', '.') }} kr</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="alert {{ $win > 0 ? 'alert-success' : 'alert-danger' }}">
             {{ $win > 0 ? 'Din vinst' : 'Din förlust' }}: {{ $win }}kr
        </div>
    </div>
</div>