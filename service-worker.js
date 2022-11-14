;
//Nombre y versión del cache
const CACHE_NAME = 'v1_cache_appdondecompro',
  urlsToCache = [
    './',
    'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
    './view/assets/css/app.min.css',
    './view/assets/css/app.css',

    './view/assets/js/app.js',
    './view/assets/js/app.min.js',
    './view/assets/js/cuenta.js',
    './view/assets/js/customize-theme.js',
    './view/assets/js/negocios.js',
    './view/assets/js/nueva-clave.js',
    './view/assets/js/precio.js',
    './view/assets/js/productos.js',
    './view/assets/js/script.js',
    './view/assets/js/validar.js',

    './view/assets/media/icons/icon_512.png',
    './view/assets/media/icons/icon_384.png',
    './view/assets/media/icons/icon_256.png',
    './view/assets/media/icons/icon_192.png',
    './view/assets/media/icons/icon_128.png',
    './view/assets/media/icons/icon_96.png',
    './view/assets/media/icons/icon_64.png',
    './view/assets/media/icons/icon_32.png',

    './view/assets/media/image/ositos/01.png',
    './view/assets/media/image/ositos/2.png',
    './view/assets/media/image/ositos/3.png',
    './view/assets/media/image/ositos/4.png',
    './view/assets/media/image/ositos/5.png',
    './view/assets/media/image/ositos/activada.png',
    './view/assets/media/image/ositos/administracion.png',
    './view/assets/media/image/ositos/agregar-negocio.png',
    './view/assets/media/image/ositos/agregar-usuario.png',
    './view/assets/media/image/ositos/ajustes.png',
    './view/assets/media/image/ositos/ajustes-superadmin.png',
    './view/assets/media/image/ositos/buscar.png',
    './view/assets/media/image/ositos/error.png',
    './view/assets/media/image/ositos/recuperar-clave.png',
    './view/assets/media/image/ositos/super-admin.png',
    './view/assets/media/image/ositos/verificacion.png',

    './view/assets/media/image/user/default.png',
    './view/assets/media/image/favicon.png',
    './view/assets/media/image/logo.png',

    './view/assets/sass/app.scss',
    './view/assets/sass/dark.scss',
    './view/assets/sass/layouts.scss',
    './view/assets/sass/other.scss',
    './view/assets/sass/responsive.scss',
    './view/assets/sass/rtl.scss',

    './view/assets/sass/components/accordion.scss',
    './view/assets/sass/components/alert.scss',
    './view/assets/sass/components/aside.scss',
    './view/assets/sass/components/authentication.scss',
    './view/assets/sass/components/avatar.scss',
    './view/assets/sass/components/badge.scss',
    './view/assets/sass/components/body.scss',
    './view/assets/sass/components/breadcrumb.scss',
    './view/assets/sass/components/button.scss',
    './view/assets/sass/components/calendar.scss',
    './view/assets/sass/components/card.scss',
    './view/assets/sass/components/chat.scss',
    './view/assets/sass/components/collapse.scss',
    './view/assets/sass/components/color.scss',
    './view/assets/sass/components/colorpicker.scss',
    './view/assets/sass/components/datepicker.scss',
    './view/assets/sass/components/demo.scss',
    './view/assets/sass/components/dropdown.scss',
    './view/assets/sass/components/error.scss',
    './view/assets/sass/components/file-upload.scss',
    './view/assets/sass/components/footer.scss',
    './view/assets/sass/components/form.scss',
    './view/assets/sass/components/form-wizard.scss',
    './view/assets/sass/components/gallery.scss',
    './view/assets/sass/components/header.scss',
    './view/assets/sass/components/icon-block.scss',
    './view/assets/sass/components/lightbox.scss',
    './view/assets/sass/components/list-group.scss',
    './view/assets/sass/components/media-object.scss',
    './view/assets/sass/components/modal.scss',
    './view/assets/sass/components/navigation.scss',
    './view/assets/sass/components/nestable.scss',
    './view/assets/sass/components/notification.scss',
    './view/assets/sass/components/page-header.scss',
    './view/assets/sass/components/pagination.scss',
    './view/assets/sass/components/preloader.scss',
    './view/assets/sass/components/pricing-table.scss',
    './view/assets/sass/components/profile.scss',
    './view/assets/sass/components/progress.scss',
    './view/assets/sass/components/range-slider.scss',
    './view/assets/sass/components/scrollbar.scss',
    './view/assets/sass/components/select2.scss',
    './view/assets/sass/components/slick.scss',
    './view/assets/sass/components/sweet-alert.scss',
    './view/assets/sass/components/table.scss',
    './view/assets/sass/components/timeline.scss',
    './view/assets/sass/components/timepicker.scss',
    './view/assets/sass/components/toastr.scss',
    './view/assets/sass/components/tour.scss',
    './view/assets/sass/components/typography.scss',
    './view/assets/sass/components/webapp.scss',

    './view/assets/sass/core/mixins.scss',
    './view/assets/sass/core/vars.scss',

    './view/fonts/Comfortaa-Bold.ttf',
    './view/fonts/Comfortaa-Light.ttf',
    './view/fonts/Comfortaa-Regular.ttf',
    './view/fonts/fontawesome-webfont.eot',
    './view/fonts/fontawesome-webfont.svg',
    './view/fonts/fontawesome-webfont.ttf',
    './view/fonts/fontawesome-webfont.woff',
    './view/fonts/fontawesome-webfont.woff2',
    './view/fonts/pe-icon-set-weather.eot',
    './view/fonts/pe-icon-set-weather.svg',
    './view/fonts/pe-icon-set-weather.ttf',
    './view/fonts/pe-icon-set-weather.woff',
    './view/fonts/themify.eot',
    './view/fonts/themify.svg',
    './view/fonts/themify.ttf',
    './view/fonts/themify.woff',

    './view/html/default/content-body-0.html',
    './view/html/default/header.html',
    './view/html/default/navigation.html',


    './view/html/negocio-activa/content-body-0.html',
    './view/html/negocio-activa/content-body-1.html',
    './view/html/negocio-activa/content-body-2.html',
    './view/html/negocio-activa/header.html',
    './view/html/negocio-activa/navigation.html',

    './view/html/negocio-inactiva/content-body-1.html',
    './view/html/negocio-inactiva/content-body-2.html',
    './view/html/negocio-inactiva/header.html',
    './view/html/negocio-inactiva/navigation.html',

    './view/html/super-admin/content-body-0.html',
    './view/html/super-admin/content-body-1.html',
    './view/html/super-admin/content-body-2.html',
    './view/html/super-admin/header.html',
    './view/html/super-admin/navigation.html',

    './view/html/usuario/content-body-0.html',
    './view/html/usuario/content-body-1.html',
    './view/html/usuario/content-body-2.html',
    './view/html/usuario/header.html',
    './view/html/usuario/navigation.html',

    './view/vendors/bundle.css',
    './view/vendors/bundle.js',
    './view/vendors/jquery.isotope.min.js',
    './view/vendors/jquery.repeater.min.js',





  ]

