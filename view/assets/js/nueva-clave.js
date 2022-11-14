/*Esta función se ejecuta cuando el usuario cambia algo en el campo "establecer contraseña"
  y verifica si el usuario ha escrito la contraseña correctamente, es decir, verifca
  si el campo no está vacío y si tiene más de 5 caracteres si no es así retorna 0 */
//------------------//
function fClave(){

    var clave = document.getElementById("clave").value;

    if(clave === ""){

        document.getElementById("eclave").innerHTML = "Este campo no puede estar vacío";
        return 0;

    }else if(clave.length <= 5){

        document.getElementById("eclave").innerHTML = "La contraseña debe tener más de 5 caracteres";
        return 0;

    }else{

        document.getElementById("eclave").innerHTML = "";

    }
}
//------------------//


/*Esta función se ejecuta cuando el usuario ha cambiado algo en el campo "repita la contraseña"
y evalua si es exactamente igual a lo que digitó en el campo "establecer contraseñaa" 
si no es así retorna  0*/
//------------------//
function frClave(){

    var clave = document.getElementById("clave").value;
    var rclave = document.getElementById("rclave").value;

    if(clave != rclave){

        document.getElementById("erclave").innerHTML = "Las contraseñas no coinciden";
        return 0;

    }else{

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
function validar(){



    if(fClave() == 0 || frClave() == 0){

            swal("Verifica que la contraseña tenga más de 6 caracteres y que coinicida con el campo de 'Repite la contraseña'");
            return false;

     }
    
        return;



}
//-----------------------//
