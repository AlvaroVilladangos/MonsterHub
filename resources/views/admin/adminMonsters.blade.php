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
                <form action="{{ route('monstersAdmin') }}" method="get">
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
                        <form id="deleteMonsterForm" action="{{ route('monsterDestroy', ['id' => $monster->id]) }}"
                            method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="confirmDeleteMonster()">ELIMINAR</button>
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

                    <form id="monsterForm" method="post" action="{{ route('monsterUpdate', ['id' => $monster->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <img class="img-fluid mb-3" src="" alt="" name="monsterImg">
                        <input type="file" class="form-control mb-3" name="monsterImg">

                        <label for="monsterName" class="form-label">Nombre del Monstruo</label>
                        <input type="text" class="form-control mb-3" id="monsterName" name="monsterName">

                        <label for="monsterWeakness" class="form-label">Debilidad</label>
                        <input type="text" class="form-control mb-3" id="monsterWeakness" name="monsterWeakness">

                        <label for="monsterElement" class="form-label">Elemento</label>
                        <input type="text" class="form-control mb-3" id="monsterElement" name="monsterElement">

                        <label for="monsterPhysiology" class="form-label">Physiology</label>
                        <textarea type="text" class="form-control mb-3" id="monsterPhysiology" name="monsterPhysiology"> </textarea>


                        <label for="monsterAbilities" class="form-label">Abilities</label>
                        <textarea type="text" class="form-control mb-3" id="monsterAbilities" name="monsterAbilities"></textarea>


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
                        <img class="img-fluid mb-3" src="" alt="" name="monsterImg">
                        <input type="file" class="form-control mb-3" name="monsterImg" required>

                        <label for="monsterName" class="form-label">Nombre del Monstruo</label>
                        <input type="text" class="form-control mb-3" id="monsterName" name="monsterName" required>

                        <label for="monsterWeakness" class="form-label">Debilidad</label>
                        <input type="text" class="form-control mb-3" id="monsterWeakness" name="monsterWeakness"
                            required>

                        <label for="monsterElement" class="form-label">Elemento</label>
                        <input type="text" class="form-control mb-3" id="monsterElement" name="monsterElement"
                            required>

                        <label for="monsterPhysiology" class="form-label">Physiology</label>
                        <textarea type="text" class="form-control mb-3" id="monsterPhysiology" name="monsterPhysiology" required> </textarea>

                        <label for="monsterAbilities" class="form-label">Abilities</label>
                        <textarea type="text" class="form-control mb-3" id="monster " name="monsterAbilities" required></textarea>

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
                        $('#monsterEditModal .modal-body input[name="monsterElement"]').val(data
                            .element);
                        $('#monsterEditModal .modal-body input[name="monsterWeakness"]').val(
                            data.weakness);
                        $('#monsterEditModal .modal-body textarea[name="monsterPhysiology"]')
                            .val(data.physiology);
                        $('#monsterEditModal .modal-body textarea[name="monsterAbilities"]')
                            .val(data.abilities);

                        $('#monsterForm').attr('action', '/monster/' + monsterId + '/update');
                    }
                });
                monster / {
                    id
                }
                /update


                $('#monsterEditModal').modal('show');
            });
        });
    </script>



    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        function confirmDeleteMonster() {
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
                    document.getElementById('deleteMonsterForm').submit();
                }
            })
        }
    </script>
@endsection
