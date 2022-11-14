var aux_pagina = 1;
var aux2_pagina = 1;

$(() => {

    console.log('ejecutando');
    
    var entradas = document.getElementById("entradas").value;
    var rubro = document.getElementById("rubro").value;

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("productos").innerHTML = this.responseText

        }
    }
    xhttp.open("GET", "controller/mostrar_productos.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
    xhttp.send();

    document.getElementById("productos").innerHTML = `
    <div class='col-md-12 d-flex flex-column align-items-center m-5'>
    <div class="spinner-border text-success" role="status">
                            <span class="sr-only texto-verde">CARGANDO...</span>
                            </div>
                            </div>`
});


function filtrar() {

    aux_pagina = 1;
    aux2_pagina = 1;

    var termino = document.getElementById("buscar").value;
    var entradas = document.getElementById("entradas").value;
    var rubro = document.getElementById("rubro").value;


    if (termino == 0) {


        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;

            }
        }
        xhttp.open("GET", "controller/mostrar_productos.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_productos.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();

    }

}

function filtrarCambiar() {


    var termino = document.getElementById("buscar").value;
    var entradas = document.getElementById("entradas").value;
    var rubro = document.getElementById("rubro").value;


    if (termino == 0) {


        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;

            }
        }
        xhttp.open("GET", "controller/mostrar_productos.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux2_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_productos.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux2_pagina, true);
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
    var rubro = document.getElementById("rubro").value;


    if (termino == 0) {


        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;

            }
        }
        xhttp.open("GET", "controller/mostrar_productos.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_productos.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
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
    var rubro = document.getElementById("rubro").value;


    if (termino == 0) {


        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;

            }
        }
        xhttp.open("GET", "controller/mostrar_productos.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_productos.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();

    }

}

function pagina(pagina) {


    aux_pagina = pagina;
    aux2_pagina = aux_pagina;

    var termino = document.getElementById("buscar").value;
    var entradas = document.getElementById("entradas").value;
    var rubro = document.getElementById("rubro").value;


    if (termino == 0) {


        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;

            }
        }
        xhttp.open("GET", "controller/mostrar_productos.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_productos.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();

    }

}

function cambiar(codigo) {

    id = codigo.toString();

    precio = document.getElementById(id).value;

    if (precio == "" || precio == null) {

        swal("¡No has hecho ningún cambio!");
        precio = document.getElementById(id).placeholder;
        return;

    } else if (isNaN(precio)) {

        swal("¡Introduce un dato numérico!")
        return;

    }


    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            if (this.responseText == "si") {

                filtrarCambiar();

            } else {

                return;

            }

        }
    }
    xhttp.open("GET", "controller/cambiar_precio.php?codigo=" + codigo + "&precio=" + precio, true);
    xhttp.send();


}

function validarPorcentaje() {

    // let por = document.getElementById("porcentaje").value;

    // if (por <= 0 || isNaN(por)) {

    //     swal("TIENE QUE SER UN NÚMERO Y MAYOR QUE 0")
    //     return false

    // } else {

    //     let opcion = confirm("¿Estás seguro que deseas aumentar todos los precios ese porcentaje? Recuerda que es una acción irreversible.")

    //     if (opcion) {

    //         return

    //     } else {

    //         return false

    //     }

    // }

}





