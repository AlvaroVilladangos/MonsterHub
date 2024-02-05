@extends('compartidos.headerAndFooter')


@section('content')
    <div class="container py-4">

        <h2 class="tituloTabla mb-3">Lista de comentarios de {{ $hunter->name }}</h2>
        
        <table class="table table-hover">
            <tr class="table-dark ">
                <th class="text-center">Comentario</th>
                <th class="text-center">Dirigido a</th>
                <th class="text-center"></th>
            </tr>
        
            @foreach ($comments as $comment)
                <tr>
                    <td class="align-middle text-center">{{ $comment->msg }}</td>
                    <td class="align-middle text-center">{{ $comment->receiver->name }}</td>
                    <td class="align-middle text-center">
                        <form id="deleteForm-{{ $comment->id }}" action="{{ route('comment.destroy', $comment->id) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-sm btn-cerrar"
                                onclick="confirmDelete({{ $comment->id }})">Borrar</button>
                        </form>
                    </td>


                </tr>
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
                confirmButtonColor: '#183e43',
                cancelButtonColor: '#e43944',
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
