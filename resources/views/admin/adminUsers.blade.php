@extends('compartidos.headerAndFooter')


@section('content')
    <div class="container py-4">
        <h2 class="tituloTabla">Lista de usuarios</h2>
        <form action="{{ route('usersAdmin') }}" method="get">
            @csrf
            <div class="input-group mb-4 w-100 w-md-25" id="search-box">
                <input name="search" type="search" class="form-control" placeholder="Search" />
                <button type="submit" class="btn btn-aceptar">Buscar</button>
            </div>
        </form>

        <div class="table-responsive table-responsive-stack">
        <table class="table table-hover mt2 ">
            <tr class="table-dark ">
                <th class="text-center">Nombre</th>
                <th class="text-center">Cazador</th>
                <th class="text-center">Email</th>
                <th class="text-center">Comentarios</th>
                <th class="text-center"></th>
                <th  class="text-center"></th>
            </tr>

            @foreach ($users as $user)
                @if (Auth::user()->id == $user->id)
                    @continue
                @endif
                <tr>
                    <td data-label="NOMBRE" class="align-middle text-center">{{ $user->name }}</td>
                    <td data-label="CAZADOR" class="align-middle text-center"><a class="linkTabla"
                            href="/hunter/{{ $user->hunter->id }}">{{ $user->hunter->name }}</a></td>
                    <td data-label="EMAIL" class="align-middle text-center">{{ $user->email }}</a></td>
                    <td data-label="COMENTARIOS" class="align-middle text-center"><a class="linkTabla"
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
                                <button class="btn btn-sm btn-deshabilitar" type="submit">Bloquear</button>
                            </form>
                        </td>
                    @endif
                    <td class="align-middle text-center">
                        <form id="deleteUserForm-{{ Auth::user()->id }}" action="{{ route('user.destroy', Auth::user()->id) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-cerrar btn-sm"
                                onclick="confirmDeleteUser({{ Auth::user()->id }})">Eliminar Usuario</button>
                        </form>
                    </td>
                    <td></td>
                </tr>
            @endforeach
        </table>

        {{ $users->links() }}
    </div>
@endsection


@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
            function confirmDeleteUser(userId) {
            console.log(userId)
            Swal.fire({
                title: '¿Estás seguro que quieres borrar el usuario?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#26555b',
                cancelButtonColor: '#d62b36',
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteUserForm-' + userId).submit();
                }
            })
        }
</script>

@endsection