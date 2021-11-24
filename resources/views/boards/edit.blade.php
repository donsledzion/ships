@extends('layouts.app')

@section('header')
    <link href="{{asset('css/board.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <style>

    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-2 ads">  </div>
            <div class="col-12 col-sm-6 content">
                <div class="container-fluid tic-container">
                    <div id="board1" class="board">
                        {{--<div class="player-label">{{$table->board1()->user->name}}</div>--}}
                        <div>
                            <div class="tic-box box-label"></div>
                            @for($header_col = "A" ; $header_col <= "J" ; $header_col++)
                                <div class="tic-box box-label">{{$header_col}}</div>
                            @endfor
                        </div>
                        @for($body_row = 1 ; $body_row <= 10 ; $body_row++)
                            <div>
                                <div class="tic-box box-label">{{$body_row}}</div>
                                @for($body_col = "A" ; $body_col <= "J" ; $body_col++)
                                    <div id="{{$body_col}}{{$body_row}}" data-x="{{$body_col}}" data-y="{{$body_row}}" data-board_id="{{$board->id}}" data-status="free" data-hinted="false" class="tic-box">
                                    </div>
                                @endfor
                            </div>
                        @endfor
                    </div>


                </div>
            </div>
            <div class="col-12 col-sm-2 tic-panel">
                <span class="h4 text-white">Aktualnie tworzony:</span>
                <div id="currently-creating">

                </div>
                <div id="available-sequences">

                </div>

                <button id="save-board" data-id="{{$board->id}}" class="btn btn-secondary">ZAPISZ</button>
            </div>


            <div class="col-12 col-sm-2 ads"> ads </div>
        </div>
    </div>
    <script type="text/javascript">
        const baseUrl = '{{url('')}}' ;
        const baseAsset ='{{asset('/storage/img/')}}';
        const nameOneMaster = '{{__('ships.name.one_master')}}';
        const nameTwoMaster = '{{__('ships.name.two_master')}}';
        const nameThreeMaster = '{{__('ships.name.three_master')}}';
        const nameFourMaster = '{{__('ships.name.four_master')}}';
        const availableSequences = '{{__('ships.available_sequences')}}';
    </script>
@section('js-files')
    <script src="{{ asset('js/edit-board.js') }}" ></script>
@endsection
@endsection
