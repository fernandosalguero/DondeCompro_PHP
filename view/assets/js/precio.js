aux_pagina = 1;
aux2_pagina = 0;
modalFailShown = false;
ubicacionAutomatica = null;
swalAutolocalizationShown = false;


$(() => {
    console.log('comparador cargado');
    $('.loader-comparador').hide();
    document.getElementById("productos").innerHTML = "<div class = 'card-per4 text-center'> \n\
        <div></div></div>";
});

// alert('nuevo script cargado 2');

var llamadasPreciosClaros = 0;
var isBuscando = false;

var caracteres = 0;
var ingresado = 0;
var useLocalizationConfirm = false;


function showAlertLocalization() {

    return new Promise((resolve, reject) => {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-3',
                cancelButton: 'btn btn-danger mx-3'
            },
            buttonsStyling: false
        })


        swalWithBootstrapButtons.fire({
            title: 'Servicio de ubicación',
            text: "¿Querés usar la localización automática? Estó ayudará a mejorar los resultados de tu búsqueda",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                resolve(true);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                reject(false);
            }
        })
    })

}

function geoLocalization() {
    return new Promise(async (resolve, reject) => {
        try {
            if ("geolocation" in navigator) {
                if (await showAlertLocalization()) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        console.log(position);
                        console.log(position.coords.latitude, position.coords.longitude);
                        resolve(position);
                    });
                } else {
                    throw new Error('Localizacion automatica rechazada');
                }

            } else {
                console.log('geo no disponible')
                throw new Error('La geolocalización automática no está activada');
            }
        } catch (error) {
            reject(error);
        }
    })
}

function getUsuarioData() {
    return new Promise((resolve, reject) => {
        fetch("controller/obtener_datos_pc.php")
            .then(data => data.text())
            .then(async (data) => {
                //    console.log(data);

                if (data != null) {
                    let obj = JSON.parse(data);
                    if ((obj.usuario.hasOwnProperty('provincia') && (obj.usuario.provincia == null || obj.usuario.provincia == '')) ||
                        (obj.usuario.hasOwnProperty('municipio') && (obj.usuario.municipio == null || obj.usuario.municipio == '')) ||
                        (obj.usuario.hasOwnProperty('centroide_localidad_lat') && (obj.usuario.centroide_localidad_lat == null || obj.usuario.centroide_localidad_lat == '')) ||
                        (obj.usuario.hasOwnProperty('centroide_localidad_lon') && (obj.usuario.centroide_localidad_lon == null || obj.usuario.centroide_localidad_lon == ''))
                    ) {

                        swal('Antes de utilizar el comparador por favor completá tus datos de ubicación (provincia y municipio)');
                        reject(new Error('Sin datos de ubicación para el usuario'));
                        $('.loader-comparador').fadeOut(300);

                        return reject(new Error('Error al obtener data de ubicacion de usuario'));

                    } else {
                        // busca en primera instancia
                        if (ubicacionAutomatica == null) {

                            // if (!await showAlertLocalization()) resolve(obj);

                            let lat = null;
                            let lon = null;

                            try {
                                geoLocalization()
                                    .then((position) => {

                                        lat = position.coords.latitude;
                                        lon = position.coords.longitude;

                                        obj.usuario.centroide_localidad_lat = lat;
                                        obj.usuario.centroide_localidad_lon = lon;

                                        ubicacionAutomatica = {
                                            latitud: lat,
                                            longitud: lon
                                        };
                                        resolve(obj);

                                    }).catch((err) => {
                                        // si falla anterior intenta por otro medio acceder a la localizacion automatica
                                        getLatLonIp()
                                            .then((values) => {
                                                if (values) {
                                                    ubicacionAutomatica = values;
                                                    //   console.log(values);
                                                    obj.usuario.centroide_localidad_lat = values.latitud;
                                                    obj.usuario.centroide_localidad_lon = values.longitud;
                                                    //  console.log(obj);
                                                    resolve(obj);

                                                }
                                            }).catch((err) => {
                                                console.log('*** Error al setear valores de ubicacion automatica 1: ' + err.message);
                                                resolve(obj);

                                            })
                                    })

                            } catch (err) {
                                console.log('*** Error al setear valores de ubicacion automatica 2: ' + err.message)
                                resolve(obj);
                            }
                            //toma de variable y setea
                        } else {
                            obj.usuario.centroide_localidad_lat = ubicacionAutomatica.latitud;
                            obj.usuario.centroide_localidad_lon = ubicacionAutomatica.longitud;
                            resolve(obj);

                        }
                    }
                }
            })
            .catch(err => reject(err));

    })

}

