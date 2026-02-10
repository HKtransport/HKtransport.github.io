// Change le nom du cache à chaque grosse mise à jour
const CACHE_NAME = "baba-colis-cache-v3";

const urlsToCache = [
  "index.html",
  "envoyer.html",
  "paiement.html",
  "confirmation.html",
  "suivre.html",
  "pointsrelais.html",
  "contact.html",
  "success.html",
  "manifest.json",
  "icon-192.png",
  "icon-512.png"
];

self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(urlsToCache);
    })
  );
});

self.addEventListener("activate", event => {
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys
          .filter(key => key !== CACHE_NAME)
          .map(key => caches.delete(key))
      );
    })
  );
});

self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    })
  );
});
