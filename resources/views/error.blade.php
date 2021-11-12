@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <h2 class="alert">{{__('messages.error')}} - {{$message}}</h2>
            <div class="xxl-col12 xl-col-10 md-col-8 sm-col-6 mx-auto d-block">
                <img src="{{asset('storage/img/error-ship.png')}}" class="d-block" style="object-fit: cover;">
            </div>
        </div>
    </div>
@endsection
