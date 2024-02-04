@extends('compartidos.headerAndFooter')


@section('content')
    <div class="container py-4">

        <form action="{{ route('usersAdmin') }}" method="get">
            @csrf
            <div class="input-group mb-4 w-25" id="search-box">
                <input name="search" type="search" class="form-control" placeholder="Search" />
                <button type="submit" class="btn btn-aceptar">search</button>
            </div>
        </form>


        <table class="table table-hover ">
            <tr class="table-dark ">
                <th class="text-center">Nombre</th>
                <th class="text-center">Cazador</th>
                <th class="text-center">Email</th>
                <th class="text-center">Comentarios</th>
                <th class="text-center">Accion</th>
            </tr>

            @foreach ($users as $user)
                @if (Auth::user()->id == $user->id)
                    @continue
                @endif
                <tr>
                    <td class="align-middle text-center">{{ $user->name }}</td>
                    <td class="align-middle text-center"><a class="linkTabla"
                            href="/hunter/{{ $user->hunter->id }}">{{ $user->hunter->name }}</a></td>
                    <td class="align-middle text-center">{{ $user->email }}</a></td>
                    <td class="align-middle text-center"><a class="linkTabla"
                            href="/hunter/{{ $user->hunter->id }}/comments">Ver</a></td>
                    @if ($user->blocked)
                        <td class="align-middle text-center">

                            <form action="{{ route('unBlockUser', ['id' => $user->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-aceptar" type="submit">Desbloquear</button>
                            </form>

                        </td>
                    @else
                        <td class="align-middle text-center">

                            <form action="{{ route('blockUser', ['id' => $user->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-cerrar" type="submit">Bloquear</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>

        {{ $users->links() }}
    </div>
@endsection
