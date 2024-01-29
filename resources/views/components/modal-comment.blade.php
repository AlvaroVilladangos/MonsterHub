<div
x-data = "{ 
    show: false,  
    hunterId: $el.parentElement.dataset.hunterId,
    open() {
        this.show = true;
        this.initValidator();
    },
    close() {
        this.show = false;
    },
    initValidator() {
        $('#commentForm').validate({ 
            rules: {
                commentMsg: {
                    required: true,
                    minlength: 5,
                    maxlength: 50

                }
            },
            messages: {
                commentMsg: {
                    required: 'Por favor, escribe un comentario',
                    minlength: 'Tu comentario debe tener al menos 5 caracteres',
                    maxlength: 'Tu comentario debe tener como maximo 50 caracteres'
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    }
}"
x-show = "show"
x-on:open-modal.window = "open"
x-on:close-modal.window = "close"
x-on:keydown.escape.window ="close"
x-cloak
>   

    <div class="card mt-3" style="width: 30rem; position: relative;">

        <button x-on:click="close" class="btn-close"></button>

        <form id="commentForm" action="{{route('hunter.comment')}}" method="post">
            @csrf
            <input type="hidden" name="hunter_id" :value="hunterId">
            <div class="card-body">
                <textarea class="form-control" style="resize: none" name="commentMsg" id="" rows="3" placeholder="Escriba su comentario aquí"></textarea>
            </div>
            <button class="btn btn-sm btn-primary mx-2 my-2" type="submit">Comentar</button>
        </form>
    </div>

</div>

