/*  Ajax para rellenar formulario edicion armas */

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
                $('#weaponEditModal .modal-body select[name="weaponMonster_id"]').val(
                    data.monster_id);

                $('#weaponUpadteForm').attr('action', '/weapon/' + weaponId +
                    '/update');
            }
        });
        $('#weaponEditModal').modal('show');
    });
});


/* JQEURY validator de creacion armas */


$.validator.addMethod("regex", function(value, element, regexpr) {
    return regexpr.test(value);
}, "Por favor, introduce un valor válido.");

$("#weaponCreateForm").validate({
    rules: {
        weaponImg: {
            required: true,
            extension: "jpg|png|jpeg|webp"
        },
        weaponName: {
            required: true,
            minlength: 2,
            regex: /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/
        },
        weaponAtk: {
            required: true,
            number: true,
            min:100,
            max: 1000
        },
        weaponElement: {
            required: true
        },
        weaponCrit: {
            required: true,
            number: true,
            max: 100
        },
        weaponInfo: {
            required: true,
            minlength: 10
        }
    },
    messages: {
        weaponImg: {
            required: "Por favor, selecciona una imagen",
            extension: "Por favor, selecciona una imagen válida (jpg, png, jpeg)"
        },
        weaponName: {
            required: "Por favor, introduce el nombre de la arma",
            minlength: "El nombre de la arma debe tener al menos 2 caracteres",
            regex: "La primera letra del nombre de la arma debe ser mayúscula. El nombre puede contener solo letras, incluyendo tildes, la letra 'ñ' y espacios."
        },
        weaponAtk: {
            required: "Por favor, introduce el ataque de la arma",
            number: "Por favor, introduce un número válido para el ataque",
            min: "Por favor, introduce un número mayor o igual a 100",
            max: "Por favor, introduce un número menor o igual a 1000"
        },
        weaponElement: {
            required: "Por favor, selecciona un elemento"
        },
        weaponCrit: {
            required: "Por favor, introduce el crítico de la arma",
            number: "Por favor, introduce un número válido para el crítico",
            max: "Por favor, introduce un número menor o igual a 100"
        },
        weaponInfo: {
            required: "Por favor, introduce la información de la arma",
            minlength: "La información de la arma debe tener al menos 10 caracteres"
        }
    },
    submitHandler: function(form) {
        form.submit();
    }
});

/*alidador para edicion de armas */

function validarWeaponName(weaponName) {
    var regexCaracteres = /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/;
    var error = document.getElementById("errorWeaponName");

    if (!regexCaracteres.test(weaponName)) {
        error.textContent =
            "La primera letra del nombre del arma debe ser mayúscula. El nombre puede contener solo letras.";
        document.getElementById("weaponName").value = '';
        return false;
    }
    if (weaponName.length > 20) {
        error.textContent = "El nombre del arma no puede tener más de 20 caracteres.";
        document.getElementById("weaponName").value = '';
        return false;
    }
    if (weaponName.length < 4) {
        error.textContent = "El nombre del arma no puede tener menos de 4 letras.";
        document.getElementById("weaponName").value = '';
        return false;
    } else {
        error.textContent = "";
        return true;
    }
}

function validarWeaponAtk(weaponAtk) {
    var error = document.getElementById("errorWeaponAtk");

    if (isNaN(weaponAtk) || weaponAtk < 100|| weaponAtk > 1000) {
        error.textContent = 'El ataque del arma debe ser un número entre 100 y 1000';
        document.getElementById("weaponAtk").value = '';
        return false;
    } else {
        return true;
    }
}

function validarWeaponCrit(weaponCrit) {
    var error = document.getElementById("errorWeaponCrit");

    if (isNaN(weaponCrit) || weaponCrit < 0 || weaponCrit > 100) {
        error.textContent = 'El crítico del arma debe ser un número entre 0 y 100';
        document.getElementById("weaponCrit").value = '';
        return false;
    } else {
        return true;
    }
}

document.getElementById('weaponUpadteForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var isValid = true;

    var weaponName = document.getElementById('weaponName').value;
    if (!validarWeaponName(weaponName)) {
        isValid = false;
    }

    var weaponAtk = document.getElementById('weaponAtk').value;
    if (!validarWeaponAtk(weaponAtk)) {
        isValid = false;
    }

    var weaponCrit = document.getElementById('weaponCrit').value;
    if (!validarWeaponCrit(weaponCrit)) {
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
});