function getLatLonIp() {

    return new Promise((resolve, reject) => {


        fetch("https://jsonip.com")
            .then((val) => val.json())
            .then((json) => {
                //  console.log(json)
                const data = new URLSearchParams();
                data.append('ip-address', json.ip);

                fetch('controller/geolocalization/localization.php', {

                    method: 'POST', // *GET, POST, PUT, DELETE, etc.
                    mode: 'no-cors', // no-cors, *cors, same-origin
                    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                    credentials: 'omit', // include, *same-origin, omit
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: data
                })
                    .then((val) => val.json())
                    .then((val) => {
                        //  console.log(val)
                        resolve(val);
                    })
                    .catch((err) => {
                        //  console.log(err);
                        reject(err);

                    })
            })
            .catch((err) => {
                if (useLocalizationConfirm) {

                    if (swalAutolocalizationShown == false) {
                        swal('No se pudo obtener información de ubicación actual. Para usar la geolocalización automática por favor desactivá tu bloqueador de anuncios, gracias');
                        swalAutolocalizationShown = true;
                    }
                }

                reject(err);
            });
    })


}

function getSucursalesPreciosClaros(lat, lon) {

    console.log('latitud', lat, 'longitud', lon)
    return new Promise((resolve, reject) => {
        try {
            latLon = localStorage.getItem('lat-lon');
            if (latLon != null) {
                let lat_lon = JSON.parse(latLon);
                if (lat_lon.lon == lon && latLon.lat == lat) {
                    let sucursalesStr = localStorage.getItem('sucursales_pc');
                    if (sucursalesStr != null) {
                        resolve(JSON.parse(sucursalesStr));
                    }
                }
            }

            fetch(`https://d3e6htiiul5ek9.cloudfront.net/prod/sucursales?lat=${lat}&lng=${lon}&limit=30&`)
                .then(data => data.text())
                .then(data => {
                    // console.log(data);
                    if (data != null) {
                        let sucursalesObj = JSON.parse(data);
                        localStorage.setItem('sucursales_pc', JSON.stringify(sucursalesObj.sucursales));
                        resolve(sucursalesObj.sucursales);
                    }
                    resolve(null);

                }).catch((err) => {
                    if (modalFailShown == false) {
                        $('.loader-comparador').fadeOut(300);
                        console.log('Error al obtener sucursales desde busqueda de sucursales');
                        let eventError = new Event('error_preciosclaros');
                        document.dispatchEvent(eventError);
                        modalFailShown = true;
                        resolve(null);
                    } else {
                        console.log(' ***** Evitando mostrar modal de error P C');
                        resolve(null);
                    }
                });
        } catch (e) {
            reject(e)
        }
    });

}

function getProductosPreciosClaros(producto) {

    return new Promise(async (resolve, reject) => {

        try {
            let userData = await getUsuarioData();
            // console.log(userData)
            let sucursales_pc = await getSucursalesPreciosClaros(userData.usuario.centroide_localidad_lat, userData.usuario.centroide_localidad_lon);
            // console.log(sucursales_pc)
            let sucursalesStr = '';

            for (let index = 0; index < sucursales_pc.length; index++) {
                sucursalesStr += sucursales_pc[index].id + `${index == sucursales_pc.length - 1 ? '' : ','}`;
            }

            let offset = 0;
            let limit = 100;

            productoUrlEncode = '';
            for (i = 0; i < producto.length; i++) {
                let charActual = producto[i];
                // var_dump($charActual);
                if (charActual == ' ') {
                    charActual = '%20';
                }
                productoUrlEncode = productoUrlEncode + charActual;
            }
            llamadasPreciosClaros++;
            console.log('llamadas a precios claros = ' + llamadasPreciosClaros);
            // trae los primeros y totales
            fetch(`https://d3e6htiiul5ek9.cloudfront.net/prod/productos?string=${productoUrlEncode}&array_sucursales=${sucursalesStr}&offset=${offset}&limit=${limit}&sort=-cant_sucursales_disponible`)
                .then(data => data.text())
                .then(data => {
                    //   console.log(data)
                    let productosObj = JSON.parse(data);
                    var productosTotal = productosObj.productos;
                    let total = productosObj.total;
                    let iteraciones = Math.ceil(total / limit);

                    for (i = 0; i < iteraciones; i++) {
                        offset += limit;
                        fetch(`https://d3e6htiiul5ek9.cloudfront.net/prod/productos?string=${productoUrlEncode}&array_sucursales=${sucursalesStr}&offset=${offset}&limit=${limit}&sort=-cant_sucursales_disponible`)
                            .then(data => data.text())
                            .then(data => {
                                // console.log(data)
                                let productosObj = JSON.parse(data);
                                localStorage.setItem('productos_pc', data);
                                productosTotal = productosTotal.concat(productosObj.productos);

                            }).catch(err => {
                                reject(err);
                            });
                    }
                    resolve(productosTotal);

                }).catch(err => {
                    reject(err);
                });
        } catch (error) {
            console.log('Error al obtener sucursales desde busqueda de productos');
            console.log(error.message);
            reject(error)
        }
    });
}

