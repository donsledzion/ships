@extends('layouts.app')

@section('header')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
@endsection

@section('content')
    <style>
        @media (min-width: 380px) {
            .table-container {
                width: 370px;
                height: 850px;
                background-color: #98dfb6;
                border: 1px solid black;
                border-radius: 1px;
                margin-left: auto;
                margin-right: auto;
            }

            .board-container {
                width: 360px;
                height: 840px;
                margin-top: 2px;
                margin-left: auto;
                margin-right:auto;
                background-color: #0f5132;
                border: 1px solid red;
                border-radius: 1px;
            }

            .board {
                width: 355px;
                height: 410px;
                margin-top:2px;
                margin-left:auto;
                margin-right:auto;
                border: 1px solid black;
                border-radius: 1px;
                background-color: #c7eed8;
                float:left;
                padding:1px;
            }

            .single-box{
                width: 32px;
                height: 32px;
                border:1px solid black;

                background-color: #20c997;
                display: table-cell;
                border-collapse: collapse;
                overflow: hidden;
                text-align: center;
                vertical-align: middle;

                font-size: 1.0rem;
            }

            .player-label{
                text-align: center;
                font-size: 22px;
                font-weight: bold;
                align-self: center;
                display: inline-block;
                padding-top:10px;
                margin-bottom:10px;
                width: 100%;
            }

            .current-player{
                padding:5px 20px 5px 20px;
                background-color: #0dcaf0;
                border: 3px dotted red;
                border-radius: 10px
            }


            .create-button{
                margin-top:150px;
                width:140px;
                margin-left:100px;
                margin-right:auto;
                border: 3px dotted red;
                border-radius: 10px;
                font-size:24px;
            }

        }
        @media (min-width: 1200px) {
            .table-container {
                width: 1150px;
                height: 650px;
                background-color: #98dfb6;
                border: 1px solid black;
                border-radius: 50px;
                margin-left: auto;
                margin-right: auto;
            }

            .board-container {
                width: 1100px;
                height: 600px;
                margin-top: 35px;
                margin-left: auto;
                margin-right:auto;
                background-color: #0f5132;
                border: 1px solid red;
                border-radius: 40px;
            }

            .board {
                width: 500px;
                height: 570px;
                margin-top:10px;
                margin-left:30px;
                margin-right:auto;
                border: 1px solid black;
                border-radius: 20px;
                background-color: #c7eed8;
                float:left;
                padding:25px;
            }

            .single-box{
                width: 40px;
                height: 40px;
                border:1px solid black;

                background-color: #20c997;
                display: table-cell;
                border-collapse: collapse;
                overflow: hidden;
                text-align: center;
                vertical-align: middle;

                font-size: 1.5rem;
            }

            .player-label{
                text-align: center;
                font-size: 22px;
                font-weight: bold;
                align-self: center;
                display: inline-block;
                padding-top:10px;
                width: 49%;
                margin-bottom:10px;
            }

            .current-player{
                padding:5px 20px 5px 20px;
                background-color: #0dcaf0;
                border: 3px dotted lightslategray;
                border-radius: 15px
            }


            .create-button{
                margin-top:220px;
                width:240px;
                margin-left:100px;
                margin-right:auto;
                border: 4px dotted red;
                border-radius: 20px;
                font-size: 36px;
            }

        }
        .box-label{
            font-weight: bold;
            color: white;
            background-color: #f6993f;
        }

        .single-box:hover{
            background-color: #0dcaf0;
        }
    </style>

    <div class="table-container">
        <div class="board-container">
                <div id="board1" class="board">
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
                    @endif
                </div>

                <div id="board2" class="board">
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
                @endif
                </div>
            </div>
            <div style="clear:both;"></div>
    </div>

    <script type="text/javascript">
        const playerId = '{{Auth::id()}}';
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
