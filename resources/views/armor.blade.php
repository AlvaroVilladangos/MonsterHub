@extends('compartidos.headerAndFooter')

@section('content')
    <div class="px-4 py-4">

        <div class="row">

            <div class="col-12 col-md-4 mb-3">
                <div class="bg-dark list-group">
                    <h5 class="text-center text-light my-2 mx-2 fw-bold">{{ $armor->name }}</h5>
                </div>

                <div style="background-color: #fcfcfc">
                    <img class="card-img-top py-3 px-3" src="{{ URL('storage/' . $armor->img) }}" alt="Card image cap">
                </div>

                <ul class=" bg-dark list-group mb-3">
                    <h5 class="card-title text-center text-light fw-bold">INFO</h5>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center lista">
                        <span class="mx-5"> Defensa: </span> <span class="mx-5">{{ $armor->def }} <img class="icon"
                                src="{{ URL('storage/whiteShieldIcon.svg') }}" /></span>
                    </li>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center lista">
                        <span class="mx-5"> Monstruo: </span> <a href="{{ route('monster.show', $monster->id) }}"
                            class="link nombrePerfil mx-5">{{ $monster->name }} <img class="icon"
                                src="{{ URL('storage/monsterIcon.svg') }}" /></a>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-md-8">
                <div class="card  flex-grow-1" style="background-color:transparent;">
                    <div class="bg-card shadow my-3 mx-3">
                        <h2 class="border-bottom my-3 mx-3 tituloCard">Info</h2>
                        <p class="fs-5 my-3 mx-3 flex-grow-1"> {{ $armor->info }} </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
