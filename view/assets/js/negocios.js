var aux_pagina = 1;
var aux2_pagina = 1;

$(() => {

    var entradas = document.getElementById("entradas").value;
    var ordenar = document.getElementById("ordenar").value;

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("negocios").innerHTML = this.responseText;

        }
    }
    xhttp.open("GET", "controller/mostrar_negocios.php?entradas=" + entradas + "&ordenar=" + ordenar + "&pagina=" + aux_pagina, true);
    xhttp.send();

})

function filtrar() {

    aux_pagina = 1;
    aux2_pagina = 1;

    var termino = document.getElementById("buscar").value;
    var entradas = document.getElementById("entradas").value;
    var ordenar = document.getElementById("ordenar").value;


    if (termino == 0) {


        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("negocios").innerHTML = this.responseText;

            }
        }
        xhttp.open("GET", "controller/mostrar_negocios.php?entradas=" + entradas + "&ordenar=" + ordenar + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("negocios").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_negocios.php?termino=" + termino + "&entradas=" + entradas + "&ordenar=" + ordenar + "&pagina=" + aux_pagina, true);
        xhttp.send();

    }

}

function filtrarDarde() {

    var termino = document.getElementById("buscar").value;
    var entradas = document.getElementById("entradas").value;
    var ordenar = document.getElementById("ordenar").value;


    if (termino == 0) {


        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("negocios").innerHTML = this.responseText;

            }
        }
        xhttp.open("GET", "controller/mostrar_negocios.php?entradas=" + entradas + "&ordenar=" + ordenar + "&pagina=" + aux2_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("negocios").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_negocios.php?termino=" + termino + "&entradas=" + entradas + "&ordenar=" + ordenar + "&pagina=" + aux2_pagina, true);
        xhttp.send();

    }


}

function siguiente(ultima) {

    if (aux_pagina == ultima) {

        aux_pagina = 1;

    } else {

        aux_pagina += 1;

    }

    aux2_pagina = aux_pagina;

    var termino = document.getElementById("buscar").value;
    var entradas = document.getElementById("entradas").value;
    var ordenar = document.getElementById("ordenar").value;


    if (termino == 0) {


        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("negocios").innerHTML = this.responseText;

            }
        }
        xhttp.open("GET", "controller/mostrar_negocios.php?entradas=" + entradas + "&ordenar=" + ordenar + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("negocios").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_negocios.php?termino=" + termino + "&entradas=" + entradas + "&ordenar=" + ordenar + "&pagina=" + aux_pagina, true);
        xhttp.send();

    }

}

function anterior(ultima) {

    if (aux_pagina !== 1 && aux_pagina > 1) {

        aux_pagina -= 1;

    } else {

        aux_pagina = ultima;
    }


    aux2_pagina = aux_pagina;

    var termino = document.getElementById("buscar").value;
    var entradas = document.getElementById("entradas").value;
    var ordenar = document.getElementById("ordenar").value;


    if (termino == 0) {


        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("negocios").innerHTML = this.responseText;

            }
        }
        xhttp.open("GET", "controller/mostrar_negocios.php?entradas=" + entradas + "&ordenar=" + ordenar + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("negocios").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_negocios.php?termino=" + termino + "&entradas=" + entradas + "&ordenar=" + ordenar + "&pagina=" + aux_pagina, true);
        xhttp.send();

    }

}


function pagina(pagina) {

    aux_pagina = pagina;
    aux2_pagina = aux_pagina;

    var termino = document.getElementById("buscar").value;
    var entradas = document.getElementById("entradas").value;
    var ordenar = document.getElementById("ordenar").value;


    if (termino == 0) {


        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("negocios").innerHTML = this.responseText;

            }
        }
        xhttp.open("GET", "controller/mostrar_negocios.php?entradas=" + entradas + "&ordenar=" + ordenar + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("negocios").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_negocios.php?termino=" + termino + "&entradas=" + entradas + "&ordenar=" + ordenar + "&pagina=" + aux_pagina, true);
        xhttp.send();

    }

}


function darde(estado, ID) {

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            if (this.responseText == "si") {

                filtrarDarde();

            } else {

                document.getElementById("negocios").innerHTML = "Error inesperado";

            }

        }
    }

    xhttp.open("GET", "controller/darde.php?estado=" + estado + "&ID=" + ID, true);
    xhttp.send();

}

function verInfo(a) {

    fetch("controller/ver_info_negocio.php?id=" + a)

        .then(data => data.text())
        .then(data => {
            console.log(data)
            document.getElementById("comercio").innerHTML = data
            verSubs(a)


        })
}

function verSubs(a) {

    fetch("controller/ver_info_subscripcion.php?id=" + a)

        .then(data => data.text())
        .then(data => {

            document.getElementById("subscripcion").innerHTML = data


        })


}

function regalar(id) {

    let mes = document.getElementById("mes").value

    let confirmacion = confirm("¿estás seguro que quieres regalar esta subscripcion?")

    if (confirmacion) {

        fetch("controller/regalar_subscripcion.php?id=" + id + "&mes=" + mes)
            .then(data => data.text())
            .then(data => {

                if (parseInt(data) == 1) {

                    swal("Regalaste la información al usuario correctamente")
                    verInfo(id)

                } else {

                    swal("Ocurrió un problema, por favor, recarga la página")

                }


            })


    } else {

        return false

    }




}





