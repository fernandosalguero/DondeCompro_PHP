window.onload = ()=>{

    let infoNegocio = document.getElementById("infoNegocio")

    fetch("controller/inicio_info_negocio.php")

    .then(data => data.text())
    .then(data => {

        if(parseInt(data) == 0){

            infoNegocio.innerHTML += `<p> Ha ocurrido un error al cargar la información, recargar la página <p>`

        }else{


            infoNegocio.innerHTML += data

        }


    })

    .catch(error => {

        infoNegocio.innerHTML += error


    })


}