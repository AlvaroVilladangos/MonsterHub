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


                <table class="table table-hover table-borderless">
                    <tr class="table-dark ">
                        <th class="text-center">Acción</th>
                        <th class="text-center">Amigo</th>
                        <th class="text-center">Guild</th>
                        <th>Sala</th>
                        <th></th>
                    </tr>


                    @foreach ($acceptedFriends as $acceptedFriend)
                        @if (Auth::user()->hunter->id == $acceptedFriend->id)
                            @continue
                        @endif
                        <tr>
                            <td class="align-middle text-center">
                                <form action="{{ route('deleteFriend') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="text" name="requestId" value="{{ $acceptedFriend->id }}" hidden>
                                    </input>
                                    <button type="submit" class="btn btn-primary btn-sm">Borrar</button>
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
                            @isset($acceptedFriend->guild)
                                <td class="align-middle text-center"><a
                                        href="/guild/{{ $acceptedFriend->guild->id }}">{{ $acceptedFriend->guild->name }}</a>
                                </td>
                            @else
                                <td class="align-middle text-center">N/A</td>
                            @endisset
                           
                            @isset($acceptedFriend->room)
                                <td class="align-middle text-center">
                                    {{$acceptedFriend->room->roomCount()}}/4
                                </td>
                            @else
                                <td class="align-middle text-center">N/A</td>
                            @endisset
                            
                            @isset(auth()->user()->hunter->room)

                            <td class="align-middle text-center"></td>

                            @else
                            <td class="align-middle text-center">
                                <form action="{{route('hunter.joinRoom')}}" method="post">
                                    @csrf  
                                    @method('put')
                                    <input type="" name="room_id" id="" value="{{$acceptedFriend->room->id}}" hidden>
                                    <button class="btn btn-success btn-sm" type="submit">Unirse</button>
                                </form>
                            </td>
                            @endisset
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
