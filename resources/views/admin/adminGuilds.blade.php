@extends('compartidos.adminHeaderAndFooter')


@section('content')
    <div class="container py-4">

        <form action="{{ route('guildsAdmin') }}" method="get">
            <div class="input-group mb-4 w-25" id="search-box">
                <input name="search" type="search" class="form-control" placeholder="Search" />
                <button type="submit" class="btn btn-dark">search</button>
            </div>
        </form>


        <table class="table table-hover table-borderless">
            <tr class="table-dark ">
                <th class="text-center">Guilds</th>
                <th class="text-center">Lider</th>
                <th class="text-center"></th>
            </tr>

            @foreach ($guilds as $guild)
                <tr>
                    <td class="align-middle text-center">
                        <a class="nav-link text-decoration-underline"
                            href="/guild/{{ $guild->id }}">{{ $guild->name }}</a></td>
                    <td class="align-middle text-center"><a class="nav-link text-decoration-underline"
                            href="/hunter/{{ $guild->leader->id }}">{{ $guild->leader->name }}</a></td>
        
                    <td class="align-middle text-center">
                        <form id="deleteGuildForm{{ $guild->id }}"
                            action="{{ route('guildDestroy', ['id' => $guild->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="confirmDeleteGuild({{ $guild->id }})">ELIMINAR</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $guilds->links() }}
    </div>
@endsection




@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        function confirmDeleteGuild(guildId) {
            var form = document.getElementById('deleteGuildForm' + guildId);
            Swal.fire({
                title: '¿Estás seguro de que quieres eliminar la guild?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        }
    </script>
@endsection