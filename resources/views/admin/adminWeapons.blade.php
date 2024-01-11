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
            </tr>

            @foreach ($weapons as $weapon)
                <tr>
                    <td class="d-flex justify-content-center"> <img src="{{ URL('storage/' . $weapon->img) }}"
                            style="width:150px; height:auto;" alt=""></td>
                    <td class="align-middle text-center"><a
                            href="/weapon/{{ $weapon->id }}  "class="nav-link text-decoration-underline" target="_blank">{{ $weapon->name }}</a>
                    </td>
                    <td class="align-middle text-center"><a
                        href="/monster/{{ $weapon->monster->id }}  "class="nav-link text-decoration-underline" target="_blank"> {{ $weapon->monster->name }}</a>
                    </td>
                    <td class="align-middle text-center">
                        <button type="button" class="btn btn-warning btn-sm" data-id="{{ $weapon->id }}"
                            data-bs-toggle="modal" data-bs-target="#weaponEditModal">EDITAR</button>
                    </td>
                    <td class="align-middle text-center">
                        <form id="deleteweaponForm" action="{{ route('weaponDestroy', ['id' => $weapon->id]) }}"
                            method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="confirmDeleteweapon()">ELIMINAR</button>
                        </form>
                    </td>
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


                    @isset ($weapon)
                        <form id="weaponForm" method="post" action="{{ route('weaponUpdate', ['id' => $weapon->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <img class="img-fluid mb-3" src="" alt="" name="weaponImg">
                            <input type="file" class="form-control mb-3" name="weaponImg">

                            <label for="weaponName" class="form-label">Nombre de la arma</label>
                            <input type="text" class="form-control mb-3" id="weaponName" name="weaponName">

                            <label for="weaponAtk" class="form-label">Ataque</label>
                            <input type="text" class="form-control mb-3" id="weaponAtk" name="weaponAtk">

                            <label for="weaponElement" class="form-label">Elemento</label>
                            <input type="text" class="form-control mb-3" id="weaponElement" name="weaponElement">

                            <label for="weaponCrit" class="form-label">Critico</label>
                            <input type="text" class="form-control mb-3" id="weaponCrit" name="weaponCrit">

                            <label for="weaponInfo" class="form-label">Información</label>
                            <textarea type="text" class="form-control mb-3" id="weaponInfo" name="weaponInfo"> </textarea>


                            <select name="weaponMonster_id" id="weaponMonster_id" required>
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
                        <img class="img-fluid mb-3" src="" alt="" name="weaponImg">
                        <input type="file" class="form-control mb-3" name="weaponImg" required>

                        <label for="weaponName" class="form-label">Nombre del Arma</label>
                        <input type="text" class="form-control mb-3" id="weaponName" name="weaponName" required>

                        <label for="weaponAtk" class="form-label">Ataque</label>
                        <input type="text" class="form-control mb-3" id="weaponAtk" name="weaponAtk" required>

                        <label for="weaponElement" class="form-label">Elemento</label>
                        <input type="text" class="form-control mb-3" id="weaponElement" name="weaponElement"
                            required>

                        <label for="weaponCrit" class="form-label">Crítico</label>
                        <input type="text" class="form-control mb-3" id="weaponCrit" name="weaponCrit" required>

                        <label for="weaponInfo" class="form-label">Información</label>
                        <textarea type="text" class="form-control mb-3" id="weaponInfo" name="weaponInfo"> </textarea>

                        <select name="weaponMonster_id" id="weaponMonster_id" required>
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

                        $('#weaponForm').attr('action', '/weapon/' + weaponId + '/update');
                    }
                });
                weapon / {
                    id
                }
                /update


                $('#weaponEditModal').modal('show');
            });
        });
    </script>



    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        function confirmDeleteweapon() {
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
                    document.getElementById('deleteweaponForm').submit();
                }
            })
        }
    </script>
@endsection
