<?php

/*este archivo es cargado al iniciio y muestra mensajes de error dependiendo el caso*/

if (isset($_GET["conerror"])) {

    if ($_GET["conerror"] == 30) {

        echo "<script>

            window.onload=function() {
                
                swal('CONTRASEÑA INCORRECTA', 'Volvé a escribir tu nombre de usuario (o email) y contraseña', 'error');
            }
            </script>";
    } else if ($_GET["conerror"] == 35) {

        echo "<script>

            window.onload=function() {
                
                swal('CONTRASEÑA INCORRECTA', 'No pudimos realizar los cambios, verificá tu contraseña.', 'error');
            }
            </script>";
    } else if ($_GET["conerror"] == 40) {

        echo "<script>

            window.onload=function() {
                
                swal('NO PUDIMOS REALIZAR LA PETICIÓN', 'Intentá más tarde.', 'error');
            }
            </script>";
    } else if ($_GET["conerror"] == 45) {

        echo "<script>

            window.onload=function() {
                
                swal('ERROR AL SUBIR LA IMAGEN', 'No pudimos subir la imagen, comprobá que hayas seleccionado una imagen, que tenga el formato correcto y que pese menos 2MB', 'error');
            }
            </script>";
    } else if ($_GET["conerror"] == 3312) {

        echo "<script>

            window.onload=function() {
                
                swal('ERROR AL VERIFICAR EL EMAIL', 'Escribí el email asociado a la cuenta de la cual querés establecer una nueva contraseña', 'error');
            }
            </script>";
    } else if ($_GET["conerror"] == 96) {

        echo "<script>

            window.onload=function() {
                
                swal('ERROR AL AGREGAR PRODUCTO', 'No pudimos agregar el producto, verificá que la categoria, el nombre y el código sean validos', 'error');
            }
            </script>";
    } else if ($_GET["conerror"] == 63) {

        echo "<script>

            window.onload=function() {
                
                swal('ERROR AL AUMENTAR PRECIOS POR PORCENTAJE', 'No pudimos aumentar los precios por porcentaje, verificá que el valor no sea menor o igual a 0 y que sea un número', 'error');
            }
            </script>";
    } else if ($_GET["conerror"] == 105) {

        echo "<script>

            window.onload=function() {
                
                swal('SUBSCRIPCIÓN VENCIDA', 'Tu subscripción a nuestro sistema de publicidad venció, actualizála para seguir promocionando tu negocio y productos.', 'error');
            }
            </script>";
    } else if ($_GET["conerror"] == 100) {

        echo "<script>

            window.onload=function() {
                
                swal('¡EL PAGO FUE RECHAZADO!', 'Tu subscripción no fue dada de alta porque el pago no se acreditó correctamente', 'error');
            }
            </script>";
    } else if ($_GET["conerror"] == 110) {

        echo "<script>

            window.onload=function() {
                
                swal('¡EL PAGO QUEDÓ PENDIENTE!', 'Tu subscripción no fué dada de alta porque el pago quedó pendiente, cancelá el pago y llená el formulario de pago otra vez', 'error');
            }
            </script>";
    } else if ($_GET["conerror"] == 60) {

        echo "<script>

        window.onload=function() {
            
            swal('¡HA OCURRIDO UN ERROR!', 'Tu cupón no se pudo procesar, verificá tus datos o la conexión a internet', 'error');
        }
        </script>";
    }
}
