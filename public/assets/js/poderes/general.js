(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false ){
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                } else {
                    $('#crear_poder').show();
                    //alert("alert");
                    //$('#agregarseguimiento').modal('hide');
                    loading();
                }
            }, false);
        });
    }, false);
})();

function nuevo_poder() {
    $('#nuevo_poder').show();
}

function editar_poder() {
    $('#nuevo_poder').show();
}