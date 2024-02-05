@extends('compartidos.headerAndFooter')
@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="col-2 mb-3">
                
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="px-3 pt-4 pb-2">
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <div class="d-flex align-items-center">
                                <img class="avatarGuild"
                                     src="{{URL('storage/' . $guild->img)}}" />
                                <div class="ms-3">
                                    <h1 class="card-title mb-0 fw-bold">
                                        <p> {{ $guild->name }} </p>
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 justify-content-between border-bottom">
                            <div class="col-auto ">
                                <h3 for="armadura" class="fw-bold">Líder</h3>
                                <a class="nav-link fs-5" href=""> {{ $guild->leader->name}}</a>
                            </div>
                            <div class="col-auto my-2">
                                <span class="fs-5">Número de cazadores: </span><p class="fs-1">{{ $guild->memberCount() }}/20</p>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-9">
                                <h3 class="fw-bold">Información:</h3>
                                <p class="fs-5 fw-light">
                                    {{ $guild->info }}
                                </p>
                            </div>
                            <div class="col-auto">

                                @if (auth()->user()->hunter &&!(Auth::user()->hunter->isLeader($guild)) && Auth::user()->hunter->guild_id != null && Auth::user()->hunter->guild_id == $guild->id)
                                <form id="leaveGuildForm" action="{{ route('hunter.leaveGuild') }}" method="post">
                                    @csrf
                                    @method('put')
                                    <button type="button" class="btn btn-cerrar" onclick="confirmLeaveGuild()">Abandonar</button>
                                </form>                                
                                @elseif (auth()->user()->hunter&&$guild->memberCount()<20 && Auth::user()->hunter->guild_id === null )
                                <form action="{{ route('hunter.joinGuild', $guild) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-aceptar">Unirse</button>
                                </form>
                                @endif

                                @if (auth()->user()->hunter&&Auth::user()->hunter->isLeader($guild))
                                <a href="{{route('guild.edit', $guild)}}" class="btn btn-aceptar">Editar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card my-3 text-center">
                    <h2 class="border-bottom border-bottom fw-bold">ANUNCIO</h2>
                    <div class="anuncio">
                        <p class="fs-5">{{$guild->announcement}}</P>
                    </div>
                </div>
                <table class="table table-hover table-borderless">
                    <tr class="table-dark ">
                        <th class="text-center">Rango</th>
                        <th class="text-center"> Nombre</th>
                    </tr>
                    @foreach ($members as $member)
                        <tr>
                            @if ($member->id != $guild->leader->id)
                                <td class="text-center">Miembro</td>
                                <td class="align-middle text-center">
                                    <a href="/hunter/{{$member->id}}"class="linkTabla">{{ $member->name }}</a>
                                    </td>
                            @else
                                <td class="text-center">Líder</td>
                                <td class="align-middle text-center">
                                    <a href="/hunter/{{$member->id}}"class="linkTabla">{{ $member->name }}</a>
                                </td>
                            @endif

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function confirmLeaveGuild() {
        Swal.fire({
            title: '¿Estás seguro de que quieres abandonar el gremio?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#26555b',
            cancelButtonColor: '#d62b36',
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('leaveGuildForm').submit();
            }
        })
    }
</script>
    
    
@endsection
