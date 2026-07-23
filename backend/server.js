const webPush = require('web-push');
const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
require('dotenv').config();

const app = express();
app.use(cors());
app.use(bodyParser.json());

// ⚠️ Сгенерируйте свои VAPID ключи и замените их здесь!
// Запустите: npx web-push generate-vapid-keys --json
const vapidKeys = {
  publicKey:"BGxgA4tieXQF5V0NgCrrWxOAMmcrJm-ENN4wMjCpq7Gr7Sbq-5-yE_HQCTD2rYnedpsEF9tJs7P5_wS2riFoTQg",
  privateKey:"5jw1x5lga4RfFqf9SHotc7N6nfGySEhpoMawM1tkm6s"}

webPush.setVapidDetails(
  'mailto:alicecafe@mail.com',
  vapidKeys.publicKey,
  vapidKeys.privateKey
);

// Хранилище подписок (в продакшене используйте БД)
let subscriptions = [];

// Эндпоинт для подписки
app.post('/api/subscribe', (req, res) => {
  const subscription = req.body;
  
  const exists = subscriptions.some(s => s.endpoint === subscription.endpoint);
  if (!exists) {
    subscriptions.push(subscription);
    console.log('✅ Новая подписка:', subscription.endpoint);
  }
  
  res.status(201).json({ message: 'Подписка сохранена' });
});

// Эндпоинт для отписки
app.post('/api/unsubscribe', (req, res) => {
  const { endpoint } = req.body;
  subscriptions = subscriptions.filter(s => s.endpoint !== endpoint);
  console.log('🗑️ Подписка удалена');
  res.json({ message: 'Отписка выполнена' });
});

// Эндпоинт для отправки уведомления
app.post('/api/send-notification', (req, res) => {
  const { title, body, url } = req.body;
  
  const payload = JSON.stringify({
    title: title || 'AliceCafe',
    body: body || 'Новое уведомление!',
    url: url || '/alicecafe/'
  });
  
  const promises = subscriptions.map(subscription => {
    return webPush.sendNotification(subscription, payload)
      .catch(err => {
        console.error('❌ Ошибка отправки:', err);
        if (err.statusCode === 410 || err.statusCode === 404) {
          subscriptions = subscriptions.filter(s => s.endpoint !== subscription.endpoint);
        }
      });
  });
  
  Promise.all(promises).then(() => {
    res.json({ 
      message: `Уведомления отправлены ${subscriptions.length} подписчикам`,
      count: subscriptions.length 
    });
  });
});

// Получить количество подписчиков
app.get('/api/subscribers', (req, res) => {
  res.json({ count: subscriptions.length });
});

const PORT = process.env.PORT || 4000;
app.listen(PORT, () => {
  console.log(`🚀 Push-сервер запущен на порту ${PORT}`);
  console.log(`📋 Публичный VAPID ключ: ${vapidKeys.publicKey}`);
});