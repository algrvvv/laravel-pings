## О проекте

Небольшой проект на Laravel, который может пинговать 
нужные вам сервера в нужный промежуток времени 
(по дефолту каждую минуту)

## Установка

```shell

git clone https://github.com/algrvvv/laravel-pings.git

cd laravel-pings

cp .env.example .env
```

ВАЖНО! <br>

После создания `.env` файла измените данные для подключения к бд,
а так же добавьте данные для подключения `pusher`, чтобы обновление
данных о пингах производилась самостоятельно, без обновления страницы.

```dotenv
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=eu
```

Данные для подключения `pusher` можно получить после создания приложения
на их [официальном сайте](https://pusher.com/).

После подключения:

```shell
php artisan key:generate

composer install

npm install

php artisan migrate --seed

npm run dev

php artisan schedule:work

php artisan serve

```

## Что дальше?

После установки войдите в аккаунт `/login`

`login: test@example.com` <br>
`password: password` <br>

Или зарегистрируйте новый `/register`. На странице `/dashboard` вам будет
доступна таблица с информацией, а так же возможность добавить любой другой
домен.

