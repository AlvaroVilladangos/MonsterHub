@extends('compartidos.headerAndFooter')
@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="col-2 mb-3">

            </div>

            <div class="col-8">
                    <form action="{{ route('guild.update', $guild) }}" method="post">
                        @csrf
                        @method('PUT')

                    <div class="card">
                        <div class="px-3 pt-4 pb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img style="width: 50px" class="me-3 avatar-sm rounded-circle"
                                        src="https://api.dicebear.com/6.x/fun-emoji/svg?seed=Mario" alt="Mario Avatar" />
                                    <div>
                                        <h1 class="card-title mb-0 fw-bold">
                                            <input name="guildName" type="text" value="{{ $guild->name }}">
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 justify-content-between">
                                <div class="col-auto">
                                    <h3 for="armadura" class="">Lider</h3>
                                    <a class="nav-link fs-5" href="">{{ $guild->leader->name }}</a>
                                </div>
                                <div class="col-auto">
                                    <p class="fs-1">{{ $guild->memberCount() }}/20</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-9">
                                    <h3 class="">Información :</h3>
                                    <textarea style="resize: none" name="guildInfo" id="" cols="30" rows="3">{{ $guild->info }}
                                </textarea>
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary" type="submit">Editar</button>
                                </div>
                                {{--                             <div class="col-auto">
                                @if (Auth::user()->hunter->guild_id === $guild->id)
                                <button class="btn btn-danger">Abandonar</button>
                                @elseif ($guild->memberCount()<20)
                                <button class="btn btn-success">Unirse</button>
                                @endif

                                @if ($guild->leader_id == Auth::user()->hunter->id)
                                <button class="btn btn-primary">Editar</button>
                                @endif
                            </div> --}}
                            </div>
                        </div>

                    </div>

                    <div class="card my-3 text-center">
                        <h2 class="border-bottom border-primary fw-bold">ANUNCIO</h2>
                        <textarea style="resize: none" name="announcement" id="" cols="30" rows="3"> {{ $guild->announcement }}
                    </textarea>
                    </div>
            </form>
            <table class="table table-hover table-borderless">
                <tr class="table-dark ">
                    <th class="text-center">Rango</th>
                    <th class="text-center"> Nombre</th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                </tr>
                @foreach ($members as $member)
                    <tr>
                        @if ($member->id != $guild->leader->id)
                            <td class="text-center">Miembro</td>
                            <td class="align-middle text-center">
                                <ahref="/monster/"class="nav-link text-decoration-underline">{{ $member->name }}</a>
                            </td>
                            <form id="expulsionForm-{{ $member->id }}" action="{{route('guild.expulsar', ['guild' => $guild, 'member' => $member])}}" method="post">
                                @csrf
                                @method('put')
                                <td class="align-middle text-center"><button type="button" class="btn btn-danger" onclick="confirmExpulsion({{ $member->id }})">Expulsar</button></td>
                            </form>

                            <form id="ascensionForm-{{ $member->id }}" action="{{route('guild.ascender', ['guild' => $guild, 'member' => $member])}}" method="post">
                                @csrf
                                @method('put')
                                <td class="align-middle text-center"><button type="button" class="btn btn-success" onclick="confirmAscension({{ $member->id }})">Ascender</button></td>
                            </form>
                        @else
                            <td class="text-center">Lider</td>
                            <td class="align-middle text-center">
                                <ahref="/monster/"class="nav-link text-decoration-underline">{{ $member->name }}</a>
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
    function confirmExpulsion(memberId) {
        Swal.fire({
            title: '¿Estás seguro que quieres expulsar a este miembro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('expulsionForm-' + memberId).submit();
            }
        })
    }


    function confirmAscension(memberId) {
        Swal.fire({
            title: '¿Estás seguro que quieres ascender a este miembro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('ascensionForm-' + memberId).submit();
            }
        })
    }
</script>
    
@endsection
