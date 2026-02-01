// Service Worker to prevent browser showing cached JSON on back/forward navigation
self.addEventListener('fetch', function(event) {
    // Only intercept GET navigation requests (back/forward)
    if (event.request.mode === 'navigate' && event.request.method === 'GET') {
        event.respondWith(
            fetch(event.request, {
                headers: { 'Accept': 'text/html' }
            }).then(function(response) {
                // If redirected, let browser handle it naturally
                if (response.redirected) {
                    return Response.redirect(response.url, 302);
                }
                return response;
            }).catch(function() {
                // Network error, try original request
                return fetch(event.request);
            })
        );
    }
});

// Force update: activate new service worker immediately
self.addEventListener('install', function(event) {
    self.skipWaiting();
});

self.addEventListener('activate', function(event) {
    event.waitUntil(clients.claim());
});
