@extends('compartidos.adminHeaderAndFooter')


@section('content')
    <div class="container py-4">

        <h4 class="mb-3">Lista de comentarios de {{ $hunter->name }}</h4>

        <table class="table table-hover table-borderless">
            <tr class="table-dark ">
                <th class="text-center">Comentario</th>
                <th class="text-center">Dirigido a</th>
                <th class="text-center">Accion</th>
            </tr>

            @foreach ($comments as $comment)
                <td class="align-middle text-center">{{ $comment->msg }}</td>
                <td class="align-middle text-center">{{ $comment->receiver->name }}</td>
                <td class="align-middle text-center">
                    <form id="deleteForm-{{ $comment->id }}" action="{{ route('comment.destroy', $comment->id) }}"
                        method="post">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-sm btn-primary"
                            onclick="confirmDelete({{ $comment->id }})">Borrar</button>
                    </form>
                </td>
            @endforeach



        </table>

    </div>
@endsection



@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        function confirmDelete(commentId) {
            Swal.fire({
                title: '¿Estás seguro que quieres borrar el comentario?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + commentId).submit();
                }
            })
        }
    </script>
@endsection
