@extends('compartidos.headerAndFooter')


@section('content')

@error('guildName')
    <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 1;">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@enderror

    <div class="container py-4">
        <div class="row">
            <div class="col-2 mb-3">

            </div>
            <div class="col-8 mb-3">
                <form action="{{ route('guilds.index') }}" method="get">
                    @csrf
                    <div class="input-group mb-4 w-25" id="search-box">
                        <input name="search" type="search" class="form-control" placeholder="Search" />
                        <button type="submit" class="btn btn-aceptar">search</button>
                    </div>
                </form>
                <table class="table table-hover table-borderless">
                    <tr class="table-dark">
                        <th class="text-center">Guild</th>
                        <th class="text-center">Lider</th>
                        <th class="text-center">Miembros</th>
                        <th></th>
                    </tr>

                    @foreach ($guilds as $guild)
                        <tr class="border-bottom">
                            <td class="d-flex justify-content-center">
                                <div  class="d-flex align-items-center">
                                    <img style="width: 50px" class="me-3 avatar-sm rounded"
                                    src="{{URL('storage/' . $guild->img)}}" />
                                    <a href="/guild/{{ $guild->id }}"class="linkTabla">{{ $guild->name }}</a>
                                </div>
                            </td>
                            <td class="align-middle text-center"><a
                                    href="/hunter/{{ $guild->leader->id }}"class="linkTabla">
                                    {{ $guild->leader->name }}</a></td>
                            <td class="align-middle text-center"> {{ $guild->memberCount() }}</td>
                            @if ($guild->memberCount() >= 1)
                                <td></td>
                            @else
                                <td><button class="btn btn-success">Unirse</button></td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>



            @isset( Auth::user()->hunter->guild)
            @else
            <div class="col-2">
                <button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#guildModal">
                    CREA TU GUILD AQUÍ
                </button>
            </div>
            @endisset
            
            <div class="modal fade" id="guildModal" tabindex="-1" aria-labelledby="guildModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" id="guildModalLabel">Crear Guild</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form id="formCreateGuild" method="post" action="{{ route('guilds.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="guildName" class="form-label">Nombre del Guild</label>
                                    <input name="guildName" type="text" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="info" class="form-label">Información</label>
                                    <input name="guildInfo" type="text" class="form-control" id="info" required>
                                </div>
                                <div>
                                    <input name="leader_id" type="text" value="{{ Auth::user()->hunter->id }}" hidden>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar</button>
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


@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>

<script>
 $(document).ready(function() {
            $("#formCreateGuild").validate({
                rules: {
                    guildName: {
                        required: true,
                        minlength: 4,
                        maxlength: 25,
                        regex: /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/
                    },
                    guildInfo: {
                        required: true,
                        minlength: 10
                    },
                },
                messages: {
                    guildName: {
                        required: "Por favor, introduce el nombre del gremio",
                        minlength: "El nombre del gremio debe tener al menos 4 caracteres"
                    },
                    guildInfo: {
                        required: "Por favor, introduce la información del gremio",
                        minlength: "La información del gremio debe tener al menos 10 caracteres"
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

@endsection