var aux_pagina = 1;
var aux2_pagina = 1;

$(() => {
    var entradas = document.getElementById("entradas").value;
    var rubro = document.getElementById("rubro").value;

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("productos").innerHTML = this.responseText

        }
    }
    xhttp.open("GET", "controller/mostrar_productos_super.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
    xhttp.send();

    document.getElementById("productos").innerHTML = `
    <div class='col-md-12 d-flex flex-column align-items-center m-5'>
    <div class="spinner-border text-success" role="status">
                            <span class="sr-only texto-verde">CARGANDO...</span>
                            </div>
                            </div>`
});



function mostrarModalProducto() {
    $("#modalNuevoProducto").show();
}

function cerrarModalProducto() {
    $('#modalNuevoProducto').hide();
}

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
        xhttp.open("GET", "controller/mostrar_productos_super.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_productos_super.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
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
        xhttp.open("GET", "controller/mostrar_productos_super.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux2_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_productos_super.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux2_pagina, true);
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
        xhttp.open("GET", "controller/mostrar_productos_super.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_productos_super.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
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
        xhttp.open("GET", "controller/mostrar_productos_super.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_productos_super.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
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
        xhttp.open("GET", "controller/mostrar_productos_super.php?entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_productos_super.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
        xhttp.send();

    }

}

function eliminar(codigo) {

    fetch("controller/eliminar_producto.php?codigo=" + codigo)
        .then(data => data.text())
        .then(data => {

            if (parseInt(data) == 1) {

                swal("ELIMINASTE EL PRODUCTO CORRECTAMENTE");

                aux_pagina = 1;
                aux2_pagina = 1;

                var termino = document.getElementById("buscar").value;
                var entradas = document.getElementById("entradas").value;
                var rubro = document.getElementById("rubro").value;

                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        document.getElementById("productos").innerHTML = this.responseText;


                    }

                }

                xhttp.open("GET", "controller/buscar_productos_super.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
                xhttp.send();

            } else {

                swal("Ocurrió un error al eliminar el producto")

                aux_pagina = 1;
                aux2_pagina = 1;

                var termino = document.getElementById("buscar").value;
                var entradas = document.getElementById("entradas").value;
                var rubro = document.getElementById("rubro").value;

                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        document.getElementById("productos").innerHTML = this.responseText;


                    }

                }

                xhttp.open("GET", "controller/buscar_productos_super.php?termino=" + termino + "&entradas=" + entradas + "&rubro=" + rubro + "&pagina=" + aux_pagina, true);
                xhttp.send();
            }

        })

    document.getElementById("productos").innerHTML = `
    <div class='col-md-12 d-flex flex-column align-items-center m-5'>
    <div class="spinner-border text-success" role="status">
                            <span class="sr-only texto-verde">CARGANDO...</span>
                            </div>
                            </div>`


}


var aux_n = 0;
var aux_c = 0;



function validarAgregar() {

    let aux = 0
    let nombre = document.getElementById("nombre").value
    let codigo = document.getElementById("codigo").value

    if (nombre == "" || aux_n > 0) {

        document.getElementById("pnombre").innerHTML = "Escribí bien el nombre del producto"
        aux++
    } else {

        document.getElementById("pnombre").innerHTML = ""

    }

    if (codigo == "" || aux_c > 0) {

        document.getElementById("pcodigo").innerHTML = "Escribí bien el codigo del producto"
        aux++

    } else {

        document.getElementById("pcodigo").innerHTML = ""

    }


    if (aux > 0) {

        swal("Verificá que los datos sean correctos para continuar")
        return false

    } else {

        let opcion = confirm("¿Estás seguro que deseas agregar el producto al catalogo?")

        if (opcion) {

            return

        } else {

            return false

        }

    }
}

function consultarNombre() {

    let nombre = document.getElementById("nombre").value
    let enombre = document.getElementById("enombre")

    if (nombre != "" && isNaN(nombre)) {

        fetch("controller/validar_nombre_producto.php?nombre=" + nombre)
            .then(data => data.text())
            .then(data => {

                if (parseInt(data) == 0) {

                    enombre.setAttribute("class", "texto-verde")
                    enombre.innerHTML = "El producto no está en el catalogo."
                    aux_n = 0

                } else {

                    enombre.setAttribute("class", "texto-gris")
                    enombre.innerHTML = "El producto ya se encuentra en el catalogo.";
                    aux_n++;
                }

            })

    } else {
        enombre.setAttribute("class", "texto-gris")
        enombre.innerHTML = "Escribí un nombre correcto.";
        aux_n++;

    }



}

function consultarCodigo() {

    let codigo = document.getElementById("codigo").value
    let ecodigo = document.getElementById("ecodigo")

    if (codigo != "") {

        fetch("controller/validar_codigo_producto.php?codigo=" + codigo)
            .then(data => data.text())
            .then(data => {

                if (parseInt(data) == 0) {

                    ecodigo.setAttribute("class", "texto-verde")
                    ecodigo.innerHTML = "El código no pertenece a ningún producto registrado."
                    aux_c = 0

                } else {

                    ecodigo.setAttribute("class", "texto-gris")
                    ecodigo.innerHTML = "Ya hay un producto con ese código.";
                    aux_c++;

                }

            })

    } else {
        ecodigo.setAttribute("class", "texto-gris")
        ecodigo.innerHTML = "Escribí un código correcto.";
        aux_c++;


    }


}


