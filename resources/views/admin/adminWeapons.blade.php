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
                <form action="{{ route('weaponsAdmin') }}" method="get">
                    <div class="input-group mb-4 w-25" id="search-box">
                        <input name="search" type="search" class="form-control" placeholder="Search" />
                        <button type="submit" class="btn btn-dark">search</button>
                    </div>
                </form>
            </div>

            <div class="col">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#weaponCreateModal">
                    Crear Arma
                </button>
            </div>
        </div>



        <table class="table table-hover table-borderless">
            <tr class="table-dark ">
                <th class="text-center">Imagen</th>
                <th class="text-center"> Arma</th>
                <th class="text-center"> Monstruo</th>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center"></th>

            </tr>

            @foreach ($weapons as $weapon)
                <tr>
                    <td class="d-flex justify-content-center"> <img src="{{ URL('storage/' . $weapon->img) }}"
                            style="width:150px; height:auto;" alt=""></td>
                    <td class="align-middle text-center"><a
                            href="/weapon/{{ $weapon->id }}  "class="nav-link text-decoration-underline"
                            target="_blank">{{ $weapon->name }}</a>
                    </td>
                    <td class="align-middle text-center"><a
                            href="/monster/{{ $weapon->monster->id }}  "class="nav-link text-decoration-underline"
                            target="_blank"> {{ $weapon->monster->name }}</a>
                    </td>
                    <td class="align-middle text-center">
                        <button type="button" class="btn btn-warning btn-sm" data-id="{{ $weapon->id }}"
                            data-bs-toggle="modal" data-bs-target="#weaponEditModal">EDITAR</button>
                    </td>
                    <td class="align-middle text-center">
                        <form id="deleteWeaponForm{{ $weapon->id }}"
                            action="{{ route('weaponDestroy', ['id' => $weapon->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="confirmDeleteWeapon({{ $weapon->id }})">ELIMINAR</button>
                        </form>
                    </td>

                    @if ($weapon->blocked)
                        <td class="align-middle text-center">

                            <form action="{{ route('unBlockWeapon', ['id' => $weapon->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-success" type="submit">Habilitar</button>
                            </form>

                        </td>
                    @else
                        <td class="align-middle text-center">

                            <form action="{{ route('blockWeapon', ['id' => $weapon->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-primary" type="submit">Deshabilitar</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>

        {{ $weapons->links() }}



    </div>


    <div class="modal fade" id="weaponEditModal" tabindex="-1"aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="guildModalLabel">Modificar Arma</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    @isset($weapon)
                        <form id="weaponUpadteForm" method="post" action="{{ route('weaponUpdate', ['id' => $weapon->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <img class="img-fluid mb-3" src="" alt="" name="weaponImg">
                                <input type="file" class="form-control mb-3" name="weaponImg">
                            </div>

                            <div class="mb-3">
                                <label for="weaponName" class="form-label">Nombre de la arma</label>
                                <input type="text" class="form-control mb-3" id="weaponName" name="weaponName">
                                <span id="errorWeaponName" class="text-primary"></span>
                            </div>

                            <div class="mb-3">
                                <label for="weaponAtk" class="form-label">Ataque</label>
                                <input type="text" class="form-control mb-3" id="weaponAtk" name="weaponAtk">
                                <span id="errorWeaponAtk" class="text-primary"></span>
                            </div>

                            <div class="mb-3">
                                <label for="weaponElement" class="form-label">Elemento</label>
                                <select name="weaponElement" id="weaponElement" class="form-select" required>
                                    <option value="Agua">Agua</option>
                                    <option value="Fuego">Fuego</option>
                                    <option value="Eléctrico">Eléctrico</option>
                                    <option value="Hielo">Hielo</option>
                                    <option value="Dragón">Dragón</option>
                                    <option value="Neutro">Neutro</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="weaponCrit" class="form-label">Critico</label>
                                <input type="text" class="form-control mb-3" id="weaponCrit" name="weaponCrit">
                                <span id="errorWeaponCrit" class="text-primary"></span>
                            </div>

                            <div class="mb-3">
                                <label for="weaponInfo" class="form-label">Información</label>
                                <textarea type="text" class="form-control mb-3" id="weaponInfo" name="weaponInfo"> </textarea>
                            </div>

                            <div class="mb-3">
                                <select name="weaponMonster_id" id="weaponMonster_id" required>
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

    <div class="modal fade" id="weaponCreateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="weaponModalLabel">Crear Arma</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="weaponCreateForm" method="post" action="{{ route('weaponStore') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <img class="img-fluid mb-3" src="" alt="" name="weaponImg">
                            <input type="file" class="form-control mb-3" name="weaponImg" required>
                        </div>

                        <div class="mb-3">
                            <label for="weaponName" class="form-label">Nombre del Arma</label>
                            <input type="text" class="form-control mb-3" id="weaponName" name="weaponName" required>
                        </div>

                        <div class="mb-3">
                            <label for="weaponAtk" class="form-label">Ataque</label>
                            <input type="text" class="form-control mb-3" id="weaponAtk" name="weaponAtk" required>
                        </div>

                        <div class="mb-3">
                            <label for="weaponElement" class="form-label">Elemento</label>
                            <select name="weaponElement" id="weaponElement" class="form-select" required>
                                <option value="Agua">Agua</option>
                                <option value="Fuego">Fuego</option>
                                <option value="Eléctrico">Eléctrico</option>
                                <option value="Hielo">Hielo</option>
                                <option value="Dragón">Dragón</option>
                                <option value="Neutro">Neutro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="weaponCrit" class="form-label">Crítico</label>
                            <input type="text" class="form-control mb-3" id="weaponCrit" name="weaponCrit" required>
                        </div>

                        <div class="mb-3">
                            <label for="weaponInfo" class="form-label">Información</label>
                            <textarea type="text" class="form-control mb-3" id="weaponInfo" name="weaponInfo"> </textarea>
                        </div>

                        <div class="mb-3">
                            <select name="weaponMonster_id" id="weaponMonster_id" required>
                                @foreach ($monstersNoWeapon as $monsterNoWeapon)
                                    <option value="{{ $monsterNoWeapon->id }}"> {{ $monsterNoWeapon->name }} </option>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.btn-warning').click(function() {
                var weaponId = $(this).data('id');

                $.ajax({
                    url: '/weapon/' + weaponId + '/data',
                    method: 'GET',
                    success: function(data) {
                        var imgPath = 'storage/' + data.img;
                        $('#weaponEditModal .modal-body img[name="weaponImg"]').attr('src',
                            imgPath);
                        $('#weaponEditModal .modal-body input[name="weaponName"]').val(data
                            .name);
                        $('#weaponEditModal .modal-body input[name="weaponElement"]').val(data
                            .element);
                        $('#weaponEditModal .modal-body input[name="weaponAtk"]').val(
                            data.atk);
                        $('#weaponEditModal .modal-body input[name="weaponCrit"]').val(
                            data.crit);
                        $('#weaponEditModal .modal-body textarea[name="weaponInfo"]')
                            .val(data.info);
                        $('#weaponEditModal .modal-body select[name="weaponMonster_id"]').val(
                            data.monster_id);

                        $('#weaponUpadteForm').attr('action', '/weapon/' + weaponId +
                            '/update');
                    }
                });
                $('#weaponEditModal').modal('show');
            });
        });
    </script>

    <script>
        $.validator.addMethod("regex", function(value, element, regexpr) {
            return regexpr.test(value);
        }, "Por favor, introduce un valor válido.");

        $("#weaponCreateForm").validate({
            rules: {
                weaponImg: {
                    required: true,
                    extension: "jpg|png|jpeg|webp"
                },
                weaponName: {
                    required: true,
                    minlength: 2,
                    regex: /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/
                },
                weaponAtk: {
                    required: true,
                    number: true,
                    min:100,
                    max: 1000
                },
                weaponElement: {
                    required: true
                },
                weaponCrit: {
                    required: true,
                    number: true,
                    max: 100
                },
                weaponInfo: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                weaponImg: {
                    required: "Por favor, selecciona una imagen",
                    extension: "Por favor, selecciona una imagen válida (jpg, png, jpeg)"
                },
                weaponName: {
                    required: "Por favor, introduce el nombre de la arma",
                    minlength: "El nombre de la arma debe tener al menos 2 caracteres",
                    regex: "La primera letra del nombre de la arma debe ser mayúscula. El nombre puede contener solo letras, incluyendo tildes, la letra 'ñ' y espacios."
                },
                weaponAtk: {
                    required: "Por favor, introduce el ataque de la arma",
                    number: "Por favor, introduce un número válido para el ataque",
                    min: "Por favor, introduce un número mayor o igual a 100",
                    max: "Por favor, introduce un número menor o igual a 1000"
                },
                weaponElement: {
                    required: "Por favor, selecciona un elemento"
                },
                weaponCrit: {
                    required: "Por favor, introduce el crítico de la arma",
                    number: "Por favor, introduce un número válido para el crítico",
                    max: "Por favor, introduce un número menor o igual a 100"
                },
                weaponInfo: {
                    required: "Por favor, introduce la información de la arma",
                    minlength: "La información de la arma debe tener al menos 10 caracteres"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    </script>


    <script>
        function validarWeaponName(weaponName) {
            var regexCaracteres = /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/;
            var error = document.getElementById("errorWeaponName");

            if (!regexCaracteres.test(weaponName)) {
                error.textContent =
                    "La primera letra del nombre del arma debe ser mayúscula. El nombre puede contener solo letras.";
                document.getElementById("weaponName").value = '';
                return false;
            }
            if (weaponName.length > 20) {
                error.textContent = "El nombre del arma no puede tener más de 20 caracteres.";
                document.getElementById("weaponName").value = '';
                return false;
            }
            if (weaponName.length < 4) {
                error.textContent = "El nombre del arma no puede tener menos de 4 letras.";
                document.getElementById("weaponName").value = '';
                return false;
            } else {
                error.textContent = "";
                return true;
            }
        }

        function validarWeaponAtk(weaponAtk) {
            var error = document.getElementById("errorWeaponAtk");

            if (isNaN(weaponAtk) || weaponAtk < 100|| weaponAtk > 1000) {
                error.textContent = 'El ataque del arma debe ser un número entre 100 y 1000';
                document.getElementById("weaponAtk").value = '';
                return false;
            } else {
                return true;
            }
        }

        function validarWeaponCrit(weaponCrit) {
            var error = document.getElementById("errorWeaponCrit");

            if (isNaN(weaponCrit) || weaponCrit < 0 || weaponCrit > 100) {
                error.textContent = 'El crítico del arma debe ser un número entre 0 y 100';
                document.getElementById("weaponCrit").value = '';
                return false;
            } else {
                return true;
            }
        }

        document.getElementById('weaponUpadteForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var isValid = true;

            var weaponName = document.getElementById('weaponName').value;
            if (!validarWeaponName(weaponName)) {
                isValid = false;
            }

            var weaponAtk = document.getElementById('weaponAtk').value;
            if (!validarWeaponAtk(weaponAtk)) {
                isValid = false;
            }

            var weaponCrit = document.getElementById('weaponCrit').value;
            if (!validarWeaponCrit(weaponCrit)) {
                isValid = false;
            }

            if (isValid) {
                this.submit();
            }
        });
    </script>
    <script>
        function confirmDeleteWeapon(weaponId) {
            var form = document.getElementById('deleteWeaponForm' + weaponId);
            Swal.fire({
                title: '¿Estás seguro de que quieres eliminar la arma?',
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
@endsection
