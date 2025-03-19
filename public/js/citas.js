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
                    $('#menu_carga').show();
                }
            }, false);
        });
    },false);
})();

function diaSemana() {
    //$('#fecha').on('change', onSelectestadoChange);
    console.log("lelgo");
}

function onSelectestadoChange(){
    //Al detectar el cambio en el select toma el valor del select con el id "estado"
    var municipio_id = $(this).val();
    alert(municipio_id);

    /*
    $('#municipio_solicitante').prop('disabled', false);
    //Se ejecuta la consulta AJAX para buscar con el municipio_id
    $.get('../api/munSolicitante/'+municipio_id, function (data){
        var html_select = '<option value="">--Seleccione un estado --</option>';        
        for(var i=0; i<data.length; ++i)
            html_select += '<option value= "'+data[i].id+'">'+data[i].nombre+'</option>';
            $('#municipio_solicitante').html(html_select);
    });
    */
}