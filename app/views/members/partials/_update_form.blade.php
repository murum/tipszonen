{{ Form::model($member, ['route' => ['member.update', $member->id], 'class' => 'form-horizontal', 'method' => 'post']) }}
<div class="form-group">
    <div class="col-xs-12">
        {{ Form::label('svs_card', 'Kortnummer (Svenska spel)', ['class' => 'control-label']) }}
        {{ Form::text('svs_card', null, ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group">
    <div class="col-xs-12">
        {{ Form::submit('Spara', ['class' => 'btn btn-success']) }}
    </div>
</div>
{{ Form::close() }}