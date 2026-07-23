// sw.js

// Название кеша (меняйте при обновлении)
const CACHE_NAME = 'alicecafe-v5';

const FILES = [
  '/alicecafe/',
  '/alicecafe/index.html',
  '/alicecafe/contacts.html',
  '/alicecafe/bron.html',
  '/alicecafe/manifest.json',
  '/alicecafe/style.css',
  '/alicecafe/images/bunny.jpg',
  '/alicecafe/images/bg.png',
  '/alicecafe/images/bun2.jpg',
  '/alicecafe/images/bun3.jpg',
  '/alicecafe/images/bun4.jpg',
  '/alicecafe/images/bun5.jpg',
  '/alicecafe/images/bun6.jpg',
  '/alicecafe/images/bun7.jpg',
  '/alicecafe/images/bun9.jpg',
  '/alicecafe/images/bun10.jpg',
  '/alicecafe/images/cute.png'
];

self.addEventListener('install', e => {
  e.waitUntil(caches.open(CACHE_NAME).then(c => c.addAll(FILES)));
});

self.addEventListener('activate', e => {
  e.waitUntil(
    caches.keys().then(keys => Promise.all(
      keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k))
    ))
  );
});

self.addEventListener('fetch', e => {
  e.respondWith(
    caches.match(e.request).then(r => r || fetch(e.request))
  );
});