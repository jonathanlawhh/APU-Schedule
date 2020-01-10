importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');

(workbox) ? console.log(`Yay! Workbox is loaded 🎉`) : console.log(`Boo! Workbox didn't load 😬`);
workbox.precaching.precacheAndRoute([]);
workbox.routing.registerRoute(
    /\.(?:js|css)$/,
    new workbox.strategies.StaleWhileRevalidate({
        cacheName: "apu-schedule-ui",
        plugins: [
            new workbox.expiration.Plugin({
                maxAgeSeconds: 10 * 60 // 10 minutes
            })
        ]
    })
);

workbox.routing.registerRoute(
    "/",
    new workbox.strategies.StaleWhileRevalidate({
        cacheName: "apu-schedule-url",
        plugins: [
            new workbox.expiration.Plugin({
                maxAgeSeconds: 10 * 60 // 10 minutes
            })
        ]
    })
);

workbox.routing.registerRoute(
    new RegExp('https://fonts.(?:googleapis|gstatic).com/(.*)'),
    workbox.strategies.cacheFirst({
        cacheName: 'apu-schedule-font',
        plugins: [
            new workbox.expiration.Plugin({
                maxEntries: 30,
            }),
        ],
    }),
);