// sw.js

// Название кеша (меняйте при обновлении)
const CACHE_NAME = 'my-pwa-v1';

// Список файлов, которые нужно кешировать
const FILES = [
  '/',
  '/main.html',
  '/manifest.json',
  '/style.css',
  '/bron.html',
  '/feedback.php',
  'icon.png',
  '/contacts.png',
  '/images/bg.png',
  '/images/bun2.jpg',
  '/images/bun3.jpg',
  '/images/bun4.jpg',
  '/images/bun5.jpg',
  '/images/bun6.jpg',
  '/images/bun7.jpg',
  '/images/bun9.jpg',
  '/images/bun10.jpg',
  '/images/bunny.jpg',
  '/images/cute.jpg',
];


const CACHE_NAME = 'alicecafe-v3';
const FILES = ['/', '/main.html', '/manifest.json'];

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