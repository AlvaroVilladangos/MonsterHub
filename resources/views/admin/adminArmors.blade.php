@extends('compartidos.adminHeaderAndFooter')

@section('content')

    @if (session('error'))
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="container py-4">

        <div class="row">
            <div class="col">
                <form action="{{ route('armorsAdmin') }}" method="get">
                    <div class="input-group mb-4 w-25" id="search-box">
                        <input name="search" type="search" class="form-control" placeholder="Search" />
                        <button type="submit" class="btn btn-dark">search</button>
                    </div>
                </form>
            </div>

            <div class="col">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#armorCreateModal">
                    Crear Armadura
                </button>
            </div>
        </div>



        <table class="table table-hover table-borderless">
            <tr class="table-dark ">
                <th class="text-center">Imagen</th>
                <th class="text-center"> Armadura</th>
                <th class="text-center"> Monstruo</th>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center"></th>
            </tr>

            @foreach ($armors as $armor)
                <tr>
                    <td class="d-flex justify-content-center"> <img src="{{ URL('storage/' . $armor->img) }}"
                            style="width:150px; height:auto;" alt=""></td>
                    <td class="align-middle text-center"><a
                            href="/armor/{{ $armor->id }}  "class="nav-link text-decoration-underline"
                            target="_blank">{{ $armor->name }}</a>
                    </td>

                    <td class="align-middle text-center"><a
                            href="/monster/{{ $armor->monster->id }}  "class="nav-link text-decoration-underline">{{ $armor->monster->name }}</a>
                    </td>

                    <td class="align-middle text-center">
                        <button type="button" class="btn btn-warning btn-sm" data-id="{{ $armor->id }}"
                            data-bs-toggle="modal" data-bs-target="#armorEditModal">EDITAR</button>
                    </td>
                    <td class="align-middle text-center">
                        <form id="deleteArmorForm{{ $armor->id }}"
                            action="{{ route('armorDestroy', ['id' => $armor->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="confirmDeleteArmor({{ $armor->id }})">ELIMINAR</button>
                        </form>
                    </td>


                    @if ($armor->blocked)
                        <td class="align-middle text-center">

                            <form action="{{ route('unBlockArmor', ['id' => $armor->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-success" type="submit">Habilitar</button>
                            </form>

                        </td>
                    @else
                        <td class="align-middle text-center">
                            <form action="{{ route('blockArmor', ['id' => $armor->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-primary" type="submit">Deshabilitar</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>

        {{ $armors->links() }}



    </div>


    <div class="modal fade" id="armorEditModal" tabindex="-1"aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="guildModalLabel">Modificar armadura</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    @isset($armor)
                        <form id="armorEditForm" method="post" action="{{ route('armorUpdate', ['id' => $armor->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <img class="img-fluid mb-3" src="" alt="" name="armorImg">
                                <input type="file" class="form-control mb-3" name="armorImg">
                            </div>

                            <div class="mb-3">
                                <label for="armorName" class="form-label">Nombre de la armadura</label>
                                <input type="text" class="form-control mb-3" id="armorName" name="armorName">
                                <span id="errorArmorName" class="text-primary"></span>
                            </div>

                            <div class="mb-3">
                                <label for="armorDef" class="form-label">Defensa</label>
                                <input type="text" class="form-control mb-3" id="armorDef" name="armorDef">
                                <span id="errorArmorDef" class="text-primary"></span>
                            </div>

                            <div class="mb-3">
                                <label for="armorInfo" class="form-label">Información</label>
                                <textarea type="text" class="form-control mb-3" id="armorInfo" name="armorInfo"> </textarea>
                            </div>


                            <div class="mb-3">
                                <select name="armorMonster_id" id="armorMonster_id" required>
                                    @foreach ($monsters as $monster)
                                        <option value="{{ $monster->id }}"> {{ $monster->name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-dark"> Actualizar</button>

                        </form>
                    @else
                    @endisset
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="armorCreateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="armorModalLabel">Crear armadura</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="armorCreateForm" method="post" action="{{ route('armorStore') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <img class="img-fluid mb-3" src="" alt="" name="armorImg">
                            <input type="file" class="form-control mb-3" name="armorImg" required>
                        </div>

                        <div class="mb-3">
                            <label for="armorName" class="form-label">Nombre del armadura</label>
                            <input type="text" class="form-control mb-3" id="armorName" name="armorName" required>
                        </div>

                        <div class="mb-3">
                            <label for="armorDef" class="form-label">Defensa</label>
                            <input type="text" class="form-control mb-3" id="armorDef" name="armorDef" required>
                        </div>

                        <div class="mb-3">
                            <label for="armorInfo" class="form-label">Información</label>
                            <textarea type="text" class="form-control mb-3" id="armorInfo" name="armorInfo"> </textarea>
                        </div>

                        <div class="mb-3">
                            <select name="armorMonster_id" id="armorMonster_id" required>
                                @foreach ($monsters as $monster)
                                    <option value="{{ $monster->id }}"> {{ $monster->name }} </option>
                                @endforeach
                            </select>
                        </div>


                        <button type="submit" class="btn btn-dark"> Crear</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endsection





@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {
            $('.btn-warning').click(function() {
                var armorId = $(this).data('id');

                $.ajax({
                    url: '/armor/' + armorId + '/data',
                    method: 'GET',
                    success: function(data) {
                        var imgPath = 'storage/' + data.img;
                        $('#armorEditModal .modal-body img[name="armorImg"]').attr('src',
                            imgPath);
                        $('#armorEditModal .modal-body input[name="armorName"]').val(data
                            .name);

                        $('#armorEditModal .modal-body input[name="armorDef"]').val(
                            data.def);

                        $('#armorEditModal .modal-body textarea[name="armorInfo"]')
                            .val(data.info);

                        $('#armorForm').attr('action', '/armor/' + armorId + '/update');
                    }
                });

                $('#armorEditModal').modal('show');
            });
        });
    </script>




    <script>
        function confirmDeleteArmor(armorId) {
            var form = document.getElementById('deleteArmorForm' + armorId);
            Swal.fire({
                title: '¿Estás seguro de que quieres eliminar la armadura?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        }
    </script>


    <script>
        $.validator.addMethod("regex", function(value, element, regexpr) {
            return regexpr.test(value);
        }, "Por favor, introduce un valor válido.");

        $("#armorCreateForm").validate({
            rules: {
                armorImg: {
                    required: true,
                    extension: "jpg|png|jpeg"
                },
                armorName: {
                    required: true,
                    minlength: 2,
                    regex: /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/
                },
                armorDef: {
                    required: true,
                    number: true
                },
                armorInfo: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                armorImg: {
                    required: "Por favor, selecciona una imagen",
                    extension: "Por favor, selecciona una imagen válida (jpg, png, jpeg)"
                },
                armorName: {
                    required: "Por favor, introduce el nombre de la armadura",
                    minlength: "El nombre de la armadura debe tener al menos 2 caracteres",
                    regex: "La primera letra del nombre de la armadura debe ser mayúscula. El nombre puede contener solo letras, incluyendo tildes, la letra 'ñ' y espacios."
                },
                armorDef: {
                    required: "Por favor, introduce la defensa de la armadura",
                    number: "Por favor, introduce un número válido para la defensa"
                },
                armorInfo: {
                    required: "Por favor, introduce la información de la armadura",
                    minlength: "La información de la armadura debe tener al menos 10 caracteres"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    </script>

    <script>
        function validarArmorName(armorName) {
            var regexCaracteres = /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/;
            var error = document.getElementById("errorArmorName");

            if (!regexCaracteres.test(armorName)) {
                error.textContent =
                    "La primera letra del nombre de la armadura debe ser mayúscula. El nombre puede contener solo letras.";
                document.getElementById("armorName").value = '';
                return false;
            }
            if (armorName.length > 20) {
                error.textContent = "El nombre de la armadura no puede tener más de 20 caracteres.";
                document.getElementById("armorName").value = '';
                return false;
            }
            if (armorName.length < 4) {
                error.textContent = "El nombre de la armadura no puede tener menos de 4 letras.";
                document.getElementById("armorName").value = '';
                return false;
            } else {
                error.textContent = "";
                return true;
            }
        }

        function validarArmorDef(armorDef) {
            var error = document.getElementById("errorArmorDef");

            if (isNaN(armorDef) || armorDef < 0 || armorDef > 200) {
                error.textContent = 'La defensa de la armadura debe ser un número entre 0 y 200';
                document.getElementById("armorDef").value = '';
                return false;
            } else {
                return true;
            }
        }

        document.getElementById('armorEditForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var isValid = true;

            var armorName = document.getElementById('armorName').value;
            if (!validarArmorName(armorName)) {
                isValid = false;
            }

            var armorDef = document.getElementById('armorDef').value;
            if (!validarArmorDef(armorDef)) {
                isValid = false;
            }

            if (isValid) {
                this.submit();
            }
        });
    </script>
@endsection