function getProductosComparacionPreciosClaros() {

    return new Promise(async (resolve, reject) => {

        try {

            let userData = await getUsuarioData();
            let sucursales_pc = await getSucursalesPreciosClaros(userData.usuario.centroide_localidad_lat, userData.usuario.centroide_localidad_lon, false);
            let sucursalesStr = '';

            if (sucursales_pc == null) {
                return resolve([]);
            }
            // console.log(sucursales_pc);

            for (let index = 0; index < sucursales_pc.length; index++) {
                sucursalesStr += sucursales_pc[index].id + `${index == sucursales_pc.length - 1 ? '' : ','}`;
            }

            let resultadoComparacion = [];
            console.log(userData.listado_codigo);
            for (let index = 0; index < userData.listado_codigo.length; index++) {
                try {
                    let data = await fetch(`https://d3e6htiiul5ek9.cloudfront.net/prod/producto?limit=30&id_producto=${userData.listado_codigo[index]}&array_sucursales=${sucursalesStr}`)
                    data = await data.text();

                    console.log(data)
                    let productoComparacionObj = JSON.parse(data);
                    let productoComparacionData = {
                        producto: productoComparacionObj.producto,
                        sucursales: productoComparacionObj.sucursales
                    }

                    resultadoComparacion.push(productoComparacionData);


                } catch (error) {
                    reject(error);
                }


            }
            resolve(resultadoComparacion);
        } catch (err) {

            reject(err);

        }
    })



}

function buscarEnter() {
    var inputSearch = document.getElementById("termino");

    inputSearch.addEventListener("keyup", function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            buscar(event);
        }
    });
}

function buscar(event) {

    event.stopPropagation();
    if (isBuscando == true) return;

    isBuscando = true;

    $('.loader-comparador').show();
    llamadasPreciosClaros = 0;

    var termino = document.getElementById("termino").value;
    if (termino == "") {

        document.getElementById("productos").innerHTML = "";
        $('.loader-comparador').fadeOut(300);
        isBuscando = false;

    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // console.log('cargado')
                // console.log(this.responseText);
                isBuscando = false;
                document.getElementById("productos").innerHTML = this.responseText;
                $('.loader-comparador').fadeOut(300);

            } else {
                if (this.readyState > 4 && status != 200)
                    $('.loader-comparador').fadeOut(300);
                isBuscando = false;

            }
        }
        console.log(termino)
        getProductosPreciosClaros(termino)
            .then((resBusqueda) => {
                // console.log(resBusqueda);
                let form = new FormData();
                form.append('tipo', 'set');
                form.append('productos_busqueda', JSON.stringify(resBusqueda));
                // guarda los productos de pclaros encontrados en sesion
                fetch('controller/precios_claros/productos_busqueda.php', {
                    method: 'POST',
                    body: form
                }).then(data => { data.text() }).then(() => {
                    // realiza la busqueda incluyendo los productos enviados en el request anterior a sesion
                    xhttp.open("GET", "controller/buscar_precios.php?termino=" + termino + "&pagina=" + 1, true);
                    xhttp.send();
                })
            })
            .catch((err) => {
                // revisa previamente los datos de usuario para saber si tiene datos de ubicacion para no comparar si no tiene
                getUsuarioData().then(() => {
                    console.log('Error al obtener datos desde precios claros, se buscará sólo en Donde Compro')
                    // si se produce un error al buscar en precios claros se producela busqueda solo en dondecompro
                    xhttp.open("GET", "controller/buscar_precios.php?termino=" + termino + "&pagina=" + 1, true);
                    xhttp.send();
                }).catch(() => {
                    console.log('El usuario no tiene datos completos')
                })

            });

    }

}

