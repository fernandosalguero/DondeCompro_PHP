$(() => {
    console.log('onload metricas');

    fetch("controller/metrica_comparador.php")
        .then(data => data.text())
        .then(data => {
            console.log(data);

            document.getElementById("metricaC").innerHTML = data


        })

})