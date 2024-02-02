<div class="col-12 col-md-2 mb-3">
    <div class="card shadow" style="width: 18rem;">
        <div class="mx-2 my-2 d-flex justify-content-between">
            <div class="d-flex justify-content-center flex-grow-1">
                <h3 class="card-title fw-bold">Codigo: {{ $hunter->room->room_number }}</h3>
            </div>
            <div>
                <form action="{{ route('hunter.leaveRoom') }}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-cerrar">Salir</button>
                </form>
            </div>
        </div>

        <div style="background-color: white; border-radius: 5px;" class="mx-2 my-2">
            <img style="" class="card-img-top avatarMonsterRoom mx-1 my-2"
                src="{{ URL('storage/' . $hunter->room->monster->img) }}" />
        </div>
        <div class="card-body">
            <div class="list-unstyled d-flex align-items-center">
                <img class="avatarRoom" src="{{ URL('storage/monsterIcon.svg') }}" />
                <h5 class="card-title mx-2 my-2">{{ $hunter->room->monster->name }}</h5>
            </div>
            <h5 class="mx-2 my-2 border-bottom">Cazadores</h5>
            <ul>
                @foreach ($hunter->room->hunters as $hunterInRoom)
                    @if ($hunterInRoom->id != Auth::user()->hunter->id)
                        <li class="list-unstyled">
                            <div class=" d-flex align-items-center mx-2 my-2">
                                <img class="avatarRoom" src="{{ URL('storage/' . $hunterInRoom->img) }}" />
                                <a href="/hunter/{{ $hunterInRoom->id }}" class="nav-link ms-3 link">
                                    {{ $hunterInRoom->name }}</a>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>

        </div>
    </div>
</div>