//Fase de instalación
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache)
          .then(() => self.skipWaiting())
      })
      .catch(err => console.log('Falló registro de cache', err))
  )
})

//Busca los recursos para funcionar sin conexión
self.addEventListener('activate', e => {
  const cacheWhitelist = [CACHE_NAME]

  e.waitUntil(
    // caches.keys()
    //   .then(cacheNames => {
    //     return Promise.all(
    //       cacheNames.map(cacheName => {
    //         //Eliminamos lo que ya no se necesita en cache
    //         if (cacheWhitelist.indexOf(cacheName) === -1) {
    //           return caches.delete(cacheName)
    //         }
    //       })
    //     )
    //   })
    caches.keys().then(function (names) {
      for (let name of names) {
        console.log(name);
        caches.delete(name);
      }

    })
      // Le indica al SW activar el cache actual
      .then(() => self.clients.claim())
  )
})

//cuando el navegador recupera una url
self.addEventListener('fetch', e => {
  //Responder ya sea con el objeto en caché o continuar y buscar la url real
  e.respondWith(
    caches.match(e.request)
      .then(res => {
        if (res) {
          //recuperar del cache
          return res
        }
        //recuperar de la petición a la url
        // console.log(e);
        return fetch(e.request)
      }).catch((err) => {
        // console.log(err);
      })
  )
})
