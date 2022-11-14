<?php

/*Este archivo se carga al inicio y muestra letreros de exito dependiendo el caso*/

if (isset($_GET["success"])) {

    if ($_GET["success"] == 10) {

        echo "<script>

        window.onload=function() {
            
            swal('CONTRASEÑA ACTUALIZADA', 'Tu contraseña se cambió correctamente', 'success');
        }
        </script>";
    } elseif ($_GET["success"] == 15) {

        echo "<script>

        window.onload=function() {
            
            swal('HAS DADO DE ALTA  AL NEGOCIO CORRECTAMENTE', 'Ahora el negocio podrá acceder a su panel de administración.', 'success');
        }
        </script>";
    } elseif ($_GET["success"] == 20) {

        echo "<script>

        window.onload=function() {
            
            swal('HAS ACTUALIZADO LA INFORMACIÓN CORRECTAMENTE', '', 'success');
        }
        </script>";
    } else if ($_GET["success"] == 25) {

        echo "<script>

        window.onload=function() {
            
            swal('CONTRASEÑA ACTUALIZADA', 'Tu contraseña se cambió correctamente, ya podés iniciar sesión', 'success');
        }
        </script>";
    } else if ($_GET["success"] == 123) {

        echo "<script>

        window.onload=function() {
            
            swal('AUMENTASTE LOS PRECIOS CORRECTAMENTE', 'Los precios se actualizaron correctamente', 'success');
        }
        </script>";
    } else if ($_GET["success"] == 310) {

        echo "<script>

        window.onload=function() {
            
            swal('¡SUBSCRIPCIÓN PAGADA!', 'Ahora podés anunciar tus promociones, los usuarios cercanos a tu ubicación las verán, no te olvidés de mantener tu información de ubicación actualizada', 'success');
        }
        </script>";
    } else if ($_GET["success"] == 55) {

        echo "<script>

        window.onload=function() {
            
            swal('¡AGREGASTE EL PRODUCTO CORRECTAMENTE!', 'Los comercios ya podrán ver el producto en su catalogo', 'success');
        }
        </script>";
    } else if ($_GET["success"] == 60) {

        echo "<script>

        window.onload=function() {
            
            swal('¡AGREGASTE UN NUEVO CUPÓN CORRECTAMENTE!', 'Los comercios ya podrán utilizarlo', 'success');
        }
        </script>";
    } else if ($_GET["success"] == 66) {

        echo "<script>

        window.onload=function() {

            var btnGen = document.getElementsByClassName('gen-cupones');
            btnGen[0].classList.remove('active');

            var btnVer = document.getElementsByClassName('ver-cupones');
            btnVer[0].classList.add('active');

            var menuCrear = document.getElementById('v-pills-cupones');
            menuCrear.classList.remove('show');
            menuCrear.classList.remove('active');

            var menuVer = document.getElementById('v-pills-ver');
            menuVer.classList.add('show');
            menuVer.classList.add('active');

            btnGen[0].addEventListener('click', function(e){

                var menuVer = document.getElementById('v-pills-ver');
                menuVer.classList.remove('show');
                menuVer.classList.remove('active');

                var menuCrear = document.getElementById('v-pills-cupones');
                menuCrear.classList.add('show');
                menuCrear.classList.add('active');

                });

             
        }
        </script>";
    }
}
