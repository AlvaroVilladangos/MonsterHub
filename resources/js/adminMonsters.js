/* Funcion Ajax para rellenar formulario de edicion */


$(document).ready(function() {
    $('.btn-editar').click(function() {
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
                $('#monsterEditModal .modal-body select[name="monsterElement"]').val(
                    data
                    .element);
                $('#monsterEditModal .modal-body select[name="monsterWeakness"]').val(
                    data.weakness);
                $('#monsterEditModal .modal-body textarea[name="monsterPhysiology"]')
                    .val(data.physiology);
                $('#monsterEditModal .modal-body textarea[name="monsterAbilities"]')
                    .val(data.abilities);

                $('#monsterEditForm').attr('action', '/monster/' + monsterId +
                    '/update');
            }
        });

        $('#monsterEditModal').modal('show');
    });
});



/* JQEURY VALIDATOR */


$(document).ready(function() {
    $("#monsterCreateForm").validate({
        rules: {
            monsterImg: {
                required: true,
                extension: "jpg|png|jpeg|webp"
            },
            monsterName: {
                required: true,
                minlength: 2,
                regex: /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/
            },
            monsterElement: {
                required: true
            },
            monsterWeakness: {
                required: true
            },
            monsterPhysiology: {
                required: true,
                minlength: 10
            },
            monsterAbilities: {
                required: true,
                minlength: 10
            }
        },
        messages: {
            monsterImg: {
                required: "Por favor, selecciona una imagen",
                extension: "Por favor, selecciona una imagen válida (jpg, png, jpeg)"
            },
            monsterName: {
                required: "Por favor, introduce el nombre del monstruo",
                minlength: "El nombre del monstruo debe tener al menos 2 caracteres",
                regex: "La primera letra del nombre del monstruo debe ser mayúscula. El nombre puede contener solo letras, incluyendo tildes, la letra 'ñ' y espacios." // Agregamos el mensaje de error del regex aquí
            },
            monsterElement: {
                required: "Por favor, selecciona un elemento"
            },
            monsterWeakness: {
                required: "Por favor, selecciona una debilidad"
            },
            monsterPhysiology: {
                required: "Por favor, introduce la fisiología del monstruo",
                minlength: "La fisiología del monstruo debe tener al menos 10 caracteres"
            },
            monsterAbilities: {
                required: "Por favor, introduce las habilidades del monstruo",
                minlength: "Las habilidades del monstruo deben tener al menos 10 caracteres"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $.validator.addMethod("regex", function(value, element, regexpr) {
        return regexpr.test(value);
    }, "Por favor, introduce un valor válido, que empiece por mayúscula");
});


/* VALIDADOR PROPIO PARA EDICION DE MOSNTRUOS */


function validarMonsterName(monsterName) {
    var regexCaracteres = /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/;
    var error = document.getElementById("errorMonsterName");

    if (!regexCaracteres.test(monsterName)) {
        error.textContent = "La primera letra del nombre del monstruo debe ser mayúscula. El nombre puede contener solo letras.";
        document.getElementById("monsterName").value = '';
        return false;
    }
    if (monsterName.length > 20) {
        error.textContent = "El nombre del monstruo no puede tener más de 20 caracteres.";
        document.getElementById("monsterName").value = '';
        return false;
    }
    if (monsterName.length < 4) {
        error.textContent = "El nombre del monstruo no puede tener menos de 4 letras.";
        document.getElementById("monsterName").value = '';
        return false;
    } else {
        error.textContent = "";
        return true;
    }
}

function validarMonsterPhysiology(monsterPhysiology) {
    var error = document.getElementById("errorMonsterPhysiology");

    if (monsterPhysiology.length < 10) {
        error.textContent = 'La fisiología del monstruo debe tener al menos 10 caracteres';
        document.getElementById("monsterPhysiology").value = '';
        return false;
    } else {
        return true;
    }
}

function validarMonsterAbilities(monsterAbilities) {
    var error = document.getElementById("errorMonsterAbilities");

    if (monsterAbilities.length < 10) {
        error.textContent = 'Las habilidades del monstruo deben tener al menos 10 caracteres';
        document.getElementById("monsterAbilities").value = '';
        return false;
    } else {
        return true;
    }
}

document.getElementById('monsterEditForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var isValid = true;

    var monsterName = document.getElementById('monsterName').value;
    if (!validarMonsterName(monsterName)) {
        isValid = false;
    }

    var monsterPhysiology = document.getElementById('monsterPhysiology').value;
    if (!validarMonsterPhysiology(monsterPhysiology)) {
        isValid = false;
    }

    var monsterAbilities = document.getElementById('monsterAbilities').value;
    if (!validarMonsterAbilities(monsterAbilities)) {
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
});