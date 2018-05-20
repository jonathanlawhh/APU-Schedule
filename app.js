importScripts("https://storage.googleapis.com/workbox-cdn/releases/3.2.0/workbox-sw.js");

workbox.precaching.precacheAndRoute([]);
const articleHandler = workbox.strategies.networkFirst({cacheName: 'cache-apu-s'});
workbox.routing.registerRoute(/(.*)index(.*)\.php/, args => {return articleHandler.handle(args);});
workbox.routing.registerRoute(new RegExp('.*\.js'),workbox.strategies.cacheFirst({cacheName: 'cache-apu-s'}));
workbox.routing.registerRoute(new RegExp('.*\.css'),workbox.strategies.cacheFirst({cacheName: 'cache-apu-s'}));
workbox.routing.registerRoute(new RegExp('.*\.html*\.'),workbox.strategies.cacheFirst({cacheName: 'cache-apu-s'}));
workbox.routing.registerRoute(new RegExp('^https://fonts.(?:googleapis|gstatic).com/(.*)'),workbox.strategies.cacheFirst({cacheName: 'cache-apu-s'}),);
