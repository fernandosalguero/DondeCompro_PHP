var mostar = true

function mes(){

    let mes = document.getElementById("mes1")

    fetch("controller/generar_subs.php") 
    .then(data => data.text())
    .then(data =>{

        if(parseInt(data) == 1){

            mes.style.display = "block"

            swal("Al darle click en 'Pagar' te redireccionará a un formulario de Mercado Pago, \n\
            no olvides que al acreditar el pago tendrás que darle click al botón 'volver al sitio' \n\
            o dejar que Mercado Pago te redireccione automáticamente \n\
            para que la app procese tu alta de manera automática.")
                  
        }else{

            swal("No se pudo cargar la opción de comprar, recargá la página e intentalo nuevamente")

        }

    })


}

function mes3(){

    let mes = document.getElementById("mes3")

    fetch("controller/generar_subs.php")
    .then(data => data.text())
    .then(data =>{

        if(parseInt(data) == 1){

            mes.style.display = "block";

            swal("Al darle click en 'Pagar' te redireccionará a un formulario de Mercado Pago, \n\
            no olvides que al acreditar el pago tendrás que darle click al botón 'volver al sitio' \n\
            o dejar que Mercado Pago te redireccione automáticamente \n\
            para que la app procese tu alta de manera automática.")
                  
        }else{

            swal("No se pudo cargar la opción de comprar, recargá la página e intentalo nuevamente");

        }

    })


}

function mes6(){

    let mes = document.getElementById("mes6")

    fetch("controller/generar_subs.php")
    .then(data => data.text())
    .then(data =>{

        if(parseInt(data) == 1){

            mes.style.display = "block";

            swal("Al darle click en 'Pagar' te redireccionará a un formulario de Mercado Pago, \n\
            no olvides que al acreditar el pago tendrás que darle click al botón 'volver al sitio' \n\
            o dejar que Mercado Pago te redireccione automáticamente \n\
            para que la app procese tu alta de manera automática.")
                  
        }else{

            swal("No se pudo cargar la opción de comprar, recargá la página e intentalo nuevamente");

        }

    })


}

function mes12(){

    let mes = document.getElementById("mes12")

    fetch("controller/generar_subs.php")
    .then(data => data.text())
    .then(data =>{

        if(parseInt(data) == 1){

            mes.style.display = "block";

            swal("Al darle click en 'Pagar' te redireccionará a un formulario de Mercado Pago, \n\
            no olvides que al acreditar el pago tendrás que darle click al botón 'volver al sitio' \n\
            o dejar que Mercado Pago te redireccione automáticamente \n\
            para que la app procese tu alta de manera automática.")
                  
        }else{

            swal("No se pudo cargar la opción de comprar, recargá la página e intentalo nuevamente");

        }

    })


}

function mostrarRecomendaciones(){

    let row = document.getElementById("resRow")
    let reco = document.getElementById("recomendaciones")
    let brecom = document.getElementById("brecom")
    let brecom2 = document.getElementById("brecom2")

    brecom2.style.display = "block"
    brecom.style.display = "none"
    reco.style.display = "block"

    
}

function ocultarRecomendaciones(){

    let reco = document.getElementById("recomendaciones")
    let brecom = document.getElementById("brecom")
    let brecom2 = document.getElementById("brecom2")

    brecom2.style.display = "none"
    brecom.style.display = "block"
    reco.style.display = "none"


}

function MostrarOcultarRecomendaciones(){

    if(mostar){

        ocultarRecomendaciones()
        mostar = false

    }else{

        mostrarRecomendaciones()
        mostrar = true
    }

}