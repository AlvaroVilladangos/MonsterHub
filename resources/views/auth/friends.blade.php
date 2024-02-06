@extends('compartidos.headerAndFooter')

@section('content')
    <div class="container py-4">

        <div class="row">

            <div class="col-12 col-md-8">
                <form action="{{ route('friends') }}" method="get">
                    @csrf
                    <div class="input-group mb-4 w-100 w-md-25" id="search-box">
                        <input name="search" type="search" class="form-control" placeholder="Search" />
                        <button type="submit" class="btn btn-aceptar">Buscar</button>
                    </div>
                </form>

                <h2 class="tituloTabla">Lista de amigos</h2>

                <div class="table-responsive table-responsive-stack">

                    <table class="table table-hover ">
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
                                <td data-label="Accion" class="align-middle text-center">
                                    <form id="deleteFriendForm" action="{{ route('deleteFriend') }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="requestId" value="{{ $acceptedFriend->id }}">
                                        <button type="button" onclick="confirmDeleteFriend()"
                                            class="btn btn-cerrar btn-sm">Borrar</button>
                                    </form>
                                </td>
                                <td data-label="Amigo" class="align-middle text-center">
                                    <div style="display: flex; align-items: center; justify-content: center;">
                                        <img  class="avatar mx-2"
                                            src="{{$acceptedFriend->image_url }}" />
                                        <a href="/hunter/{{ $acceptedFriend->id }}"
                                            class="linkTabla">{{ $acceptedFriend->name }}</a>
                                    </div>
                                </td>
                                <td data-label="Guild"  class="align-middle text-center">
                                    @isset($acceptedFriend->guild)
                                        <a class="linkTabla"
                                            href="/guild/{{ $acceptedFriend->guild->id }}">{{ $acceptedFriend->guild->name }}</a>
                                    @else
                                        N/A
                                    @endisset
                                </td>
                                <td data-label="Sala" class="align-middle text-center">
                                    @isset($acceptedFriend->room)
                                        {{ $acceptedFriend->room->roomCount() }}/4
                                    <td  data-label="Monstruo " class="align-middle text-center">{{ $acceptedFriend->room->monster->name }}</td>

                                    <td data-label="Cazadores"  class="align-middle text-center">
                                        <ul class="list-unstyled">
                                            @foreach ($acceptedFriend->room->hunters as $hunterInRoom)
                                                @if ($hunterInRoom->id != Auth::user()->hunter->id)
                                                    <li><a href="/hunter/{{ $hunterInRoom->id }}" class="linkTabla">
                                                            {{ $hunterInRoom->name }}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </td>
                                @else
                                    N/A
                                    <td></td>
                                    <td></td>
                                @endisset
                                </td>
                                <td class="align-middle text-center">
                                    @isset(auth()->user()->hunter->room)
                                    @else
                                        @isset($acceptedFriend->room)
                                            <form action="{{ route('hunter.joinRoom') }}" method="post">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="room_id" value="{{ $acceptedFriend->room->id }}">
                                                <button class="btn btn-aceptar btn-sm" type="submit">Unirse</button>
                                            </form>
                                        @else
                                        @endisset
                                    @endisset
                                </td>
                                
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <ul class="list-group">
                    <h3 class="tituloTabla">Solicitudes de amistad</h3>
                    @foreach ($receivedRequestsData as $pendingFriend)
                        <li class="list-group-item">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center;">
                                    <img  class="avatarRoom mx-2"
                                        src="{{ $pendingFriend->image_url }}" />
                                    <a href="/hunter/{{ $pendingFriend->id }}"
                                        class="linkTabla">{{ $pendingFriend->name }}</a>
                                </div>
                                <form action="{{ route('acceptfriend') }}" method="post">
                                    @csrf
                                    @method('put')
                                    <input type="text" name="requestId" value="{{ $pendingFriend->id }}" hidden>
                                    </input>
                                    <button type="submit" class="btn btn-aceptar btn-sm">Aceptar</button>
                                </form>

                                <form action="{{ route('deleteFriend') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="text" name="requestId" value="{{ $pendingFriend->id }}" hidden>
                                    </input>
                                    <button type="submit" class="btn btn-cerrar btn-sm">Rechazar</button>
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
                confirmButtonColor: '#26555b',
                cancelButtonColor: '#e43944',
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
