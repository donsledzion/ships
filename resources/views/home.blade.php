@extends('layouts.app')

@section('content')
    <style>
        .home-ship{
            margin-left:auto;
            margin-right:auto;
        }
        @media (min-width: 380px) {
            .home-ship{
                height: 320px;
                width: 320px;

            }
        }

        @media (min-width: 600px) {
            .home-ship{
                height: 450px;
                width: 450px;
            }
        }

        @media (min-width: 1200px) {
            .home-ship{
                height: 600px;
                width: 600px;
            }
        }
    </style>
    <div class="container">
        <div class="">
            <div class="home-ship">
                <img src="{{asset('storage/img/main_ship.png')}}" style="max-height: 100%; width: 100%; object-fit: fill;">
            </div>
        </div>
    </div>
@endsection