function anterior(ultima) {

    if (aux_pagina !== 1 && aux_pagina > 1) {

        aux_pagina -= 1;

    } else {

        aux_pagina = ultima;
    }

    var termino = document.getElementById("termino").value;



    if (termino == "") {

        document.getElementById("productos").innerHTML = "";


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_precios.php?termino=" + termino + "&pagina=" + aux_pagina, true);
        xhttp.send();


    }

}

function siguiente(ultima) {

    if (aux_pagina == ultima) {

        aux_pagina = 1;

    } else {

        aux_pagina += 1;

    }

    var termino = document.getElementById("termino").value;



    if (termino == "") {

        document.getElementById("productos").innerHTML = "";


    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_precios.php?termino=" + termino + "&pagina=" + aux_pagina, true);
        xhttp.send();


    }

}

function pagina(pagina) {

    console.log('pide pagina', pagina);

    aux_pagina = pagina;

    var termino = document.getElementById("termino").value;

    console.log('termino', termino);

    if (termino == "") {
        document.getElementById("productos").innerHTML = "";
    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;
            }
        }
        xhttp.open("GET", "controller/buscar_precios.php?termino=" + termino + "&pagina=" + aux_pagina, true);
        xhttp.send();

        console.log('top')
        $('html, body').animate({
            scrollTop: $("#content-comparador").offset().top
        }, 2000);

    }
}

function comparar(codigo) {

    var id = codigo.toString();

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById(id).innerHTML = this.responseText;

        }

    }

    xhttp.open("GET", "controller/comparador.php?codigo=" + codigo, true);
    xhttp.send();

    document.getElementById(id).innerHTML = "<div class = 'card-per2 text-center'> \n\
        <div class='spinner-border text-success' role='status'> <span class='sr-only'>Espera...</span></div>";

}

function ocultar() {

    var termino = document.getElementById("termino").value;



    if (termino == "") {

        document.getElementById("productos").innerHTML = ""

        aux_no_content = 0;

    } else {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("productos").innerHTML = this.responseText;


            }

        }

        xhttp.open("GET", "controller/buscar_precios.php?termino=" + termino + "&pagina=" + aux_pagina, true);
        xhttp.send();


    }



}

function otroPrecio(codigo, tope) {

    if (aux2_pagina == tope) {

        aux2_pagina = 0;

    } else {

        aux2_pagina++;

    }


    var id = codigo.toString();

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById(id).innerHTML = this.responseText;


        }

    }

    xhttp.open("GET", "controller/comparador.php?codigo=" + codigo + "&bajo=" + aux2_pagina, true);
    xhttp.send();

    document.getElementById(id).innerHTML = "<div class = 'card-per2 text-center'> \n\
        <div class='spinner-border text-success' role='status'> <span class='sr-only'>Espera...</span></div>";




}

function anadirListado(a) {
    console.log(a);
    let id = a.toString().padStart(13, '0');
    console.log(id);
    let producto = document.getElementById(id).textContent
    let auxProducto = producto.replace(" ", "_")
    let miListado = document.getElementById("miListado")
    let noProductos = document.getElementById("noProductos")

    console.log(id);
    console.log('-------producto------------')
    console.log(producto)

    marcarSeleccionado(id);

    fetch("controller/consultar_indice.php")
        .then(data => data.text())
        .then(data => {

            indice = data
            let producto2 = `
            <div class = 'card tarjeta-resultado-producto' style="background: white !important;" data-bs-toggle='tooltip' data-bs-placement='top' id='${indice}' onclick="eliminarProducto(${indice})">
            <img style="margin: 0 auto; width: 200px;" src="https://imagenes.preciosclaros.gob.ar/productos/${id}.jpg" onerror="this.src='view/assets/media/image/product_default.png'">
            <div class = 'card-body body-resultados'>
            <div style="background: #f2f1ed; border-radius: 5px; padding: 5px;">
            <p> ${producto} <i style="font-weight: 500 !important; font-size: 30px; background: #fe5a82; border: solid 4px white; color:white !important; border-radius: 50%; height: 37px; width: 38px;" class='fas fa-minus boton-anadir-listado'></i></p>
                </div>
                </div>
            </div>
            `;

            fetch("controller/agregar_productos_listado.php?producto=" + auxProducto + "&codigo=" + id) // cod barras
                .then(data => data.text())
                .then(data => {

                    if (parseInt(data) == 1) {

                        fetch("controller/consultar_contador.php")
                            .then(datos => datos.text())
                            .then(datos => {

                                let contador_productos = parseInt(datos);
                                // crea un emisor para avisar a los listeners de que se anadio un nuevo producto
                                let event = new CustomEvent('contadorProducto', { detail: { cantidad: Number.parseInt(contador_productos), producto } });
                                document.dispatchEvent(event);

                            });

                        if (noProductos.style.display == "block") {

                            noProductos.style.display = "none"

                            miListado.innerHTML += producto2

                            document.getElementById("comparador").style.display = "block";


                        } else {

                            miListado.innerHTML += producto2

                            document.getElementById("comparador").style.display = "block";

                        }

                    } else {

                        swal("No se pudo agregar el producto al listado, intentalo nuevamente");

                    }

                })

        })

}

