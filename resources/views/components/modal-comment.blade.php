
<div
x-data = "{ show : false}"
x-show = "show"

x-on:open-modal.window = "show = true"
x-on:close-modal.window = "show = false"
>

    <div>
        <form action="" method="post">
            <textarea style="resize: none" name="msg" id="" cols="30" rows="3" placeholder="Escriba su comentario aquí">
            </textarea>       
        </form>
    </div>
</div>