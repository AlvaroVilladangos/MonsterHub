@extends('compartidos.headerAndFooter')

@section('content')
    <div class="container py-4">

        <div class="row">

            <div class="col-md-8">
                <form action="{{ route('friends') }}" method="get">
                    <div class="input-group mb-4 w-25" id="search-box">
                        <input name="search" type="search" class="form-control" placeholder="Search" />
                        <button type="submit" class="btn btn-dark">search</button>
                    </div>
                </form>

                <h2 class="mb-4">Lista de amigos</h2>

                <table class="table table-hover table-borderless">
                    <tr class="table-dark ">
                        <th class="text-center">Acción</th>
                        <th class="text-center">Amigo</th>
                        <th class="text-center">Guild</th>
                        <th class="text-center">Sala</th>
                        <th class="text-center">Monstruo</th>
                        <th class="text-center">Jugadores</th>
                        <th></th>
                    </tr>

                    @foreach ($acceptedFriends as $acceptedFriend)
                        @if (Auth::user()->hunter->id == $acceptedFriend->id)
                            @continue
                        @endif
                        <tr>
                            <td class="align-middle text-center">
                                <form id="deleteFriendForm" action="{{ route('deleteFriend') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="requestId" value="{{ $acceptedFriend->id }}">
                                    <button type="button" onclick="confirmDeleteFriend()" class="btn btn-primary btn-sm">Borrar</button>
                                </form>
                            </td>
                            <td class="align-middle text-center">
                                <div style="display: flex; align-items: center; justify-content: center;">
                                    <img style="width: 50px" class="me-3 avatar-sm rounded-circle"
                                        src="{{ URL('storage/' . $acceptedFriend->img) }}" />
                                    <a href="/hunter/{{ $acceptedFriend->id }}"
                                        class="nav-link text-decoration-underline">{{ $acceptedFriend->name }}</a>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                @isset($acceptedFriend->guild)
                                    <a href="/guild/{{ $acceptedFriend->guild->id }}">{{ $acceptedFriend->guild->name }}</a>
                                @else
                                    N/A
                                @endisset
                            </td>
                            <td class="align-middle text-center">
                                @isset($acceptedFriend->room)
                                    {{ $acceptedFriend->room->roomCount() }}/4
                                <td class="align-middle text-center">{{ $acceptedFriend->room->monster->name }}</td>

                                <td class="align-middle text-center">
                                    <ul class="list-unstyled">
                                        @foreach ($acceptedFriend->room->hunters as $hunterInRoom)
                                            @if ($hunterInRoom->id != Auth::user()->hunter->id)
                                                <li><a href="/hunter/{{ $hunterInRoom->id }}" class="nav-link text-decoration-underline">
                                                    {{ $hunterInRoom->name }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                            @else
                                N/A
                            @endisset
                            </td>
                            <td class="align-middle text-center">
                                @isset(auth()->user()->hunter->room)
                                    <!-- Empty cell -->
                                @else
                                    @isset($acceptedFriend->room)
                                        <form action="{{ route('hunter.joinRoom') }}" method="post">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="room_id" value="{{ $acceptedFriend->room->id }}">
                                            <button class="btn btn-success btn-sm" type="submit">Unirse</button>
                                        </form>
                                    @else
                                        <!-- Empty cell -->
                                    @endisset
                                @endisset
                            </td>
                        </tr>
                    @endforeach



                </table>

            </div>

            <div class="col-md-4">
                <ul class="list-group">
                    <h3>Solicitudes de amistad</h3>
                    @foreach ($receivedRequestsData as $pendingFriend)
                        <li class="list-group-item">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center;">
                                    <img style="width: 50px" class="me-3 avatar-sm rounded-circle"
                                        src="{{ URL('storage/' . $pendingFriend->img) }}" />
                                    <a href="/hunter/{{ $pendingFriend->id }}"
                                        class="nav-link text-decoration-underline">{{ $pendingFriend->name }}</a>
                                </div>
                                <form action="{{ route('acceptfriend') }}" method="post">
                                    @csrf
                                    @method('put')
                                    <input type="text" name="requestId" value="{{ $pendingFriend->id }}" hidden>
                                    </input>
                                    <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                                </form>

                                <form action="{{ route('deleteFriend') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="text" name="requestId" value="{{ $pendingFriend->id }}" hidden>
                                    </input>
                                    <button type="submit" class="btn btn-primary btn-sm">Rechazar</button>
                                </form>
                            </div>

                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endsection





@section('scripts')



<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteFriend() {
        Swal.fire({
            title: '¿Estás seguro de que quieres eliminar a este amigo?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteFriendForm').submit();
            }
        })
    }
</script>
@endsection