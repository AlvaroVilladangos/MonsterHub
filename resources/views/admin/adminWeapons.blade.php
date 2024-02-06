@extends('compartidos.headerAndFooter')

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
                    @csrf
                    <div class="input-group mb-4 w-100 w-md-25" id="search-box">
                        <input name="search" type="search" class="form-control" placeholder="Search" />
                        <button type="submit" class="btn btn-aceptar">Buscar</button>
                    </div>
                </form>
            </div>

            <div class="col">
                <button type="button" class="btn btn-aceptar" data-bs-toggle="modal" data-bs-target="#weaponCreateModal">
                    Crear Arma
                </button>
            </div>
        </div>


        <div class="table-responsive table-responsive-stack">

        <table class="table table-hover mt-2">
            <tr class="table-dark ">
                <th class="text-center">Imagen</th>
                <th class="text-center"> Arma</th>
                <th class="text-center"> Monstruo</th>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <th></th>

            </tr>

            @foreach ($weapons as $weapon)
                <tr>
                    <td data-label="IMG" class="d-flex justify-content-center"> <img src="{{$weapon->image_url }}"
                            style="width:150px; height:auto;" alt=""></td>
                    <td data-label="NOMBRE" class="align-middle text-center"><a
                            href="/weapon/{{ $weapon->id }}  "class="linkTabla"
                            target="_blank">{{ $weapon->name }}</a>
                    </td>
                    <td data-label="MONSTRUO" class="align-middle text-center"><a
                            href="/monster/{{ $weapon->monster->id }}  "class="linkTabla"
                            target="_blank"> {{ $weapon->monster->name }}</a>
                    </td>
                    <td class="align-middle text-center">
                        <button type="button" class="btn btn-editar btn-sm" data-id="{{ $weapon->id }}"
                            data-bs-toggle="modal" data-bs-target="#weaponEditModal">EDITAR</button>
                    </td>
                    <td class="align-middle text-center">
                   @if ($weapon->id == 1)

                        @else
                        <form id="deleteWeaponForm{{ $weapon->id }}"
                            action="{{ route('weaponDestroy', ['id' => $weapon->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-cerrar btn-sm" type="button"
                                onclick="confirmDeleteWeapon({{ $weapon->id }})">ELIMINAR</button>
                        </form>
                        @endif
                    </td>

                    @if ($weapon->id == 1)
                        <td></td>
                    @else
                        @if ($weapon->blocked)
                            <td class="align-middle text-center">
                                <form action="{{ route('unBlockWeapon', ['id' => $weapon->id]) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <button class="btn btn-sm btn-aceptar" type="submit">Habilitar</button>
                                </form>

                            </td>
                        @else
                            <td class="align-middle text-center">

                                <form action="{{ route('blockWeapon', ['id' => $weapon->id]) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <button class="btn btn-sm btn-deshabilitar" type="submit">Deshabilitar</button>
                                </form>
                            </td>
                        @endif
                    @endif
                    <td></td>
                </tr>
            @endforeach
        </table>
    </div> 
        {{ $weapons->links() }}



    </div>


    <div class="modal fade" id="weaponEditModal" tabindex="-1"aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modalCardAdmin">
                <div class="modal-header">
                    <h1 class="tituloCard" id="guildModalLabel">Modificar Arma</h1>
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
                                <label for="weaponName" class="form-label fs-5 fw-bold">Nombre de la arma</label>
                                <input type="text" class="form-control mb-3" id="weaponName" name="weaponName">
                                <span id="errorWeaponName" class="error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="weaponAtk" class="form-label fs-5 fw-bold">Ataque</label>
                                <input type="text" class="form-control mb-3" id="weaponAtk" name="weaponAtk">
                                <span id="errorWeaponAtk" class="error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="weaponElement" class="form-label fs-5 fw-bold">Elemento</label>
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
                                <label for="weaponCrit" class="form-label fs-5 fw-bold">Critico</label>
                                <input type="text" class="form-control mb-3" id="weaponCrit" name="weaponCrit">
                                <span id="errorWeaponCrit" class="error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="weaponInfo" class="form-label fs-5 fw-bold">Información</label>
                                <textarea type="text" class="form-control mb-3" id="weaponInfo" name="weaponInfo"> </textarea>
                            </div>

                            <div class="mb-3">
                                <select name="weaponMonster_id" id="weaponMonster_id" required>
                                    <label for="weaponMonster_id" class="form-label fs-5 fw-bold">Monstruo</label> <br>
                                    @foreach ($monsters as $monster)
                                        <option value="{{ $monster->id }}"> {{ $monster->name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-aceptar"> Actualizar</button>

                        </form>
                    @else
                    @endisset
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cerrar" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="weaponCreateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modalCardAdmin">
                <div class="modal-header">
                    <h1 class="tituloCard" id="weaponModalLabel">Crear Arma</h1>
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
                            <label for="weaponName" class="form-label fs-5 fw-bold">Nombre del Arma</label>
                            <input type="text" class="form-control mb-3" id="weaponName" name="weaponName" required>
                        </div>

                        <div class="mb-3">
                            <label for="weaponAtk" class="form-label fs-5 fw-bold">Ataque</label>
                            <input type="text" class="form-control mb-3" id="weaponAtk" name="weaponAtk" required>
                        </div>

                        <div class="mb-3">
                            <label for="weaponElement" class="form-label fs-5 fw-bold">Elemento</label>
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
                            <label for="weaponCrit" class="form-label fs-5 fw-bold">Crítico</label>
                            <input type="text" class="form-control mb-3" id="weaponCrit" name="weaponCrit" required>
                        </div>

                        <div class="mb-3">
                            <label for="weaponInfo" class="form-label fs-5 fw-bold">Información</label>
                            <textarea type="text" class="form-control mb-3" id="weaponInfo" name="weaponInfo"> </textarea>
                        </div>

                        <div class="mb-3">
                            <label for="weaponMonster_id" class="form-label fs-5 fw-bold">Monstruo</label> <br>
                            <select name="weaponMonster_id" id="weaponMonster_id" required>
                                @foreach ($monstersNoWeapon as $monsterNoWeapon)
                                    <option value="{{ $monsterNoWeapon->id }}"> {{ $monsterNoWeapon->name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-aceptar"> Crear</button>
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
        function confirmDeleteWeapon(weaponId) {
            var form = document.getElementById('deleteWeaponForm' + weaponId);
            Swal.fire({
                title: '¿Estás seguro de que quieres eliminar la arma?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#183e43',
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

@vite('resources/js/adminWeapons.js')

@endsection
