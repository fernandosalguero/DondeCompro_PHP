// window.onload = function () {
//     console.log("ubicacion.js andando");
//     cargarProvincia();
// }

$(() => {
    console.log("ubicacion.js andando");
    cargarProvincia();
});

var muniLat = '';
var muniLon = '';

function cargarProvincia() {

    let provincias = document.querySelector("#provincias-registro");
    var provinciasOrdenadas = [];

    fetch('https://apis.datos.gob.ar/georef/api/provincias?campos=id,nombre')

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

function cargarMunicipios() {

    console.log('cargando municipios');

    let provincia = document.querySelector("#provincias-registro").value;
    let municipios = document.querySelector("#municipios-registro");
    let localidades = document.querySelector("#localidades-registro");

    if (provincia != "seleccionar") {
        if (provincia != "Ciudad Autónoma de Buenos Aires") {
            //muestra dtos y localidades
            document.querySelector("#mMunicipios-registro").style.display = "block";
            document.querySelector("#lLocalidades-registro").style.display = "none";

            let url_mun = `https://apis.datos.gob.ar/georef/api/departamentos?provincia=${provincia}&campos=id,nombre,centroide.lat,centroide.lon&max=100`;

            fetch(url_mun)
                .then(datos => datos.json())
                .then(datos => {
                    let aux = '';
                    let arrSel = [{ id: 0, nombre: "Seleccionar" }];
                    let arrDeps = Object.assign([], datos.departamentos);
                    let arrDepsOk = arrSel.concat(arrDeps);
                    console.log(arrDepsOk)
                    arrDepsOk.forEach(d => {
                        aux += `<option> ${d.nombre ? d.nombre : ""} </option>`;
                    })
                    municipios.innerHTML = aux

                })
                .catch(error => {

                    municipios.innerHTML = error
                })
        } else {
            //muestra solo las localidades
            document.querySelector("#mMunicipios-registro").style.display = "none";
            document.querySelector("#lLocalidades-registro").style.display = "block";

            let url_local_bs = `https://apis.datos.gob.ar/georef/api/localidades?provincia=${provincia}&campos=id,nombre,centroide.lat,centroide.lon&max=100`;
            fetch(url_local_bs)
                .then(datos => datos.json())
                .then(datos => {
                    console.log('localidades caba')
                    let aux = '';
                    let arrSel = [{ id: 0, nombre: "Seleccionar" }];
                    let arrLocs = Object.assign([], datos.localidades);
                    let arrLocsOk = arrSel.concat(arrLocs);
                    console.log(arrLocsOk)



                    arrLocsOk.forEach(l => {
                        aux += `<option> ${l.nombre ? l.nombre : ""} </option>`;
                    })
                    localidades.innerHTML = aux;

                })
                .catch(error => {

                    localidades.innerHTML = error;
                })

        }
    } else {
        console.log("SELECCIONA UNA PROVINCIA");
    }
}

function cargarLocalidades() {
    let provincia = document.querySelector("#provincias-registro").value;
    let departamento = document.querySelector("#municipios-registro").value;
    let localidades = document.querySelector("#localidades-registro");
    document.querySelector("#lLocalidades-registro").style.display = "block";

    let url_local = `https://apis.datos.gob.ar/georef/api/localidades?provincia=${provincia}&departamento=${departamento}&campos=id,nombre&max=100`;

    fetch(url_local)
        .then(datos => datos.json())
        .then(datos => {
            let aux = '';
            let arrSel = [{ id: 0, nombre: "Seleccionar" }];
            let arrLocs = Object.assign([], datos.localidades);
            let arrLocsOk = arrSel.concat(arrLocs);
            console.log(arrLocsOk)

            arrLocsOk.forEach(l => {
                aux += `<option> ${l.nombre ? l.nombre : ""} </option>`;
            })
            localidades.innerHTML = aux;

        })
        .catch(error => {

            localidades.innerHTML = error;
        })

}

function validarActualizacionUbicacionDatos() {

    let provincia = document.querySelector("#provincias-registro").value;
    let departamento = document.querySelector("#municipios-registro").value;
    let localidad = document.querySelector("#localidades-registro").value;

    if (provincia != null && provincia != 'seleccionar' &&
        departamento != null && departamento != 'seleccionar' &&
        localidad != null && localidad != 'seleccionar') {
        document.getElementById("guardarUbicacion").style.display = "block";
    } else {
        document.getElementById("guardarUbicacion").style.display = "none";
    }


}

// se cambio a centroide municipio por el momento
function cargarCentroideLocalidad() {
    let provincia = document.querySelector("#provincias-registro").value;
    let departamento = document.querySelector("#municipios-registro").value;
    let localidad = document.querySelector("#localidades-registro").value;


    let coordenadas = {
        lat: '',
        lon: ''
    };

    if (provincia != 'Ciudad Autónoma de Buenos Aires') {

        let url_centroide_localidad = `https://apis.datos.gob.ar/georef/api/localidades?nombre=${localidad}&departamento=${departamento}&provincia=${provincia}`;

        fetch(url_centroide_localidad)
            .then(datos => datos.json())

            .then(datos => {
                datos.localidades.forEach(e => {
                    console.log(e.centroide)
                    coordenadas.lat = e.centroide.lat;
                    coordenadas.lon = e.centroide.lon;

                });
                console.log(coordenadas);
                document.querySelector("#lat").value = coordenadas.lat;
                document.querySelector("#lon").value = coordenadas.lon;

            })
            .catch(error => {
                console.log(error)
            })
    } else {

        let url_centroide_localidad = `https://apis.datos.gob.ar/georef/api/localidades?nombre=${localidad}&provincia=${provincia}`;

        fetch(url_centroide_localidad)
            .then(datos => datos.json())

            .then(datos => {
                datos.localidades.forEach(e => {
                    console.log(e.centroide)
                    coordenadas.lat = e.centroide.lat;
                    coordenadas.lon = e.centroide.lon;

                });
                console.log(coordenadas);
                document.querySelector("#lat").value = coordenadas.lat;
                document.querySelector("#lon").value = coordenadas.lon;

            })
            .catch(error => {
                console.log(error)
            })
    }


}

function cargarCentroideMunicipio() {
    let provincia = document.querySelector("#provincias-registro").value;
    let departamento = document.querySelector("#municipios-registro").value;
    let localidad = document.querySelector("#localidades-registro").value;


    let coordenadas = {
        lat: '',
        lon: ''
    };

    if (provincia != 'Ciudad Autónoma de Buenos Aires') {

        let url_centroide_localidad = `https://apis.datos.gob.ar/georef/api/departamentos?nombre=${departamento}&provincia=${provincia}&campos=id,nombre,centroide.lat,centroide.lon`;

        fetch(url_centroide_localidad)
            .then(datos => datos.json())

            .then(datos => {
                datos.departamentos.forEach(e => {
                    console.log(e.centroide)
                    coordenadas.lat = e.centroide.lat;
                    coordenadas.lon = e.centroide.lon;

                });
                console.log(coordenadas);
                document.querySelector("#lat").value = coordenadas.lat;
                document.querySelector("#lon").value = coordenadas.lon;

            })
            .catch(error => {
                console.log(error)
            })
    } else {

        let url_centroide_localidad = `https://apis.datos.gob.ar/georef/api/localidades?nombre=${localidad}&provincia=${provincia}`;

        fetch(url_centroide_localidad)
            .then(datos => datos.json())

            .then(datos => {
                datos.localidades.forEach(e => {
                    console.log(e.centroide)
                    coordenadas.lat = e.centroide.lat;
                    coordenadas.lon = e.centroide.lon;

                });
                console.log(coordenadas);
                document.querySelector("#lat").value = coordenadas.lat;
                document.querySelector("#lon").value = coordenadas.lon;

            })
            .catch(error => {
                console.log(error)
            })
    }


}
