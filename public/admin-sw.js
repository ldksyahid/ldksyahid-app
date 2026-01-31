// Service Worker to prevent browser showing cached JSON on back/forward navigation
self.addEventListener('fetch', function(event) {
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request.url, {
                method: 'GET',
                headers: { 'Accept': 'text/html' },
                redirect: 'follow'
            }).catch(function() {
                return caches.match(event.request);
            })
        );
    }
});
