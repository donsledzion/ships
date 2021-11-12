@extends('layouts.app')

@section('header')
    <link href="{{asset('css/board.css')}}" rel="stylesheet" />
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-2 ads">  </div>
            <div class="col-12 col-sm-6 content">
                <div class="container-fluid tic-container">
                    <div class="row tic-row">
                        <div class="col-1 tic-box bg-primary">  </div>
                        @for($col = "A"; $col <= "J" ; $col++)
                            <div class="col-1 tic-box bg-primary">{{$col}}</div>
                        @endfor
                    </div>
                   @for($row = 1 ; $row <= 10 ; $row++)
                        <div class="row tic-row">
                            <div class="col-1 tic-box bg-primary">{{$row}}</div>
                            @for($col = "A"; $col <= "J" ; $col++)
                                <div id="{{$col."".$row}}" data-x="{{$col}}" data-y="{{$row}}" class="col-1 tic-box">
                                    @if(json_decode($board->fields,true)[$col][$row]=="@")
                                        <img id="theImg" src="{{asset('/storage/img/cross-green.png')}}" style="width:100%; height: 100%; object-fit: cover;" />
                                    @endif
                                    {{--{{json_decode($board->fields,true)[$col][$row]}}--}}
                                </div>
                            @endfor
                        </div>
                    @endfor


                </div>
            </div>
            <div class="col-12 col-sm-2 tic-panel">
                Stwóz swoją planszę aby rozpocząć grę:
                <br/><br/><b>Czteromasztowiec:</b>
                <br/><b><button data-size="4" data-order="1" class="ship-picker btn btn-success border-1 border-warning my-1">1) </button></b>
                <br/><b>Trójmasztowce:</b>
                <br/><b><button data-size="3" data-order="1" class="ship-picker btn btn-success border-1 border-warning my-1">1) </button></b>
                <br/><b><button data-size="3" data-order="2" class="ship-picker btn btn-success border-1 border-warning my-1">2) </button></b>
                <br/><b>Dwumasztowce:</b>
                <br/><b><button data-size="2" data-order="1" class="ship-picker btn btn-success border-1 border-warning my-1">1) </button></b>
                <br/><b><button data-size="2" data-order="2" class="ship-picker btn btn-success border-1 border-warning my-1">2) </button></b>
                <br/><b><button data-size="2" data-order="3" class="ship-picker btn btn-success border-1 border-warning my-1">3) </button></b>
                <br/><b>Jednomasztowce:</b>
                <br/><b><button data-size="1" data-order="1" class="ship-picker btn btn-success border-1 border-warning my-1">1) </button></b>
                <br/><b><button data-size="1" data-order="2" class="ship-picker btn btn-success border-1 border-warning my-1">2) </button></b>
                <br/><b><button data-size="1" data-order="3" class="ship-picker btn btn-success border-1 border-warning my-1">3) </button></b>
                <br/><b><button data-size="1" data-order="4" class="ship-picker btn btn-success border-1 border-warning my-1">4) </button></b>
                <br/>
                <button id="save-board" data-id="{{$board->id}}" class="btn btn-secondary">ZAPISZ</button>
            </div>


            <div class="col-12 col-sm-2 ads"> ads </div>
        </div>
    </div>
    <script type="text/javascript">
        const baseUrl = '{{url('')}}' ;
    </script>
@section('js-files')
    <script src="{{ asset('js/edit-board.js') }}" ></script>
@endsection
@endsection
