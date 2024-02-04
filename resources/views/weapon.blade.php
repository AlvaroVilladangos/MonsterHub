@extends('compartidos.headerAndFooter')

@section('content')
    <div class="px-4 py-4">

        <div class="row">
            <div class="col-8 d-flex">
                <div class="card flex-grow-1" style=" background-color: transparent;">
                    <div class="bg-card shadow my-3 mx-3">
                        <h2 class="border-bottom my-3 mx-3 tituloCard">Info</h2>
                        <p class="fs-5 my-3 mx-3 flex-grow-1"> {{ $weapon->info }} </p>
                    </div>
                </div>
            </div>



            <div class="col-4 mb-3">
                <div class="bg-dark list-group">
                    <h5 class="text-center text-light my-2 fw-bold">{{ $weapon->name }}</h5>
                </div>

                <div style="background-color: #fcfcfc ;"">
                    <img style="max-height: 650px;" class="card-img-top py-3 px-3"
                        src="{{ URL('storage/' . $weapon->img) }}" alt="Card image cap">
                </div>

                <ul class="bg-dark list-group mb-3 shadow">
                    <h5 class="card-title text-center text-light fw-bold">INFO</h5>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center lista">
                        <span class="mx-5"> Ataque: </span> <span class="mx-5">{{ $weapon->atk }} <img class="icon"
                                src="{{ URL('storage/whiteSwordIcon.svg') }}" /></span>
                    </li>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center lista">
                        <span class="mx-5">Elemento: </span> <span class="mx-5">
                            {{ $weapon->element }}
                            @switch($weapon->element)
                                @case('Fuego')
                                    <img class="icon" src="{{ URL('storage/fireIcon.png') }}" />
                                @break

                                @case('Agua')
                                    <img class="icon" src="{{ URL('storage/waterIcon.png') }}" />
                                @break

                                @case('Hielo')
                                    <img class="icon" src="{{ URL('storage/iceIcon.png') }}" />
                                @break

                                @case('Eléctrico')
                                    <img class="icon" src="{{ URL('storage/thunderIcon.png') }}" />
                                @break

                                @case('Dragón')
                                    <img class="icon" src="{{ URL('storage/dragonIcon.png') }}" />
                                @break

                                @case('Neutro')
                                    -
                                @break
                            @endswitch
                        </span>
                    </li>

                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center lista">
                        <span class="mx-5"> Crítico: </span> <span class="mx-5">{{ $weapon->crit }}</span>
                    </li>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center lista">
                        <span class="mx-5"> Monstruo: </span> <a href="{{ route('monster.show', $monster->id) }}"
                            class="link nombrePerfil mx-5">{{ $monster->name }} <img class="icon"
                                src="{{ URL('storage/monsterIcon.svg') }}" /></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
