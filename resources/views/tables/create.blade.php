@extends('layouts.app')

@section('content')
    <div class="col-10 align-content-center mx-auto my-xl-5">
        <h4 class="">Stwórz nową grę:</h4>
        <form action="{{route('table.store')}}" method="post">
            @csrf

            <select id="opponent" name="opponent" class="browser-default custom-select">
                <option selected>Wybierz przeciwnika</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">
                        {{ucfirst($user->name)}}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-success float-right mt-2 font-weight-bold" type="submit">Graj</button>
        </form>
    </div>
@endsection
@section('js-files')
    <script src="{{ asset('js/create-game.js') }}" ></script>
@endsection
