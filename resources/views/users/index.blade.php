@extends('layouts.app')

@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="{{ asset('css/games-list.css') }}" rel="stylesheet">
    <div class="col-12 align-content-center mx-auto my-xl-5">
        <style>

        </style>
        <div class="event-schedule-area-two bg-color pad100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                            <div class="title-text">
                                <h2>{{__('games.list.header')}}</h2>
                            </div>
                            <p>
                                {{__('games.list.current')}}
                            </p>
                        </div>
                    </div>
                    <!-- /.col end-->
                </div>
                <!-- row end-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="home" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="text-center" scope="col">Id</th>
                                            <th scope="col">{{__('players.name')}}</th>
                                            <th scope="col">{{__('players.status')}}</th>
                                            <th scope="col">{{__('players.ranking')}}</th>
                                            <th class="text-center" scope="col">{{__('players.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                        <tr class="inner-box">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>#{{$user->id}}</span>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <div class="content-center">
                                                        <h3><a href="{{route('user.show',[$user->id])}}">{{$user->name}}</a></h3>
                                                    </div>
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" />

                                                </div>
                                            </td>
                                            <td>
                                                <div id="status-{{$user->id}}" class="online-status" data-id="{{$user->id}}">
                                                    {{--{{$user->onlineStatus()['message']}}--}}
                                                    <img src="storage/img/{{$user->onlineStatus()['color']}}-dot.png" style="width:30px; height: 30px;" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    Ranking: {{$user->ranking }}
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                    <!-- /col end-->
                </div>
                <!-- /row end-->
            </div>
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
