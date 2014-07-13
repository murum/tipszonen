{{ Form::open( ['route' => 'search.coupon', 'method' => 'get'] ) }}
    <div class="input-group">
        {{Form::text( 'search', null, ['class' => 'form-control'] ) }}
        <div class="input-group-btn">
            {{ Form::submit('Sök', ['class' => 'btn btn-primary']) }}
        </div>
    </div>
{{ Form::close() }}