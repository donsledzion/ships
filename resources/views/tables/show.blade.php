@extends('layouts.app')

@section('content')
    <style>
        @media (min-width: 1200px) {
            .table-container {
                width: 1150px;
                height: 650px;
                background-color: #98dfb6;
                border: 1px solid black;
                border-radius: 5px;
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
            }

            .board {
                width: 500px;
                height: 550px;
                margin-top:40px;
                margin-left:30px;
                margin-right:auto;
                border: 1px solid black;
                border-radius: 2px;
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
                font-size: 22px;
                font-weight: bold;
                align-self: center;
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
                    <div class="player-label">{{$table->board1()->user->name}}</div>
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
                            <div data-x="{{$body_col}}" data-y="{{$body_row}}" data-board_id="{{$table->board1()->id}}" class="single-box">
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
                </div>

                <div id="board2" class="board">
                    <div class="player-label">{{$table->board2()->user->name}}</div>
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
                                <div data-x="{{$body_col}}" data-y="{{$body_row}}" data-board_id="{{$table->board2()->id}}" class="single-box">
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
                </div>
            </div>
            <div style="clear:both;"></div>
    </div>

    <script type="text/javascript">
        const baseUrl = '{{url('')}}' ;


        $(function(){
            $('.single-box').click(function(){

                shot($(this));
            })


            $('.player').click(function(){
                var targetURL = baseUrl + '/board/' + $(this).data("board-id");
                console.log('BaseUrl: '+targetURL);
                $.ajax({
                    url: targetURL,
                    method: "get",
                }).done(function(response){
                    console.log(response);
                    console.log(response.fields.A[1]);
                }).fail(function(response){
                    console.log('fail!');
                    console.log(response);
                });
            })
        })

        function shot(field){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var board = field.data("board_id");
            var column = field.data("x");
            var row = field.data("y");
            $.ajax({
                url: baseUrl + '/board/' + board + "/shot/" + column + "/" + row,
                method: "post",
            }).done(function(response){
                Swal.fire(response.message).then((result) => {
                    if (result.isConfirmed){
                        location.reload();
                    }
                });
            }).fail(function(response){
                Swal.fire(response.message);
            });

        }


    </script>
    @section('js-files')

    @endsection
@endsection
