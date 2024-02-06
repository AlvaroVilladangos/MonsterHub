@extends('compartidos.headerAndFooter')

@section('content')
    <div class="container py-4">

        <form action="{{ route('weapons') }}" method="get">
            @csrf
            <div class="input-group mb-4 w-100 w-md-25" id="search-box">
                <input name="search" type="search" class="form-control" placeholder="Search" />
                <button type="submit" class="btn btn-aceptar">Buscar</button>
            </div>
        </form>

        <h2 class="tituloTabla">Lista de armas</h2>
        <div class="table-responsive table-responsive-stack">
            <table class="table table-hover">
                <tr class="table-dark">
                    <th class="text-center">Img</th>
                    <th class="text-center">Arma</th>
                    <th class="text-center">Elemento</th>
                    <th class="text-center">Ataque</th>
                    <th class="text-center">Crítico</th>
                    <th></th>
                </tr>

                @foreach ($weapons as $weapon)
                    <tr class="">
                        <td data-label="IMG" class="d-flex justify-content-center border-bottom"> <img
                                src="{{ $weapon->image_url }}" style="width:150px; height:auto;" alt="">
                        </td>
                        <td  data-label="NOMBRE"class="align-middle text-center border-bottom "><a
                                href="/weapon/{{ $weapon->id }}  "class="linkTabla">{{ $weapon->name }}</a></td>
                        <td data-label="ELEMENTO" class="align-middle text-center border-bottom">
                            {{ $weapon->element }}
                            @switch($weapon->element)
                                @case('Fuego')
                                    <img class="icon" src="{{ asset('img/bannersIconos/fireIcon.png') }}" />
                                @break

                                @case('Agua')
                                    <img class="icon" src="{{ asset('img/bannersIconos/waterIcon.png') }}" />
                                @break

                                @case('Hielo')
                                    <img class="icon" src="{{ asset('img/bannersIconos/iceIcon.png') }}" />
                                @break

                                @case('Eléctrico')
                                    <img class="icon" src="{{ asset('img/bannersIconos/thunderIcon.png') }}" />
                                @break

                                @case('Dragón')
                                    <img class="icon" src="{{ asset('img/bannersIconos/dragonIcon.png') }}" />
                                @break

                                @case('Neutro')
                                    -
                                @break
                            @endswitch
                        </td>
                        <td data-label="ATK" class="align-middle text-center border-bottom">{{ $weapon->atk }} <img class="icon"
                                src="{{ asset('img/bannersIconos/blackSwordIcon.svg') }}" /></td>
                        <td  data-label="CRIT"class="align-middle text-center border-bottom">{{ $weapon->crit }}</td>
                        <td></td>
                    </tr>
                    
                @endforeach
            </table>
        </div>

        {{ $weapons->links() }}
    </div>
@endsection
