var CACHE_NAME = 'cache-apu-s';
var urlsToCache = [
  '/',
  '/index.php',
  '/control/mytimetable.php',
  'https://fonts.googleapis.com/icon?family=Material+Icons',
  'https://fonts.gstatic.com/s/materialicons/v37/flUhRq6tzZclQEJ-Vdg-IuiaDsNcIhQ8tQ.woff2',
  '/app.js?ver=1',
  '/images/appicon.png',
  '/css/materialize.min.css?ver=1.2',
  '/js/materialize.min.js?ver=1.2',
  '/js/core.js?ver=1.3',
  '/fragment/classlist.html?ver=1',
  'syntax.html?ver=1.04',
];

self.addEventListener('install', function(event) {
  // Perform install steps
  event.waitUntil(
    caches.open(CACHE_NAME) .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', function(event) {
  if (navigator.onLine) {
      event.respondWith(
          caches.open(CACHE_NAME).then(function(cache) {
              return fetch(event.request).then(function(response) {
                  cache.put(event.request, response.clone());
                  console.log('Updated new cache');
                  return response;
              });
          })
      );
  } else {
      event.respondWith(
          fetch(event.request).catch(function() {
              console.log('Loaded cache');
              return caches.match(event.request);
          })
      );
  }
});
