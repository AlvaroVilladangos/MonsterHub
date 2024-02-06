@extends('compartidos.headerAndFooter')

@section('content')
    <div class="container py-4">

        <form action="{{ route('hunters') }}" method="get">
            @csrf
            <div class="input-group mb-4 w-100 w-md-25" id="search-box">
                <input name="search" type="search" class="form-control" placeholder="Search" />
                <button type="submit" class="btn btn-aceptar">Buscar</button>
            </div>
        </form>

        <h2 class="tituloTabla"> Lista de cazadores</h2>
        <table class="table table-hover table-borderless">
            <tr class="table-dark ">
                <th class="text-center">Cazador</th>
                <th class="text-center">Guild</th>
                <th class="text-center"></th>
            </tr>

            @foreach ($hunters as $hunter)
                @if (Auth::user()->hunter->id == $hunter->id)
                    @continue
                @endif
                <tr class="border-bottom">
                    <td class="align-middle text-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <img class="avatarRoom"
                                src="{{$hunter->image_url }}" />
                            <a href="/hunter/{{ $hunter->id }}" class="linkTabla">{{ $hunter->name }}</a>
                        </div>
                    </td>
                    @isset($hunter->guild)
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center justify-content-center">
                                <img class="avatarRoom"
                                src="{{$hunter->guild->image_url }}" />
                                <a class="linkTabla ms-3" href="/guild/{{ $hunter->guild->id }}">{{ $hunter->guild->name }}</a>
                            </div>
                        </td>
                    @else
                        <td class="align-middle text-center">N/A</td>
                    @endisset
                    <td class="align-middle text-center"> 

                        @if (auth()->user()->hunter && !auth()->user()->hunter->isInRelation($hunter->id))
                        <div class="mt-3">
                            <form action="{{ route('addfriend', ['requesterId' => auth()->user()->hunter->id, 'receiverId' => $hunter->id]) }}" method="post">
                                @csrf
                                <button class="btn btn-aceptar btn-sm" type="submit">Agregar</button>
                            </form>
                        </div>
                        @endif

                    </td>
                </tr>
            @endforeach



        </table>

        {{ $hunters->links() }}
    </div>
@endsection
