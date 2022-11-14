//--variables auxiliares para las funciones fNombre y fCorreo respectivamente--//
//--------------//
var aux_n = 3;
var aux_c = 3;
//--------------//

$(() => {
    cargarProvincia();
});


/* Esta función se ejecuta cuando el usuario cambia algo en el campo de texto "nombre"
Y evalua si el usuario ha escrito el nombre correctamente, es decir, sin comenzar con
un numero, que no tenga más de 30 caracteres, que no esté vació y que el nombre de usuario no se hay registrado previamente
si no es así establece que el valor de la variable auxiliar aux_n  es 0*/
//--------------------//
function fNombre() {

    let nombre = document.getElementById("nombre").value;

    minus = /[a-z]/;
    mayus = /[A-Z]/;

    nombre_v = nombre.split("");

    if ((minus.test(nombre_v[0]) == 0 && mayus.test(nombre_v[0]) == 0) || nombre.length > 30) {

        document.getElementById("enombre").innerHTML = "No puede iniciar con un número <br> \n\
                                                     o  caracter especial <br> \n\
                                                      y tampoco de tener más de 30 caracteres";
        aux_n = 0;


    } else if (nombre === "") {

        document.getElementById("enombre").innerHTML = "";
        aux_n = 2;

    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                var resultado = parseInt(this.responseText);

                if (resultado == 0) {

                    document.getElementById("enombre").innerHTML = "El nombre de usuario está disponible";
                    aux_n = 1;

                } else {

                    if (nombre === document.getElementById("nombre").placeholder) {

                        document.getElementById("enombre").innerHTML = "";
                        aux_n = 2;
                    } else {

                        document.getElementById("enombre").innerHTML = "El nombre de usuario ya se encuentra en uso <br> intenta con otro";
                        aux_n = 0;

                    }


                }
            }
        }
        xhttp.open("GET", "controller/consultar_usuario_correo.php?nombre=" + nombre, true);
        xhttp.send();

    }

}
//--------------------//


/* Esta función se ejecuta cuando el usuario cambia algo en el campo de texto "correo o email"
Y evalua si el usuario ha escrito el correo correctamente, es decir, que esté en un formato de correo válido y
que el correo no se haya registrado previamente si no es así establece que el valor de la variable auxiliar
aux_c  es 0*/
//--------------------//
function fCorreo() {

    var correo = document.getElementById("correo").value;

    expresion_c = /\w+@+\w+\.+[a-z]/;

    if (correo === "") {

        document.getElementById("ecorreo").innerHTML = "";
        aux_c = 2;

    } else if (expresion_c.test(correo) === false) {

        document.getElementById("ecorreo").innerHTML = "Debe tener un formato de correo valido";
        aux_c = 0;

    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                var resultado = parseInt(this.responseText);

                if (resultado == 0) {


                    document.getElementById("ecorreo").innerHTML = "La dirección de correo es válida";
                    aux_c = 1;

                } else {

                    if (correo == document.getElementById("correo").placeholder) {

                        document.getElementById("ecorreo").innerHTML = "";
                        aux_c = 2;

                    } else {

                        document.getElementById("ecorreo").innerHTML = "El correo ya esta en uso";
                        aux_c = 0;

                    }


                }
            }
        }
        xhttp.open("GET", "controller/consultar_usuario_correo.php?correo=" + correo, true);
        xhttp.send();

    }
}
//--------------------//


function cambiarDatos() {

    if (document.getElementById("clave").value === "") {

        swal("Escribe tu contraseña para verificar los cambios");
        return false;

    } if (aux_n === 3 && aux_c === 3) {

        swal("No has hecho ningún cambio");
        return false;

    } else if (aux_n == 2 && aux_c == 2) {

        swal("No has hecho ningun cambio");
        return false;

    } else if (aux_n === 0 || aux_c === 0) {

        swal('DATOS INCORRECTOS', 'Comprueba los datos e intetalo nuevamente.', 'error');
        return false;

    } else if ((aux_n == 1 && aux_c !== 0) || (aux_c == 1 && aux_n !== 0)) {

        return;

    }

}


/* Se hace una consulta a la página datos.gob para extraer las provincias y mostrarlas 
  en el select y a funcion de lo que se selecione el select se cargarán los municipios*/
//-------------------------------//
function cargarProvincia() {

    let provincias = document.querySelector("#provincias");
    var provinciasOrdenadas = [];

    //fetch('https://apis.datos.gob.ar/georef/api/provincias?campos=id,nombre')
    fetch('https://apis.datos.gob.ar/georef/api/provincias')
        .then(datos => datos.json())
        .then(datos => {

            let aux;

            datos.provincias.forEach(e => {
                provinciasOrdenadas.push(e.nombre)
            });

            provinciasOrdenadas.sort().forEach(index => {
                aux += `<option value = '${index}'> ${index} </option>`
            });

            provincias.innerHTML += aux

        })

        .catch(error => {

            provincias.innerHTML += error


        })

}
//------------------------------//

/*Carga los municipios a funcion de la provincia que se eligió */
//-----------------------------//
function cargarMunicipios() {


    document.querySelector("#direccion").style.display = "block";
    let provincia = document.querySelector("#provincias").value
    if (provincia != "Ciudad Autónoma de Buenos Aires" &&
        provincia != "Entre Ríos" &&
        provincia != "Santa Cruz" &&
        provincia != "Santiago del Estero") {
        document.querySelector("#mMunicipios").style.display = "block";
        let municipios = document.querySelector("#municipios")
        let url = `https://apis.datos.gob.ar/georef/api/municipios?provincia=${provincia}&campos=id,nombre&max=100`

        fetch(url)
            .then(datos => datos.json())
            .then(datos => {

                let aux
                for (let i in datos.municipios) {

                    aux += `
            <option> ${datos.municipios[i].nombre} </option>
            `
                }

                municipios.innerHTML = aux

            })
            .catch(error => {

                municipios.innerHTML = error
            })


    } else {

        document.querySelector("#mMunicipios").style.display = "none";

    }



}
//-----------------------------//


/*Hace visible el botón guardar cambios */
//---------------------------//
function mostrarGuardar() {

    let dir = document.getElementById("dir").value

    document.getElementById("guardarUbicacion").style.display = "block";


    if (dir == "") {

        document.getElementById("guardarUbicacion").style.display = "none";

    } else {
        document.getElementById("guardarUbicacion").style.display = "block";
    }
}
//---------------------------//

function infoNegocio() {

    let numeroTelefono = document.getElementById("telefono").value
    if (numeroTelefono == "" || isNaN(numeroTelefono)) {

        swal("El número de teléfono es obligatorio para enviar estos datos y no debe tener ningún caracter que no sea un número")
        return false

    } else {

        return

    }



}

