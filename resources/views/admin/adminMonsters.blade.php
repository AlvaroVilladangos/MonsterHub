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

    @vite('resources/js/adminMonsters.js')

@endsection
