@extends('compartidos.headerAndFooter')

@section('content')
    <div class="px-4 py-4">

        <div class="row">

            <div style="background-color: white" class="col-8">
                <h2 class="border-bottom">Info</h2>
                <p class="fs-5"> {{ $weapon->info }} </p>

            </div>



            <div class="col-3 mb-3">

                <div class="bg-dark list-group">
                    <h5 class="text-center text-light">{{ $weapon->name }}</h5>
                </div>

                <div style="background-color: rgb(255, 255, 255)">
                    <img class="card-img-top py-3 px-3" src="{{ URL('storage/' . $weapon->img) }}" alt="Card image cap">
                </div>

                <ul class=" bg-dark list-group mb-3">
                    <h5 class="card-title text-center text-light">INFO</h5>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center">
                        Ataque: <span>{{ $weapon->atk }}</span></li>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center">
                        Elemento: <span>{{ $weapon->element }}</span></li>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center">
                        Monstruo: <a href="{{ route('monster.show', $monster->id) }}" class="nav-link text-decoration-underline">{{$monster->name}}</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
