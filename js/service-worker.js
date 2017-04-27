var cacheName = "pickaspy-v1.3.1"; // fix batman and number parsing
// prettier-ignore
var filesToCache = [
  '/',
  '/index.html',
  '/style.css',
];
console.log("[SW]", cacheName, filesToCache);
// Setup cache
self.addEventListener("install", function(e) {
  console.log("[SW] Install");
  e.waitUntil(
    caches
      .open(cacheName)
      .then(function(cache) {
        console.log("[SW] Caching app shell");
        return cache.addAll(filesToCache);
      })
      .catch(function(reason) {
        console.log("[SW] Install error: " + reason);
      })
  );
});
// Serve from cache
self.addEventListener("fetch", function(e) {
  // console.log('[SW] Fetch', e.request.url);
  e.respondWith(
    caches.match(e.request).then(function(response) {
      // if (response) console.log('[SW] Cache return', response);
      return response || fetch(e.request);
    })
  );
});
// If cacheName changes, delete old cache
self.addEventListener("activate", function(e) {
  console.log("[SW] Activate");
  e.waitUntil(
    caches.keys().then(function(keyList) {
      return Promise.all(
        keyList.map(function(key) {
          if (key !== cacheName) {
            console.log("[SW] Removing old cache", key);
            return caches.delete(key);
          }
        })
      );
    })
  );
  return self.clients.claim();
});
