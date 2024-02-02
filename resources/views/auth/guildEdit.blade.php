@extends('compartidos.headerAndFooter')
@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="col-2 mb-3">
            </div>

            <div class="col-8">
                <form id="formEditGuild" enctype="multipart/form-data" action="{{ route('guild.update', $guild) }}"
                    method="post">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="px-3 pt-4 pb-2">
                            <div class="d-flex align-items-center justify-content-between border-bottom">
                                <div class="d-flex align-items-center">
                                    <img class="avatarGuild"
                                        src="{{ URL('storage/' . $guild->img) }}" />
                                    <div>
                                        <input class="form-control mx-3" name="guildName" type="text"
                                            value="{{ $guild->name }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label for=""> Imagen de gremio</label>
                                <input type="file" name="img" class="form-control">
                            </div>
                            <div class="row mt-3 justify-content-between border-bottom">
                                <div class="col-auto ">
                                    <h3 for="armadura" class="fw-bold">Líder</h3>
                                    <a class="nav-link fs-5" href="">{{ $guild->leader->name }}</a>
                                </div>
                                <div class="col-auto my-2">
                                    <span class="fs-5">Número de cazadores: </span> <p class="fs-1"><p class="fs-1">{{ $guild->memberCount() }}/20</p>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-9">
                                    <h3 class="fw-bold">Información :</h3>
                                    <textarea class="form-control" style="resize: none" name="guildInfo" id="" cols="30" rows="3">{{ $guild->info }}</textarea>
                                </div>
                                <div class="col">
                                    <button class="btn btn-aceptar" type="submit">Editar</button>
                                </div>
                                <div class="col">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card my-3 text-center">
                        <h2 class="border-bottom border-bottom fw-bold">ANUNCIO</h2>
                        <textarea class="form-control" style="resize: none" name="announcement" id="" cols="30" rows="3">{{ $guild->announcement }}</textarea>
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
                                    <a href="/monster/"class="linkTabla">{{ $member->name }}</a>
                                </td>
                                <form id="expulsionForm-{{ $member->id }}"
                                    action="{{ route('guild.expulsar', ['guild' => $guild, 'member' => $member]) }}"
                                    method="post">
                                    @csrf
                                    @method('put')
                                    <td class="align-middle text-center"><button type="button" class="btn btn-cerrar"
                                            onclick="confirmExpulsion({{ $member->id }})">Expulsar</button></td>
                                </form>

                                <form id="ascensionForm-{{ $member->id }}"
                                    action="{{ route('guild.ascender', ['guild' => $guild, 'member' => $member]) }}"
                                    method="post">
                                    @csrf
                                    @method('put')
                                    <td class="align-middle text-center"><button type="button" class="btn btn-aceptar"
                                            onclick="confirmAscension({{ $member->id }})">Ascender</button></td>
                                </form>
                            @else
                                <td class="text-center">Líder</td>
                                <td class="align-middle text-center">
                                    <a href="/monster/"class="linkTabla">{{ $member->name }}</a>
                                </td>
                                <td></td>
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="col-2 mb-3">

                <form id="deleteGuildForm{{ $guild->id }}" action="{{ route('guildDestroy', ['id' => $guild->id]) }}"
                    method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-cerrar btn-lg" type="button"
                        onclick="confirmDeleteGuild({{ $guild->id }})">ELIMINAR GREMIO</button>
                </form>

            </div>
        </div>
    </div>
@endsection



@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#formEditGuild").validate({
                rules: {
                    guildName: {
                        required: true,
                        minlength: 4,
                        maxlength: 25,
                        regex: /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/
                    },
                    img: {
                        extension: "jpeg|jpg|png|webp"
                    },
                    guildInfo: {
                        required: true,
                        minlength: 10
                    },
                    announcement: {
                        maxlength: 50
                    }
                },
                messages: {
                    guildName: {
                        required: "Por favor, introduce el nombre del gremio",
                        minlength: "El nombre del gremio debe tener al menos 4 caracteres"
                    },
                    img: {
                        required: "Por favor, selecciona una imagen",
                        extension: "Por favor, selecciona una imagen válida (jpeg, jpg, png, gif)"
                    },
                    guildInfo: {
                        required: "Por favor, introduce la información del gremio",
                        minlength: "La información del gremio debe tener al menos 10 caracteres"
                    },
                    announcement: {
                        maxlength: "El anuncio debe tener como máximo 50 caracteres."
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            $.validator.addMethod("regex", function(value, element, regexpr) {
                return regexpr.test(value);
            }, "Por favor, introduce un valor válido, que empiece por mayúscula");
        });
    </script>

    <script>
        function confirmExpulsion(memberId) {
            Swal.fire({
                title: '¿Estás seguro que quieres expulsar a este miembro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#26555b',
                cancelButtonColor: '#e43944',
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
                confirmButtonColor: '#26555b',
                cancelButtonColor: '#e43944',
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('ascensionForm-' + memberId).submit();
                }
            })
        }

        function confirmDeleteGuild(guildId) {
            var form = document.getElementById('deleteGuildForm' + guildId);
            Swal.fire({
                title: '¿Estás seguro de que quieres eliminar la guild?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#26555b',
                cancelButtonColor: '#e43944',
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
