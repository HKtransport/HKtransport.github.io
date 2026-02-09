const CACHE_NAME = "baba-colis-cache-v1";
const urlsToCache = [
  "index.html",
  "envoyer.html",
  "suivre.html",
  "pointsrelais.html",
  "contact.html",
  "confirmation.html",
  "paiement.html",
  "manifest.json"
];

self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(urlsToCache);
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
