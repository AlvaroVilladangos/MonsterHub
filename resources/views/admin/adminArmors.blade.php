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
                        <form id="armorForm" method="post" action="{{ route('armorUpdate', ['id' => $armor->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <img class="img-fluid mb-3" src="" alt="" name="armorImg">
                            <input type="file" class="form-control mb-3" name="armorImg">

                            <label for="armorName" class="form-label">Nombre de la armadura</label>
                            <input type="text" class="form-control mb-3" id="armorName" name="armorName">

                            <label for="armorDef" class="form-label">Defensa</label>
                            <input type="text" class="form-control mb-3" id="armorDef" name="armorDef">

                            <label for="armorInfo" class="form-label">Información</label>
                            <textarea type="text" class="form-control mb-3" id="armorInfo" name="armorInfo"> </textarea>


                            <select name="armorMonster_id" id="armorMonster_id" required>
                                @foreach ($monsters as $monster)
                                    <option value="{{ $monster->id }}"> {{ $monster->name }} </option>
                                @endforeach
                            </select>

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
                        <img class="img-fluid mb-3" src="" alt="" name="armorImg">
                        <input type="file" class="form-control mb-3" name="armorImg" required>

                        <label for="armorName" class="form-label">Nombre del armadura</label>
                        <input type="text" class="form-control mb-3" id="armorName" name="armorName" required>

                        <label for="armorDef" class="form-label">Defensa</label>
                        <input type="text" class="form-control mb-3" id="armorDef" name="armorDef" required>

                        <label for="armorInfo" class="form-label">Información</label>
                        <textarea type="text" class="form-control mb-3" id="armorInfo" name="armorInfo"> </textarea>

                        <select name="armorMonster_id" id="armorMonster_id" required>
                            @foreach ($monsters as $monster)
                                <option value="{{ $monster->id }}"> {{ $monster->name }} </option>
                            @endforeach
                        </select>


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
                armor / {
                    id
                }
                /update


                $('#armorEditModal').modal('show');
            });
        });
    </script>



    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
@endsection
