window.onload = ()=>{

    let negocios = document.getElementById("negocios")

    fetch("controller/cargar_negocios_publicidad.php")
    .then(data => data.text())
    .then(data => {

        if(parseInt(data) != 0){

            negocios.innerHTML += data

        }else{

            negocios.innerHTML += `
            <div class = "col-md-12 m-3">
            <p class = "text-center"> Todavía no hay negocios cerca tuyo ¡Recomendá DóndeCompro? a los comercios cercanos a vos!</p>
            </div>
            `
            
        }


    })




}