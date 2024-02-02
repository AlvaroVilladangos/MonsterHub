@extends('compartidos.headerAndFooter')

@section('content')
    <div class="container py-4">

        <form action="{{ route('hunters') }}" method="get">
            @csrf
            <div class="input-group mb-4 w-25" id="search-box">
                <input name="search" type="search" class="form-control" placeholder="Search" />
                <button type="submit" class="btn btn-aceptar">search</button>
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
                        <div style="display: flex; align-items: center; justify-content: center;">
                            <img style="width: 50px" class="me-3 avatar-sm rounded-circle"
                                src="{{ URL('storage/' . $hunter->img) }}" />
                            <a href="/hunter/{{ $hunter->id }}"
                                class="linkTabla">{{ $hunter->name }}</a>
                        </div>
                    </td>
                    @isset($hunter->guild)
                        <td class="align-middle text-center"><a
                                href="/guild/{{ $hunter->guild->id }}">{{ $hunter->guild->name }}</a></td>
                    @else
                        <td class="align-middle text-center">N/A</td>
                    @endisset
                    <td class="align-middle text-center"></td>
                </tr>
            @endforeach



        </table>

        {{ $hunters->links() }}
    </div>
@endsection
