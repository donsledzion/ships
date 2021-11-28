@extends('layouts.app')

@section('content')
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
                <span class="btn btn-primary btn-xs pull-right"><b> {{__('players.list')}}</b></span>
                <tr>
                    <th>ID</th>
                    <th>{{__('players.player')}}</th>
                    <th>{{__('players.status')}}</th>
                    <th>{{__('players.rank')}}</th>
                    <th class="text-center">{{__('players.actions')}}</th>
                </tr>
                </thead>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td><div id="status-{{$user->id}}" class="online-status" data-id="{{$user->id}}"><img src="storage/img/{{$user->onlineStatus()['color']}}-dot.png" style="width: 30px; height:30px;"/></div></td>
                    <td>{{$user->ranking}}</td>
                    <td class="text-center"><a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a> {{--<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a>--}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <script>
        const baseUrl = '{{url('')}}' ;
        const baseAsset ='{{asset('/storage/img/')}}';
    </script>
    @section('js-files')
        <script src="{{ asset('js/online-check.js') }}"></script>
    @endsection
@endsection
