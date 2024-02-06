@extends('compartidos.headerAndFooter')

@section('content')
    @if ($errors->any())
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    <div class="container py-4">
        <div class="row">
            <div class="col-2 mb-3">

            </div>
            <div class="col-8 mb-3">

                <form action="{{ route('rooms') }}" method="get">
                    @csrf
                    <div class="input-group mb-4 w-100 w-md-25" id="search-box">
                        <input name="search" type="search" class="form-control" placeholder="Search" />
                        <button type="submit" class="btn btn-aceptar">Buscar</button>
                    </div>
                </form>

                <h2 class = "tituloTabla"> Lista de salas disponibles</h2>
                <table class="table table-hover table-borderless">
                    <tr class="table-dark">
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
                        <tr class="border-bottom">
                            <td class="d-flex justify-content-center"> <img
                                    src="{{ URL('storage/' . $room->monster->img) }}" style="width:150px; height:auto;"
                                    alt=""></td>
                            <td class="align-middle text-center">{{ $room->monster->name }}</td>
                            <td class="align-middle text-center">{{ $room->roomCount() }}</td>
                            <td class="align-middle text-center">
                                @if (!isset(Auth::user()->hunter->room))
                                    <form action="{{ route('hunter.joinRoom') }}" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="" name="room_id" id="" value="{{ $room->id }}"
                                            hidden>
                                        <button class="btn btn-aceptar btn-sm" type="submit">Unirse</button>
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
                    <x-hunter-room :hunter="Auth::user()->hunter" />
                @else
                    <button type="button" class="btn btn-aceptar btn-lg" data-bs-toggle="modal" data-bs-target="#guildRoom">
                        Crear sala
                    </button>
                @endisset
            </div>

            <div class="modal fade" id="guildRoom" tabindex="-1" aria-labelledby="guildRoomLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content modalCardAdmin">
                        <div class="modal-header">
                            <h1 class="tituloCard" id="guildRoomLabel">Crear Sala</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form id="formCreateRoom" method="post" action="{{ route('rooms.store') }}">
                                @csrf
                                <label for="codigo" class="form-label fs-5 fw-bold">Codigo</label>
                                <input type="text" name="codigo" pattern="\d{5}"
                                    title="Por favor, introduzca exactamente 5 dígitos." class="form-control">

                                <div class="mb-3">
                                    <label for="name" class="form-label fs-5 fw-bold">Monstruo al que cazar</label> <br>
                                    <select size="1" name="monster" id="monster" class="select-control">
                                        @foreach ($monsters as $monster)
                                            <option value="{{ $monster->id }}"> {{ $monster->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <input name="hunter_1" type="text" value="{{ Auth::user()->hunter->id }}" hidden>
                                </div>
                                <button type="submit" class="btn btn-aceptar">Crear sala</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-cerrar" data-bs-dismiss="modal">Cerrar</button>
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
            $("#formCreateRoom").validate({
                rules: {
                    codigo: {
                        required: true,
                        regex: /^\d{5}$/
                    },

                },
                messages: {
                    codigo: {
                        required: "Por favor, introduce el código",
                        regex: "Por favor, introduce exactamente 5 dígitos"
                    },

                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $.validator.addMethod("regex", function(value, element, regexpr) {
                return regexpr.test(value);
            }, "Por favor, introduce un valor válido (5 cifras)");
        });
    </script>
@endsection
