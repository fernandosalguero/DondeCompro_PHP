//---variable auxiliar para la función validarNombre---//
var auxlog;
//-----------------------------------------------------//


//--variables auxiliares para las funciones fNombre y fCorreo respectivamente--//
//--------------//
var aux_n = 0;
var aux_c = 0;
//--------------//

window.onload = function() {

    cargarProvincia()


}


/* Esta función se ejecuta cuando el usuario cambia algo en el campo de texto "nombre"
 Y evalua si el usuario ha escrito el nombre correctamente, es decir, sin comenzar con
 un numero, que no tenga más de 30 caracteres, que no esté vació y que el nombre de usuario no se haya registrado previamente
 si no es así establece que el valor de la variable auxiliar aux_n  es 0*/
//--------------------//
function fNombre() {

    let nombre = document.getElementById("nombre").value;

    minus = /[a-z]/;
    mayus = /[A-Z]/;

    nombre_v = nombre.split("");

    if ((minus.test(nombre_v[0]) == 0 && mayus.test(nombre_v[0]) == 0) || nombre === "" || nombre.length > 30) {

        document.getElementById("enombre").innerHTML = "Este campo no puede estar vacío, no puede iniciar con un número o caracter especial \n\
                                                        y tampoco debe tener más de 30 caracteres";
        return 0;


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                var resultado = parseInt(this.responseText);

                if (resultado == 0) {

                    document.getElementById("enombre").innerHTML = "El nombre de usuario está disponible";
                    aux_n = 1;

                } else {

                    document.getElementById("enombre").innerHTML = "Ese nombre de usuario ya está en uso. Probá con otro";
                    aux_n = 0;

                }
            }
        }
        xhttp.open("GET", "../controller/consultar_usuario_correo.php?nombre=" + nombre, true);
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

    if (correo === "" || expresion_c.test(correo) === false) {

        document.getElementById("ecorreo").innerHTML = "Este campo no puede estar vacío y debe tener un formato de correo";
        return 0;

    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                var resultado = parseInt(this.responseText);

                if (resultado == 0) {

                    document.getElementById("ecorreo").innerHTML = "La dirección de correo es válida";
                    aux_c = 1;

                } else {

                    document.getElementById("ecorreo").innerHTML = "La dirección de correo escrita ya está en uso. Probá con otra";
                    aux_c = 0;
                }
            }
        }
        xhttp.open("GET", "../controller/consultar_usuario_correo.php?correo=" + correo, true);
        xhttp.send();

    }
}
//--------------------//


/*Esta función se ejecuta cuando el usuario cambia algo en el campo "establecer contraseña"
  y verifica si el usuario ha escrito la contraseña correctamente, es decir, verifca
  si el campo no está vacío y si tiene más de 5 caracteres si no es así retorna 0 */
//------------------//
function fClave() {

    var clave = document.getElementById("clave").value;

    if (clave === "") {

        document.getElementById("eclave").innerHTML = "Este campo no puede estar vacío";
        return 0;

    } else if (clave.length <= 5) {

        document.getElementById("eclave").innerHTML = "La contraseña debe tener más de 5 caracteres";
        return 0;

    } else {

        document.getElementById("eclave").innerHTML = "";

    }
}
//------------------//


/*Esta función se ejecuta cuando el usuario ha cambiado algo en el campo "repita la contraseña"
y evalua si es exactamente igual a lo que digitó en el campo "establecer contraseñaa" 
si no es así retorna  0*/
//------------------//
function frClave() {

    var clave = document.getElementById("clave").value;
    var rclave = document.getElementById("rclave").value;

    if (clave != rclave) {

        document.getElementById("erclave").innerHTML = "Las contraseñas no coinciden";
        return 0;

    } else {

        document.getElementById("erclave").innerHTML = "";

    }

}
//------------------//


/*Esta función se ejecuta cuando el usuario presiona el botón "Registrarse"
y evalua en primera instancia si el usuario ha marcado la casilla de términos y condiciones
sino es así, no envía el formulario
y luego evalua todas las funciones de verificación (fNombre, fCorreo, fClave, frClave) 
si han retornado 0 y en caso de fNombre y fCorreo, han modificado
sus correspondientes variables auxiliares aux_n y aux_c respectivamente
y son iguales a 0 es decir, si hay "errores" en los campos, entonces no envía el formulario
si no hay ningún error, entonces lo envía, es decir retorna "True"*/
//-----------------------//
function validar() {

    var clicencia = document.getElementById("licencia").checked;

    if (!clicencia) {

        swal("Para registrarte debes estar de acuerdo con nuestros términos de uso.");
        return false;

    } else {

        if (aux_n == 0 || aux_c == 0 || fClave() == 0 || frClave() == 0) {

            swal("Verifica los datos para poder continuar.");
            return false;

        }

        return;

    }

}
//-----------------------//




/*Esta funcion se ejecuta cuando el usuario cambia algo en el campo de texto nombre o email en 
en login de la pantalla de inicio y verifica si existe un usuario con el nombre o el email
que el usuario ingreso*/
function validarNombre() {

    var valor = document.getElementById("nomail").value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            var resultado = parseInt(this.responseText);

            if (resultado == 0) {

                document.getElementById("texlogin").innerHTML = "Nombre de usuario o correo incorrecto.";
                auxlog = 1;

            } else {

                document.getElementById("texlogin").innerHTML = "";
                auxlog = 0;

            }
        }
    }
    xhttp.open("GET", "controller/consultar_usuario_correo.php?valor=" + valor, true);
    xhttp.send();

}
//--------------------------//

/*Esta funcion se ejecuta cuando el usuario cambia algo en el campo de texto nombre o email en 
en login de la pantalla de inicio y verifica si existe un usuario con el nombre o el email
que el usuario ingreso*/
function validarNombreLogin() {

    var valor = document.getElementById("nomail").value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            var resultado = parseInt(this.responseText);

            if (resultado == 0) {

                document.getElementById("texlogin").innerHTML = "Nombre de usuario o correo incorrecto.";
                auxlog = 1;

            } else {

                document.getElementById("texlogin").innerHTML = "";
                auxlog = 0;

            }
        }
    }
    xhttp.open("GET", "controller/consultar_usuario_login.php?valor=" + valor, true);
    xhttp.send();

}
//--------------------------//


/*Esta función se ejecuta cuando el usuario presiona el botón de ingresar en el login
de la pantalla de inicio y verifica si la variable auxiliar axulog está en 1 y si lo está,
es decir, si el nombre de usuario o email es incorrecto, entonces retorna false 
para que el formulario no se envíe hasta que la variable auxlog sea igual a 0 (diferente de 1)
y cuando es así, es decir, cuando el nombre de usuario o email es correcto, entonces 
procede a enviar el formulario  */
function validarLogin() {

    if (auxlog === 1) {

        swal("Nombre de usuario incorrecto.")
        return false;

    }


}

