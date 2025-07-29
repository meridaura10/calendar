1. composer install
2. npm install
3. перевести .env.example в .env
4. створити базу данних в mysql з назвою events
5. php artisan migrate --seed

php artisan serve && npm run dev
можна запустити вже але для налаштувань телеграм бота та черг треба виконати настпуні кроки 

Налаштування телеграм бота
1. запустити ngrok
   ngrok config add-authtoken {$token}
   ngrok http 8000
   в env вказати APP_URL={url} url - це шлях до сайту через ngrok знаходиться навпроти поля Forwarding 
2. налаштувати telegraph 
   створити телеграм бота в базі данних та вказати ключ нище php artisan telegraph:new-bot
   першим параметром вказати ключ від телеграм бота --- 7541719230:AAFR5Tg96MsSbJO_sd3zMCreuc_uugiumlc
   далі можна все вказувати як no
   запустити webhook - php artisan telegraph:set-webhook треба вказувати після перезапуску ngrok і пер цим змінювати в env APP_URL на новий 
3. php artisan serve --port=8000 && npm run dev 
4. запустити черги
   php artisan schedule:work
   php artisan queue:work 
   email відправляються в log

зайти на сайт можна за параметрами 

email: admin@gmail.com
password: admin

вас виконаня 3 дні приблизно 20 години
