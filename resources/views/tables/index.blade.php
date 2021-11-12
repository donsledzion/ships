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
                                            <th scope="col">{{__('games.player')}}</th>
                                            <th scope="col">{{__('games.status')}}</th>
                                            <th scope="col">{{__('games.player')}}</th>
                                            <th class="text-center" scope="col">{{__('games.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($boards as $board)
                                        <tr class="inner-box">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>#{{$board->table->id}}</span>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <div class="content-center">
                                                        <h3><a href="{{route('user.show',[$board->table->board1()->user->id])}}">{{$board->table->board1()->user->name}}</a></h3>
                                                    </div>
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" />

                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">

                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-img">
                                                    <div class="content-center">
                                                        <h3><a href="{{route('user.show',[$board->table->board2()->user->id])}}">{{$board->table->board2()->user->name}}</a></h3>
                                                    </div>
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="" />

                                                </div>
                                            </td>
                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="{{route('table.show',[$board->table->id])}}">Otwórz</a>
                                                </div>
                                                <div class="primary-btn my-2">
                                                    <a class="btn btn-success" href="{{route('table.lobby',[$board->table->id])}}">Lobby</a>
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
@endsection
