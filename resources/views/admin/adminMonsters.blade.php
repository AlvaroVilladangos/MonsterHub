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
            <div class="col">
                <form action="{{ route('monstersAdmin') }}" method="get">
                    @csrf
                    <div class="input-group mb-4 w-25" id="search-box">
                        <input name="search" type="search" class="form-control" placeholder="Search" />
                        <button type="submit" class="btn btn-dark">search</button>
                    </div>
                </form>
            </div>

            <div class="col">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#monsterCreateModal">
                    Crear Monstruo
                </button>
            </div>
        </div>



        <table class="table table-hover table-borderless">
            <tr class="table-dark ">
                <th class="text-center">Imagen</th>
                <th class="text-center"> Monstruo</th>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center"></th>
            </tr>

            @foreach ($monsters as $monster)
                <tr>
                    <td class="d-flex justify-content-center"> <img src="{{ URL('storage/' . $monster->img) }}"
                            style="width:150px; height:auto;" alt=""></td>
                    <td class="align-middle text-center"><a
                            href="/monster/{{ $monster->id }}  "class="nav-link text-decoration-underline"
                            target="_blank">{{ $monster->name }}</a>
                    </td>
                    <td class="align-middle text-center">
                        <button type="button" class="btn btn-warning btn-sm" data-id="{{ $monster->id }}"
                            data-bs-toggle="modal" data-bs-target="#monsterEditModal">EDITAR</button>
                    </td>
                    <td class="align-middle text-center">
                        <form id="deleteMonsterForm{{ $monster->id }}"
                            action="{{ route('monsterDestroy', ['id' => $monster->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="confirmDeleteMonster({{ $monster->id }})">ELIMINAR</button>
                        </form>
                    </td>

                    @if ($monster->blocked)
                        <td class="align-middle text-center">

                            <form action="{{ route('unBlockMonster', ['id' => $monster->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-success" type="submit">Habilitar</button>
                            </form>

                        </td>
                    @else
                        <td class="align-middle text-center">

                            <form action="{{ route('blockMonster', ['id' => $monster->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-primary" type="submit">Deshabilitar</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>

        {{ $monsters->links() }}



    </div>


    <div class="modal fade" id="monsterEditModal" tabindex="-1"aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="guildModalLabel">Modificar Monstruo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="monsterEditForm" name="monsterEditForm" method="post"
                        action="{{ route('monsterUpdate', ['id' => $monster->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        
                        <div class="mb-3">
                            <img class="img-fluid mb-3" src="" alt="" name="monsterImg">
                            <input type="file" class="form-control mb-3" name="monsterImg">
                        </div>

                        <div class="mb-3">
                            <label for="monsterName" class="form-label">Nombre del Monstruo</label>
                            <input type="text" class="form-control mb-3" id="monsterName" name="monsterName"
                                required>
                            <span id="errorMonsterName" class="text-primary"></span>
                        </div>

                        <div class="mb-3">
                            <label for="monsterElement" class="form-label">Elemento</label>
                            <select name="monsterElement" id="monsterElement" class="form-select" required>
                                <option value="Agua">Agua</option>
                                <option value="Fuego">Fuego</option>
                                <option value="Eléctrico">Eléctrico</option>
                                <option value="Hielo">Hielo</option>
                                <option value="Dragón">Dragón</option>
                                <option value="Neutro">Neutro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="monsterWeakness" class="form-label">Debilidad</label>
                            <select name="monsterWeakness" id="monsterWeakness" class="form-select" required>
                                <option value="Agua">Agua</option>
                                <option value="Fuego">Fuego</option>
                                <option value="Eléctrico">Eléctrico</option>
                                <option value="Hielo">Hielo</option>
                                <option value="Dragón">Dragón</option>
                                <option value="Neutro">Neutro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="monsterPhysiology" class="form-label">Physiology</label>
                            <textarea type="text" class="form-control mb-3" id="monsterPhysiology" name="monsterPhysiology" required> </textarea>
                            <span id="errorMonsterPhysiology" class="text-primary"></span>
                        </div>


                        <div class="mb-3">
                            <label for="monsterAbilities" class="form-label">Abilities</label>
                            <textarea type="text" class="form-control mb-3" id="monsterAbilities" name="monsterAbilities" required></textarea>
                            <span id="errorMonsterAbilities" class="text-primary"></span>
                        </div>

                        <button type="submit" class="btn btn-dark"> Actualizar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="monsterCreateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="monsterModalLabel">Crear Monstruo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="monsterCreateForm" method="post" action="{{ route('monsterStore') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <img class="img-fluid mb-3" src="" alt="" name="monsterImg">
                            <input type="file" class="form-control mb-3" name="monsterImg" required>
                        </div>

                        <div class="mb-3">
                            <label for="monsterName" class="form-label">Nombre del Monstruo</label>
                            <input type="text" class="form-control mb-3" id="monsterName" name="monsterName"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="monsterElement" class="form-label">Elemento</label>
                            <select name="monsterElement" id="monsterElement" class="form-select" required>
                                <option value="Agua">Agua</option>
                                <option value="Fuego">Fuego</option>
                                <option value="Eléctrico">Eléctrico</option>
                                <option value="Hielo">Hielo</option>
                                <option value="Dragón">Dragón</option>
                                <option value="Neutro">Neutro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="monsterWeakness" class="form-label">Debilidad</label>
                            <select name="monsterWeakness" id="monsterWeakness" class="form-select" required>
                                <option value="Agua">Agua</option>
                                <option value="Fuego">Fuego</option>
                                <option value="Eléctrico">Eléctrico</option>
                                <option value="Hielo">Hielo</option>
                                <option value="Dragón">Dragón</option>
                                <option value="Neutro">Neutro</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="monsterPhysiology" class="form-label">Physiology</label>
                            <textarea type="text" class="form-control mb-3" id="monsterPhysiology" name="monsterPhysiology" required> </textarea>
                        </div>

                        <div class="mb-3">
                            <label for="monsterAbilities" class="form-label">Abilities</label>
                            <textarea type="text" class="form-control mb-3" id="monsterAbilities" name="monsterAbilities" required></textarea>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.btn-warning').click(function() {
                var monsterId = $(this).data('id');

                $.ajax({
                    url: '/monster/' + monsterId + '/data',
                    method: 'GET',
                    success: function(data) {
                        var imgPath = 'storage/' + data.img;
                        $('#monsterEditModal .modal-body img[name="monsterImg"]').attr('src',
                            imgPath);
                        $('#monsterEditModal .modal-body input[name="monsterName"]').val(data
                            .name);
                        $('#monsterEditModal .modal-body select[name="monsterElement"]').val(
                            data
                            .element);
                        $('#monsterEditModal .modal-body select[name="monsterWeakness"]').val(
                            data.weakness);
                        $('#monsterEditModal .modal-body textarea[name="monsterPhysiology"]')
                            .val(data.physiology);
                        $('#monsterEditModal .modal-body textarea[name="monsterAbilities"]')
                            .val(data.abilities);

                        $('#monsterEditForm').attr('action', '/monster/' + monsterId +
                            '/update');
                    }
                });

                $('#monsterEditModal').modal('show');
            });
        });
    </script>

    <script>
        function confirmDeleteMonster(monsterId) {
            var form = document.getElementById('deleteMonsterForm' + monsterId);
            Swal.fire({
                title: '¿Estás seguro de que quieres eliminar el monstruo?',
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
    
    $(document).ready(function() {
        $("#monsterCreateForm").validate({
            rules: {
                monsterImg: {
                    required: true,
                    extension: "jpg|png|jpeg|webp"
                },
                monsterName: {
                    required: true,
                    minlength: 2,
                    regex: /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/
                },
                monsterElement: {
                    required: true
                },
                monsterWeakness: {
                    required: true
                },
                monsterPhysiology: {
                    required: true,
                    minlength: 10
                },
                monsterAbilities: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                monsterImg: {
                    required: "Por favor, selecciona una imagen",
                    extension: "Por favor, selecciona una imagen válida (jpg, png, jpeg)"
                },
                monsterName: {
                    required: "Por favor, introduce el nombre del monstruo",
                    minlength: "El nombre del monstruo debe tener al menos 2 caracteres",
                    regex: "La primera letra del nombre del monstruo debe ser mayúscula. El nombre puede contener solo letras, incluyendo tildes, la letra 'ñ' y espacios." // Agregamos el mensaje de error del regex aquí
                },
                monsterElement: {
                    required: "Por favor, selecciona un elemento"
                },
                monsterWeakness: {
                    required: "Por favor, selecciona una debilidad"
                },
                monsterPhysiology: {
                    required: "Por favor, introduce la fisiología del monstruo",
                    minlength: "La fisiología del monstruo debe tener al menos 10 caracteres"
                },
                monsterAbilities: {
                    required: "Por favor, introduce las habilidades del monstruo",
                    minlength: "Las habilidades del monstruo deben tener al menos 10 caracteres"
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
        function validarMonsterName(monsterName) {
            var regexCaracteres = /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/;
            var error = document.getElementById("errorMonsterName");

            if (!regexCaracteres.test(monsterName)) {
                error.textContent = "La primera letra del nombre del monstruo debe ser mayúscula. El nombre puede contener solo letras.";
                document.getElementById("monsterName").value = '';
                return false;
            }
            if (monsterName.length > 20) {
                error.textContent = "El nombre del monstruo no puede tener más de 20 caracteres.";
                document.getElementById("monsterName").value = '';
                return false;
            }
            if (monsterName.length < 4) {
                error.textContent = "El nombre del monstruo no puede tener menos de 4 letras.";
                document.getElementById("monsterName").value = '';
                return false;
            } else {
                error.textContent = "";
                return true;
            }
        }

        function validarMonsterPhysiology(monsterPhysiology) {
            var error = document.getElementById("errorMonsterPhysiology");

            if (monsterPhysiology.length < 10) {
                error.textContent = 'La fisiología del monstruo debe tener al menos 10 caracteres';
                document.getElementById("monsterPhysiology").value = '';
                return false;
            } else {
                return true;
            }
        }

        function validarMonsterAbilities(monsterAbilities) {
            var error = document.getElementById("errorMonsterAbilities");

            if (monsterAbilities.length < 10) {
                error.textContent = 'Las habilidades del monstruo deben tener al menos 10 caracteres';
                document.getElementById("monsterAbilities").value = '';
                return false;
            } else {
                return true;
            }
        }

        document.getElementById('monsterEditForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var isValid = true;

            var monsterName = document.getElementById('monsterName').value;
            if (!validarMonsterName(monsterName)) {
                isValid = false;
            }

            var monsterPhysiology = document.getElementById('monsterPhysiology').value;
            if (!validarMonsterPhysiology(monsterPhysiology)) {
                isValid = false;
            }

            var monsterAbilities = document.getElementById('monsterAbilities').value;
            if (!validarMonsterAbilities(monsterAbilities)) {
                isValid = false;
            }

            if (isValid) {
                this.submit();
            }
        });
    </script>
@endsection
