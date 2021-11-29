@extends('layouts.app')

@section('header')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <link href="{{asset('css/table.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <style>

    </style>

    <div class="table-container">
        <div class="board-container">
                <div id="board1" class="board">
                    @if($table->board1())
                        @if($table->board1()->initialized)
                        <div class="player-label">
                            <span id="player_1" data-id="{{$table->board1()->user->id}}" @if($table->current_player==$table->board1()->user->id) class="current-player"@endif>
                                {{$table->board1()->user->name}}
                            </span>
                        </div>

                        <div>
                        <div class="single-box box-label"></div>
                        @for($header_col = "A" ; $header_col <= "J" ; $header_col++)
                            <div class="single-box box-label">{{$header_col}}</div>
                        @endfor
                        </div>
                        @for($body_row = 1 ; $body_row <= 10 ; $body_row++)
                            <div>
                            <div class="single-box box-label">{{$body_row}}</div>
                            @for($body_col = "A" ; $body_col <= "J" ; $body_col++)
                                <div id="{{$table->board1()->id}}_{{$body_col}}_{{$body_row}}" data-x="{{$body_col}}" data-y="{{$body_row}}" data-board_id="{{$table->board1()->id}}" class="single-box">
                                    @if(json_decode($table->board1()->fieldss,true)[$body_col][$body_row]=="@")
                                        <img id="theImg" src="{{asset('/storage/img/cross-green.png')}}" style="width:100%; height: 100%; object-fit: cover;" />
                                    @elseif(json_decode($table->board1()->fieldss,true)[$body_col][$body_row]=="#")
                                        <img id="theImg" src="{{asset('/storage/img/cross-red.png')}}" style="width:100%; height: 100%; object-fit: cover;" />
                                    @elseif(json_decode($table->board1()->fieldss,true)[$body_col][$body_row]=="*")
                                        <img id="theImg" src="{{asset('/storage/img/missed.png')}}" style="width:100%; height: 100%; object-fit: cover;" />
                                    @endif
                                </div>
                            @endfor
                            </div>
                        @endfor
                    @elseif($table->board1()->user->id == Auth::id())
                        <button class="create-button btn btn-success"><a href="{{route('board.edit',[$table->board1()->id])}}"><b>STWÓRZ</b></a></button>
                    @else
                        <button class="create-button btn btn-success"><b>{{$table->board1()->user->name}} {{__('players.creates_board')}}</b></button>
                    @endif
                @elseif((($table->board2())&&($table->board2()->user->id != Auth::id()))||($table->boards->count() == 0 ))
                    <form method="post" action="{{route('table.join',[$table->id])}}">
                        <button class="create-button btn btn-success"><a href="{{route('table.join',[$table->id])}}"><b>{{__('players.join')}}</b></a></button>
                        @csrf
                    </form>
                @else
                    <button class="create-button btn btn-success"><b>{{__('players.wait')}}</b></button>
                @endif
                </div>

                <div id="board2" class="board">
                    @if($table->board2())
                        @if($table->board2()->initialized)
                        <div class="player-label">
                            <span id="player_2" data-id="{{$table->board2()->user->id}}"  @if($table->current_player==$table->board2()->user->id) class="current-player" @endif>
                                {{$table->board2()->user->name}}
                            </span>
                        </div>
                        <div>
                            <div class="single-box box-label"></div>
                            @for($header_col = "A" ; $header_col <= "J" ; $header_col++)
                                <div class="single-box box-label">{{$header_col}}</div>
                            @endfor
                        </div>
                        @for($body_row = 1 ; $body_row <= 10 ; $body_row++)
                            <div>
                                <div class="single-box box-label">{{$body_row}}</div>
                                @for($body_col = "A" ; $body_col <= "J" ; $body_col++)
                                    <div id="{{$table->board2()->id}}_{{$body_col}}_{{$body_row}}" data-x="{{$body_col}}" data-y="{{$body_row}}" data-board_id="{{$table->board2()->id}}" class="single-box">
                                        @if(json_decode($table->board2()->fieldss,true)[$body_col][$body_row]=="@")
                                            <img id="theImg" src="{{asset('/storage/img/cross-green.png')}}" style="width:100%; height: 100%; object-fit: cover;" />
                                        @elseif(json_decode($table->board2()->fieldss,true)[$body_col][$body_row]=="#")
                                            <img id="theImg" src="{{asset('/storage/img/cross-red.png')}}" style="width:100%; height: 100%; object-fit: cover;" />
                                        @elseif(json_decode($table->board2()->fieldss,true)[$body_col][$body_row]=="*")
                                            <img id="theImg" src="{{asset('/storage/img/missed.png')}}" style="width:100%; height: 100%; object-fit: cover;" />
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        @endfor
                    @elseif($table->board2()->user->id == Auth::id())
                        <button class="create-button btn btn-success"><a href="{{route('board.edit',[$table->board2()->id])}}"><b>STWÓRZ</b></a></button>
                    @else
                        <button class="create-button btn btn-success"><b>{{$table->board2()->user->name}} {{__('players.creates_board')}}</b></button>
                    @endif
                @elseif((($table->board1())&&($table->board1()->user->id != Auth::id()))||($table->boards->count() == 0))
                        <form method="post" action="{{route('table.join',[$table->id])}}">
                            <button class="create-button btn btn-success"><a href="{{route('table.join',[$table->id])}}"><b>{{__('players.join')}}</b></a></button>
                            @csrf
                        </form>
                @else
                        <button class="create-button btn btn-success"><b>{{__('players.wait')}}</b></button>
                @endif
                </div>
            </div>
            <div style="clear:both;"></div>
    </div>


    <script type="text/javascript">
        const playerId = '{{Auth::id()}}';
        if({{$table->completed == true}}) {
            const player1Id = '{{$table->board1()->user->id}}';
            const player2Id = '{{$table->board2()->user->id}}';
        } else {
            const player1Id = null;
            const player2Id = null;
        }
        const baseUrl = '{{url('')}}' ;
        const baseAsset ='{{asset('/storage/img/')}}';
        const tableId = '{{$table->id}}';
        const redCrossImg = '{{asset('/storage/img/cross-red.png')}}';
        const greenCrossImg = '{{asset('/storage/img/cross-green.png')}}';
        const missedImg = '{{asset('/storage/img/missed.png')}}';
        const nameOneMaster = '{{__('ships.name.one_master')}}';
        const nameTwoMaster = '{{__('ships.name.two_master')}}';
        const nameThreeMaster = '{{__('ships.name.three_master')}}';
        const nameFourMaster = '{{__('ships.name.four_master')}}';
    </script>
    @section('js-files')
        <script src="{{ asset('js/game-board.js') }}"></script>
    @endsection
@endsection
