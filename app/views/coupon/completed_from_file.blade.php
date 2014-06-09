@extends('layout.master')

@section('content')
    <h1>Uppladdningen av filen klar!</h1>
    <?php
        var_dump(file_get_contents($file));
    ?>
@stop