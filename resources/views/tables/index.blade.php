@extends('layouts.app')

@section('content')
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />--}}
    {{--<link href="{{ asset('css/games-list.css') }}" rel="stylesheet">--}}
    <style>
        .custab{
            border: 1px solid #ccc;
            padding: 5px;
            margin: 5% 0;
            box-shadow: 3px 3px 2px #ccc;
            transition: 0.5s;
        }
        .custab:hover{
            box-shadow: 3px 3px 0px transparent;
            transition: 0.5s;
        }
    </style>
    <div class="container">
        <div class="row col-sm-6 col-md-8 col-md-offset-2 col-xl-12 custyle align-content-center">
            <table class="table table-striped custab">
                <thead>
                <span class="btn btn-primary btn-xs pull-right"><b> {{__('games.list.list')}}</b></span>
                <span class="btn btn-success btn-xs pull-right my-2"><b><a type="button" href="{{route('table.create')}}">{{__('buttons.new_game')}}</a></b></span>
                <tr>
                    <th>ID</th>
                    <th>{{__('players.players')}}</th>
                    <th>{{__('games.status.status')}}</th>
                    <th>{{__('players.rank')}}</th>
                    <th class="text-center">{{__('games.actions')}}</th>
                </tr>
                </thead>
                @foreach($tables as $table)
                    <tr>
                        <td>{{$table->id}}</td>
                        <td>
                            @if($table->board1())
                                <div style="color: {{$table->board1()->user->onlineStatus()['color']}};"><b>{{$table->board1()->user->name}}</b></div>
                            @else
                                <div><b>{{__('players.free')}}</b></div>
                            @endif

                            @if($table->board2())
                                <div style="color: {{$table->board2()->user->onlineStatus()['color']}};"><b>{{$table->board2()->user->name}}</b></div>
                            @else
                                <div><b>{{__('players.free')}}</b></div>
                            @endif

                        </td>
                        <td>{{$table->status['status']}}</td>
                        <td>{{$table->updated_at}}</td>
                        <td class="text-center">
                            <a class='btn btn-info btn-xs' href="{{route('table.show',[$table->id])}}"><span class="glyphicon glyphicon-edit"></span><b>{{__('games.enter')}}</b></a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
