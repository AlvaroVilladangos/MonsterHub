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
                <form action="{{ route('armorsAdmin') }}" method="get">
                    @csrf
                    <div class="input-group mb-4 w-25" id="search-box">
                        <input name="search" type="search" class="form-control" placeholder="Search" />
                        <button type="submit" class="btn btn-aceptar">search</button>
                    </div>
                </form>
            </div>

            <div class="col">
                <button type="button" class="btn btn-aceptar" data-bs-toggle="modal" data-bs-target="#armorCreateModal">
                    Crear Armadura
                </button>
            </div>
        </div>



        <table class="table table-hover">
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
                            href="/armor/{{ $armor->id }}  "class="linkTabla"
                            target="_blank">{{ $armor->name }}</a>
                    </td>

                    <td class="align-middle text-center"><a
                            href="/monster/{{ $armor->monster->id }}  "class="linkTabla">{{ $armor->monster->name }}</a>
                    </td>

                    <td class="align-middle text-center">
                        <button type="button" class="btn btn-editar btn-sm" data-id="{{ $armor->id }}"
                            data-bs-toggle="modal" data-bs-target="#armorEditModal">EDITAR</button>
                    </td>
                    <td class="align-middle text-center">
                        <form id="deleteArmorForm{{ $armor->id }}"
                            action="{{ route('armorDestroy', ['id' => $armor->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-cerrar btn-sm" type="button"
                                onclick="confirmDeleteArmor({{ $armor->id }})">ELIMINAR</button>
                        </form>
                    </td>


                    @if ($armor->blocked)
                        <td class="align-middle text-center">
                            <form action="{{ route('unBlockArmor', ['id' => $armor->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-aceptar" type="submit">Habilitar</button>
                            </form>

                        </td>
                    @else
                        <td class="align-middle text-center">
                            <form action="{{ route('blockArmor', ['id' => $armor->id]) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-cerrar" type="submit">Deshabilitar</button>
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
            <div class="modal-content modalCardAdmin">
                <div class="modal-header">
                    <h1 class="tituloCard" id="guildModalLabel">Modificar armadura</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @isset($armor)
                        <form id="armorEditForm" method="post" action="{{ route('armorUpdate', ['id' => $armor->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="mb-3 imagen">
                                <img class="img-fluid mb-3" src="" alt="" name="armorImg">
                                <input type="file" class="form-control mb-3" name="armorImg">
                            </div>

                            <div class="mb-3">
                                <label for="armorName" class="form-label fs-5 fw-bold">Nombre de la armadura</label>
                                <input type="text" class="form-control mb-3" id="armorName" name="armorName">
                                <span id="errorArmorName" class="error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="armorDef" class="form-label fs-5 fw-bold">Defensa</label>
                                <input type="text" class="form-control mb-3" id="armorDef" name="armorDef">
                                <span id="errorArmorDef" class="error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="armorInfo" class="form-label fs-5 fw-bold">Información</label>
                                <textarea type="text" class="form-control mb-3" id="armorInfo" name="armorInfo"> </textarea>
                            </div>


                            <div class="mb-3">
                                <label for="armorMonster_id" class="form-label fs-5 fw-bold">Monstruo</label> <br>
                                <select name="armorMonster_id" id="armorMonster_id" required>
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

    <div class="modal fade" id="armorCreateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modalCardAdmin">
                <div class="modal-header">
                    <h1 class="tituloCard" id="armorModalLabel">Crear armadura</h1>
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
                            <label for="armorName" class="form-label fs-5 fw-bold">Nombre del armadura</label>
                            <input type="text" class="form-control mb-3" id="armorName" name="armorName" required>
                        </div>

                        <div class="mb-3">
                            <label for="armorDef" class="form-label fs-5 fw-bold">Defensa</label>
                            <input type="text" class="form-control mb-3" id="armorDef" name="armorDef" required>
                        </div>

                        <div class="mb-3">
                            <label for="armorInfo" class="form-label fs-5 fw-bold">Información</label>
                            <textarea type="text" class="form-control mb-3" id="armorInfo" name="armorInfo"> </textarea>
                        </div>

                        <div class="mb-3">
                            <label for="armorMonster_id" class="form-label fs-5 fw-bold">Monstruo</label> <br>
                            <select name="armorMonster_id" id="armorMonster_id" required>
                                @foreach ($monstersNoArmor as $monsterNoArmor)
                                    <option value="{{ $monsterNoArmor->id }}"> {{ $monsterNoArmor->name }} </option>
                                @endforeach
                            </select>
                        </div>


                        <button type="submit" class="btn btn-aceptar"> Crear</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cerrar" data-bs-dismiss="modal">Cerrar</button>
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
        function confirmDeleteArmor(armorId) {
            var form = document.getElementById('deleteArmorForm' + armorId);
            Swal.fire({
                title: '¿Estás seguro de que quieres eliminar la armadura?',
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

    @vite('resources/js/adminArmors.js')

@endsection
