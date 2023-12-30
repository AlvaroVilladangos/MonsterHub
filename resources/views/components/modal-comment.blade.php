<div
x-data = "{ show: false,  hunterId: $el.parentElement.dataset.hunterId }"
x-show = "show"
x-on:open-modal.window = "show = true"
x-on:close-modal.window = "show = false"
x-on:keydown.escape.window ="show = false"
>   

    <div class="card mt-3" style="width: 30rem; position: relative;">

        <button x-on:click="show = false" class="btn-close"></button>

        <form action="{{route("hunter.comment")}}" method="post">
            @csrf
            <input type="hidden" name="hunter_id" :value="hunterId">
            <div class="card-body">
                <textarea class="form-control" style="resize: none" name="commentMsg" id="" rows="3" placeholder="Escriba su comentario aquí"></textarea>
            </div>
            <button class="btn btn-sm btn-primary mx-2 my-2" type="submit">Comentar</button>
        </form>
    </div>

</div>
