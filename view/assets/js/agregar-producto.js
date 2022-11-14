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

        // let opcion = confirm("¿Estás seguro que deseas agregar el producto al catalogo?")

        // if (opcion) {

        //     return

        // } else {

        //     return false

        // }

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
                    enombre.innerHTML = "El producto no está en el catálogo."
                    aux_n = 0

                } else {

                    enombre.setAttribute("class", "text-danger")
                    enombre.innerHTML = "El producto ya existe, no podés añadirlo.";
                    aux_n++;
                }

            })

    } else {
        enombre.setAttribute("class", "text-danger")
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