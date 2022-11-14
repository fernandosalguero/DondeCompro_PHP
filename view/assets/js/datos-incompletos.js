window.onload = function () {
    $("#dropdown-datos-incompletos").hide();
    getUsuarioDataIncomplete();

}

function getUsuarioDataIncomplete() {
    var datosIncompletos = [];
    fetch("controller/datos-incompletos.php")
        .then(data => data.json())
        .then(data => {
            datosIncompletos.push(data.datos.registro);
            // console.log(datosIncompletos);
            renderDatosIncompletos(datosIncompletos)
        })
        .catch(error => {
            console.log(error);
        })
}

function renderDatosIncompletos(array) {
    $("#datosFaltantes").empty();
    let object = array[0];
    for (const key in object) {
        if (object[key] == null) {
            $("#dropdown-datos-incompletos").show();
            $("#datosFaltantes").append(` <li class="list-group-item text-dark text-capitalize"><i class='fas fa-times' style='color: red !important;'></i>  ${key}</li>`)
        }
    }

}