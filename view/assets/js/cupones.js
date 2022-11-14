var codigoUpdate;


function eliminar(codigo) {
    console.log(codigo)

    fetch("controller/eliminar_cupones.php?codigo=" + codigo)
        .then(data => data.text())
        .then(dato => {
            console.log(dato);
            var cupones = JSON.parse(dato);
            $("#cupones").empty();
                cupones.forEach(registro => {
                    console.log(registro)
                    if (registro.acumulable == 1) {
                        acumulable = "SI";
                    } else {
                        acumulable = "NO";
                    }
                    $("#cupones").append(
                        `
                                                                <tr>;
                                                                <td> <p class = 'texto-negro items-cupon'><small> ${registro.codigo}</small></p></td>;
                                                                <td><p class = 'texto-negro items-cupon'> ${registro.suscripcion}</p></td>;
                                                                <td><p class = 'texto-negro items-cupon'> ${registro.descuento}</p></td>;
                                                                <td> <p class = 'texto-negro items-cupon'><small> ${registro.fecha_desde}</small></p></td>;
                                                                <td><p class = 'texto-negro items-cupon'> ${registro.fecha_hasta}</p></td>;
                                                                <td><p class = 'texto-negro items-cupon'> ${acumulable}</p></td>;
                                                                <td>
                                                            <div class='row'>
                                                                <div class='col'>
                                                                    <button class = 'btn btn-sm btn-default items-cupon' id='upd-${registro.ID}'><i class='fas fa-pencil-alt' style='color: blue;'></i></button>
                                                                </div>
                                                                <div class='col'>
                                                                    <button class = 'btn btn-sm btn-default items-cupon' id='del-${registro.ID}'><i class='fas fa-trash' style='color: crimson;'></i></button>
                                                                </div>
                                                            </div>
                                                        </td>;
                                                                </tr>;
        
                        `
                    );
                    updateCupon(registro.ID, registro.codigo);
                    deleteCupon(registro.ID, registro.codigo);

                });
        })




}


function mostrar_modal(codigo) {
    codigoUpdate = codigo;
    console.log(codigoUpdate)

    fetch("controller/ver_cupon.php?codigo=" + codigo)
        .then(data => data.text())
        .then(dato => {
            console.log(dato);
            var cupon = JSON.parse(dato);
            $("#modalUpdate").show();
            $("#codigo").empty();
            $("#suscripcion").empty();
            $("#acumulable").empty();
            $("#descuento").empty();
            $("#fechaDesde").empty();
            $("#fechaHasta").empty();
            $("#descripcion").empty();
            $("#acumulableUpd").prop('checked', false);
            cupon.forEach(registro => {
                console.log(registro)
                if (registro.acumulable == 1) {
                    $("#acumulableUpd").prop('checked', true);
                }
                $("#codigoUpd").val(registro.codigo);
                $("#suscripcionUpd option:selected").text(registro.suscripcion);
                $("#descuentoUpd").val(registro.descuento);
                $("#fechaDesdeUpd").val(registro.fecha_desde);
                $("#fechaHastaUpd").val(registro.fecha_hasta);
                $("#descripcionUpd").val(registro.descripcion);

            });
        })
}



function editar() {

    fetch("controller/actualizar_cupones.php",
        {
            method: 'post',
            headers: { 'Content-Type': 'application/json' },

        }
    ).then(data => data.text())
        .then(dato => {
            console.log(dato);
            $("#v-pills-ver").addClass('show');
            $("#v-pills-ver").addClass('active');
        })
}

function updateCupon(identifier, codigo) {
    $(`#upd-${identifier}`).on("click", () => {
        mostrar_modal(codigo);
    });
}

function deleteCupon(identifier, codigo) {
    $(`#del-${identifier}`).on("click", () => {
        eliminar(codigo);
    });
}

$('#btnCloseModal').click(function (e) {
    console.log(e);
    $('#modalUpdate').hide();

});