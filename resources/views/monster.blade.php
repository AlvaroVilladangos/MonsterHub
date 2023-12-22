@extends('compartidos.headerAndFooter')

@section('content')
    <div class="px-4 py-4">

        <div class="row">

            <div style="background-color: white" class="col-8">
                <h2 class="border-bottom">Fisiología</h2>
                <p class="fs-5"> {{ $monster->physiology }} </p>

                <h2 class="border-bottom">Habilidades</h2>
                <p class="fs-5"> {{ $monster->abilities }} </p>
            </div>



            <div class="col-4 mb-3">

                <div class="bg-dark list-group">
                    <h5 class="text-center text-light">{{ $monster->name }}</h5>
                </div>

                <div style="background-color: rgb(255, 255, 255)">
                    <img class="card-img-top py-3 px-3" src="{{ URL('storage/' . $monster->img) }}" alt="Card image cap">
                </div>

                <ul class=" bg-dark list-group mb-3">
                    <h5 class="card-title text-center text-light">INFO</h5>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center">
                        Elemento: <span>{{ $monster->element }}</span></li>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center">
                        Debilidad: <span>{{ $monster->weakness }}</span></li>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center">
                        Arma: <a href="{{ route('weapon.show', $weapon->id) }}" class="card-link">{{$weapon->name}}</a></li>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center">
                        Armadura: <a href="#" class="card-link">{{$armor->name}}</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
