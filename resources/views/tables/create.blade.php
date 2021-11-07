@extends('layouts.app')

@section('content')
    <div class="col-4 align-content-center mx-auto my-xl-5">
        <h3 class="">Stwórz nową grę:</h3>
        <form action="{{route('table.create')}}" method="post">


            <select id="playerA" class="browser-default custom-select">
                <option selected>Wybierz przeciwnika</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{ucfirst($user->name)}}</option>
                @endforeach
            </select>

            <button class="btn btn-success float-right mt-2 font-weight-bold" type="submit">Graj</button>
        </form>
    </div>
@endsection
