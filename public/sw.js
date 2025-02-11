const preLoad = function () {
  return caches.open("offline").then(function (cache) {
    // caching index and important routes
    return cache.addAll(filesToCache);
  });
};

self.addEventListener("install", function (event) {
  event.waitUntil(preLoad());
});

const filesToCache = [
  '/',
  '/offline.html'
];

// Check if the response is available and status is OK
const checkResponse = function (request) {
  return new Promise(function (fulfill, reject) {
    fetch(request).then(function (response) {
      if (response.status !== 404) {
        fulfill(response);
      } else {
        reject();
      }
    }, reject);
  });
};

// Add response to cache
const addToCache = function (request) {
  return caches.open("offline").then(function (cache) {
    return fetch(request).then(function (response) {
      return cache.put(request, response);
    });
  });
};

// Return from cache or serve offline page if the resource is not found
const returnFromCache = function (request) {
  return caches.open("offline").then(function (cache) {
    return cache.match(request).then(function (matching) {
      // Check if the matching is not found, then fallback to offline page
      if (!matching) {
        return cache.match("offline.html");  // Only use offline.html for important routes or cached ones
      } else {
        return matching;
      }
    });
  });
};

self.addEventListener("fetch", function (event) {
  // Only allow cache fallback for the routes that are part of your app
  event.respondWith(
    checkResponse(event.request)
      .catch(function () {
        // Only return the offline page for specific routes
        return returnFromCache(event.request);
      })
  );

  // Cache non-HTTP requests, such as those for assets or API calls
  if (!event.request.url.startsWith('http')) {
    event.waitUntil(addToCache(event.request));
  }
});
