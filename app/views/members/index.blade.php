@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-7">
            <h2>Tipszonens medlemmar</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Medlem</th>
                        <th>Medlem sedan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr>
                            <td>
                                <a href="{{ route('member.show', [$member->id]) }}">
                                    {{ $member->username }}
                                </a>
                            </td>
                            <td>{{ relative_time($member->created_at) }}</td>
                            <td>
                                <a href="{{ route('member.show', [$member->id]) }}">
                                    <i class="fa fa-user"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-sm-offset-1 col-xs-12 col-sm-4">
            <h3>Saknar du ditt namn i listan?</h3>
            @include('user/partials/_register_form')
        </div>
    </div>
@stop