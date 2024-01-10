@extends('compartidos.headerAndFooter')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-2 mb-3">

            </div>
            <div class="col-8 mb-3">

                <form action="{{ route('rooms') }}" method="get">
                    <div class="input-group mb-4 w-25" id="search-box">
                        <input name="search" type="search" class="form-control" placeholder="Search" />
                        <button type="submit" class="btn btn-dark">search</button>
                    </div>
                </form>
                <table class="table table-hover table-borderless">
                    <tr class="table-dark ">
                        <th class="text-center"></th>
                        <th class="text-center"> Monstruo</th>
                        <th class="text-center">Numero jugadores</th>
                        <th class="text-center"></th>
                    </tr>
                    @foreach ($rooms as $room)
                        @if ($room->roomCount() == 4)
                            @continue
                        @endif

                        @if ($room->roomCount() == 4 || (isset(Auth::user()->hunter->room) && $room->id == Auth::user()->hunter->room->id))
                            @continue
                        @endif
                        <tr>
                            <td class="d-flex justify-content-center"></td>
                            <td class="align-middle text-center">{{ $room->monster->name }}</td>
                            <td class="align-middle text-center">{{ $room->roomCount() }}</td>
                            <td class="align-middle text-center">
                                @if (!isset(Auth::user()->hunter->room))
                                    <form action="{{ route('hunter.joinRoom') }}" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="" name="room_id" id="" value="{{ $room->id }}"
                                            hidden>
                                        <button class="btn btn-success btn-sm" type="submit">Unirse</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $rooms->links() }}
            </div>
            <div class="col-2">
                @isset(Auth::user()->hunter->room)
                @else
                    <button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#guildRoom">
                        Crear sala
                    </button>
                @endisset
            </div>

            <div class="modal fade" id="guildRoom" tabindex="-1" aria-labelledby="guildRoomLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" id="guildRoomLabel">Crear Sala</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form method="post" action="{{ route('rooms.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Monstruo al que cazar</label>
                                    <select size="1" name="monster" id="monster" class="select-control">
                                        @foreach ($monsters as $monster)
                                            <option value="{{ $monster->id }}"> {{ $monster->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <input name="hunter_1" type="text" value="{{ Auth::user()->hunter->id }}" hidden>
                                </div>
                                <button type="submit" class="btn btn-primary">Crear sala</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
