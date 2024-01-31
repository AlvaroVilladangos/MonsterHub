
/* Funcion Ajax para rellenar formulario de edicion */

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

                $('#armorEditModal .modal-body select[name="armorMonster_id"]').val(data.monster_id);

                $('#armorEditForm').attr('action', '/armor/' + armorId + '/update');
            }
        });
        $('#armorEditModal').modal('show');
    });
});

/* VALIDADOR PROPIO PARA EDICION ARMADURA */
function validarArmorName(armorName) {
    var regexCaracteres = /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/;
    var error = document.getElementById("errorArmorName");

    if (!regexCaracteres.test(armorName)) {
        error.textContent =
            "La primera letra del nombre de la armadura debe ser mayúscula. El nombre puede contener solo letras.";
        document.getElementById("armorName").value = '';
        return false;
    }
    if (armorName.length > 20) {
        error.textContent = "El nombre de la armadura no puede tener más de 20 caracteres.";
        document.getElementById("armorName").value = '';
        return false;
    }
    if (armorName.length < 4) {
        error.textContent = "El nombre de la armadura no puede tener menos de 4 letras.";
        document.getElementById("armorName").value = '';
        return false;
    } else {
        error.textContent = "";
        return true;
    }
}

function validarArmorDef(armorDef) {
    var error = document.getElementById("errorArmorDef");

    if (isNaN(armorDef) || armorDef < 0 || armorDef > 200) {
        error.textContent = 'La defensa de la armadura debe ser un número entre 0 y 200';
        document.getElementById("armorDef").value = '';
        return false;
    } else {
        return true;
    }
}

document.getElementById('armorEditForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var isValid = true;

    var armorName = document.getElementById('armorName').value;
    if (!validarArmorName(armorName)) {
        isValid = false;
    }

    var armorDef = document.getElementById('armorDef').value;
    if (!validarArmorDef(armorDef)) {
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
});


/* JQUERY VALIDATOR */

$.validator.addMethod("regex", function(value, element, regexpr) {
    return regexpr.test(value);
}, "Por favor, introduce un valor válido.");

$("#armorCreateForm").validate({
    rules: {
        armorImg: {
            required: true,
            extension: "jpg|png|jpeg|webp"
        },
        armorName: {
            required: true,
            minlength: 2,
            regex: /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/
        },
        armorDef: {
            required: true,
            number: true,
            max: 300
        },
        armorInfo: {
            required: true,
            minlength: 10
        }
    },
    messages: {
        armorImg: {
            required: "Por favor, selecciona una imagen",
            extension: "Por favor, selecciona una imagen válida (jpg, png, jpeg)"
        },
        armorName: {
            required: "Por favor, introduce el nombre de la armadura",
            minlength: "El nombre de la armadura debe tener al menos 2 caracteres",
            regex: "La primera letra del nombre de la armadura debe ser mayúscula. El nombre puede contener solo letras, incluyendo tildes, la letra 'ñ' y espacios."
        },
        armorDef: {
            required: "Por favor, introduce la defensa de la armadura",
            number: "Por favor, introduce un número válido para la defensa",
            max: "Por favor, introduce un número menor o igual a 200"
        },
        armorInfo: {
            required: "Por favor, introduce la información de la armadura",
            minlength: "La información de la armadura debe tener al menos 10 caracteres"
        }
    },
    submitHandler: function(form) {
        form.submit();
    }
});
