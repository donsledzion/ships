@extends('layouts.app')

@section('content')
    <div class="col-4 align-content-center mx-auto my-xl-5">
        Gracze:
        @foreach($table->boards as $board)
            <div><button class="player" data-board-id="{{$board->id}}">{{$board->user->name}}</button>: {{$board->user->ranking}}
                @if(!$board->initialized)
                    <a href="{{route('board.edit',[$board->id])}}"><button class="btn btn-secondary">Stwórz planszę</button></a>
            @endif
            </div>
        @endforeach
    </div>
    <script type="text/javascript">
        const baseUrl = '{{url('')}}' ;

        $(function(){
            $('.player').click(function(){
                let targetURL = baseUrl + '/board/' + $(this).data("board-id");
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


    </script>
    @section('js-files')

    @endsection
@endsection