function marcarSeleccionado(codigo) {

    $(`#ok_${codigo}`).switchClass("fa-plus", "fa-check", 1000, "easeInOutQuad");
    $(`#ok_${codigo}`).addClass("check-icon");
    $(`#card_${codigo}`).switchClass("card-available", "card-selected");
    $(`#an${codigo}`).switchClass("card-description-available", "card-description-selected");


}

function desmarcarSeleccionado(codigo) {

    $(`#ok_${codigo}`).switchClass("fa-check", "fa-plus", 1000, "easeInOutQuad");
    $(`#ok_${codigo}`).removeClass("check-icon");
    $(`#card_${codigo}`).switchClass("card-selected", "card-available");
    $(`#an${codigo}`).switchClass("card-description-selected", "card-description-available");


}

function eliminarProducto(a) {

    let id = a.toString()
    let producto = document.getElementById(id)

    fetch("controller/eliminar_producto_listado.php?indice=" + a)
        .then(data => data.text())
        .then(data => {

            let dataRes = JSON.parse(data);
            console.log(dataRes);

            if (dataRes.hasOwnProperty('producto') && dataRes.hasOwnProperty('result')) {

                // producto.style.display = "none";
                $(`#miListado`).find(producto).remove();

                fetch("controller/consultar_contador.php")
                    .then(datos => datos.text())
                    .then(datos => {
                        let contador = Number.parseInt(datos);
                        // crea un emisor para avisar a los listeners de que se anadio un nuevo producto
                        let event = new CustomEvent('contadorProducto', { detail: { cantidad: contador } });
                        document.dispatchEvent(event);


                        desmarcarSeleccionado(dataRes.producto);

                        if (contador < 1) {
                            let buscar = new Event('buscar');
                            document.dispatchEvent(buscar);
                            $('#noProductos').css('display', 'block');
                            $('#comparador').css('display', 'none');

                        }

                        // if (parseInt(datos) < 0) {

                        //     document.getElementById("comparador").style.display = "none";
                        //     document.getElementById("noProductos").style.display = "block";

                        // }
                    });

            } else {

                alert("error")

            }
        })

}

