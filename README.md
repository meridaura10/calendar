1. composer install
2. npm install
3. php artisan migrate --seed
4. перевести .env.example в .env

Налаштування телеграм бота
1. запустити ngrok
   ngrok config add-authtoken {$token}
   ngrok http 8000
   в env вказати APP_URL={url} url - це шлях до сайту через ngrok 
2. налаштувати telegraph 
   створити телеграм бота в базі данних та вказати ключ нище php artisan telegraph:new-bot
   першим параметром вказати ключ від телеграм бота --- 7541719230:AAFR5Tg96MsSbJO_sd3zMCreuc_uugiumlc
   запустити webhook - php artisan telegraph:set-webhook
3. запустити черги
   php artisan schedule:work
   php artisan queue:work

зайти на сайт можна за параметрами 

email: admin@gmail.com
password: admin
