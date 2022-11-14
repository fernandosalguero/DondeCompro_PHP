const generarInitPointMP = (element, importe, suscripcion) => {
    $('#preloaderIndex').show();

    let button = document.getElementById(element);

    let formData = new FormData();
    formData.append('suscripcion', suscripcion);
    formData.append('importe', importe);

    // formData.forEach(f => console.log(f));
    fetch("controller/procesar_pago.php", {
        method: 'POST',
        body: formData
    })
        .then(data => data.text())
        .then(data => {

            let response = JSON.parse(data);
            if (response.status === 'success') {

                // console.log(response);

                button.href = response.init_point;
                button.style.display = "block";

                $('#preloaderIndex').fadeOut(300, function () {
                    console.log('cargado');
                });

                swal("Al darle click en 'Pagar' te redireccionará a un formulario de Mercado Pago, \n\
            no olvides que al acreditar el pago tendrás que darle click al botón 'volver al sitio' \n\
            o dejar que Mercado Pago te redireccione automáticamente \n\
            para que la app procese tu alta de manera automática.")

            } else {

                swal("No se pudo cargar la opción de comprar, recargá la página e intentalo nuevamente")

            }

        })
}