function verListado() {

    let miListado = document.getElementById("miListado")

    fetch("controller/ver_listado.php")
        .then(data => data.text())
        .then(data => {

            miListado.innerHTML = data

        });

}
// esta es la fn que realmente compara
async function comparador() {

    try {

        $('.loader-comparador').show();

        console.log('comparando...');

        let resultadoComparacion = await getProductosComparacionPreciosClaros();
        let userData = await getUsuarioData();
        console.log(userData)
        let sucursales_pc = await getSucursalesPreciosClaros(userData.usuario.centroide_localidad_lat, userData.usuario.centroide_localidad_lon);
        if (resultadoComparacion == null || resultadoComparacion == []) {
            fetch("controller/comparador.php")
                .then(data => data.text())
                .then(data => {

                    console.log(data);

                    if (data && data != "") {

                        const dataObj = JSON.parse(data);
                        console.log(dataObj);
                        if (dataObj.length < 1) { // no obtuvo comparacion
                            swal('No obtuvimos resultados', 'No pudimos obtener ningún resultado cerca de tu ubicación para el producto que buscás', 'error');
                        }
                        const cardsIniciales = dataObj.slice(0, 6);
                        renderCards(cardsIniciales, dataObj.length, 1);

                        let eventComparador = new Event('comparador');
                        document.dispatchEvent(eventComparador);

                        swalAutolocalizationShown = false;

                    } else {

                        swal("Aún no hay negocios cerca de vos, no has actualizado tu información de ubicación o es posible que cerca de tu ubicación no hayan negocios registrado, ¡Recomendá DóndeCompro a negocios cercanos a vos!")

                    }

                }).finally(() => {
                    $('.loader-comparador').fadeOut(300);

                })
        } else {

            let formComparacion = new FormData();
            formComparacion.append('resultadoComparacionPreciosClaros', JSON.stringify(resultadoComparacion));
            formComparacion.append('sucursalesPreciosClaros', JSON.stringify(sucursales_pc));
            console.log(" ############## RESULTADO COMPARACION #############");
            console.log(resultadoComparacion);

            fetch("controller/precios_claros/sucursales_comparacion.php", { method: 'post', body: formComparacion })
                .then((value) => {
                    fetch("controller/comparador.php")
                        .then(data => data.text())
                        .then(data => {

                            console.log(data);

                            if (data && data != "") {

                                const dataObj = JSON.parse(data);
                                console.log(dataObj);
                                if (dataObj.length < 1) { // no obtuvo comparacion
                                    swal('No obtuvimos resultados', 'No pudimos obtener ningún resultado cerca de tu ubicación para el producto que buscás', 'error');
                                }
                                const cardsIniciales = dataObj.slice(0, 6);
                                renderCards(cardsIniciales, dataObj.length, 1);

                                let eventComparador = new Event('comparador');
                                document.dispatchEvent(eventComparador);

                            } else {

                                swal("Aún no hay negocios cerca de vos, no has actualizado tu información de ubicación o es posible que cerca de tu ubicación no hayan negocios registrado, ¡Recomendá DóndeCompro a negocios cercanos a vos!")

                            }

                        }).finally(() => {
                            $('.loader-comparador').fadeOut(300);

                        })
                })
        }


    } catch (err) {
        console.log('Error en comparador');
        console.log(err.message);
        $('.loader-comparador').hide();
        swal('Se produjo un error al realizar comparacion, disculpa las molestias');
    }

}

function paginarComparador(indice) {

    fetch("controller/comparador_paginacion.php?indice=" + indice)
        .then(data => data.text())
        .then(data => {

            if (data && data != "") {
                const paginacionCards = JSON.parse(data);
                console.log(paginacionCards);

                renderCards(paginacionCards.cardsPaginaActual, paginacionCards.cantidadProductosTotal, paginacionCards.indice);

            }
        });

}

function paginarSiguienteAnteriorComparador(sumaIndice) {


    fetch("controller/comparador_paginacion.php?incremento_decremento=" + sumaIndice)
        .then(data => data.text())
        .then(data => {

            if (data && data != "") {
                const paginacionCards = JSON.parse(data);
                console.log(paginacionCards);

                renderCards(paginacionCards.cardsPaginaActual, paginacionCards.cantidadProductosTotal, paginacionCards.indice);

            }
        });
}

function renderCards(cardsPaginaActual, cantidadProductosTotal, pagina) {

    // console.log(pagina)

    let mejoresPrecios = document.getElementById("mejoresPrecios");

    let paginacion = document.getElementById("paginacionCardsMejoresPrecios");

    let cardsElementsHtml = '';
    for (let index = 0; index < cardsPaginaActual.length; index++) {
        cardsElementsHtml += cardsPaginaActual[index];
    }

    mejoresPrecios.innerHTML = cardsElementsHtml;

    const paginas = Math.ceil(cantidadProductosTotal / 6);
    // console.log(paginas)
    let paginacionElement = `<div aria-label="..." class="d-flex justify-content-center">
    <ul class="pagination pagination-rounded d-flex align-self-baseline">
    <li class="page-item">
        <a class="page-link" href="#" id="a-per-3" onclick="paginarSiguienteAnteriorComparador(-1)">
            <i class="ti-angle-left"></i>
        </a>
    </li>`;

    for (let index = 0; index < paginas; index++) {

        if ((index + 1) == pagina) { // item activo

            paginacionElement += `<li class="page-item active" btn-outline-youtube="">
            <a class="page-link active" href="#" id="a-per-3"  onclick="paginarComparador(${index + 1})">${index + 1}</a></li>`;

        } else { // items inactivos

            paginacionElement += `<li class="page-item" btn-outline-youtube="">
            <a class="page-link active" href="#" id="a-per-3"  onclick="paginarComparador(${index + 1})">${index + 1}</a></li>`;

        }

    }

    paginacionElement += ` <li class="page-item">
    <a class="page-link" href="#" id="a-per-3" onclick="paginarSiguienteAnteriorComparador(1)">
    <i class="ti-angle-right"></i>
    </a>
    </li>
    </ul>
    </div>`;

    paginacion.innerHTML = paginacionElement;
}