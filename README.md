# MailInterceptor

Данный библиотека предназначена для отладки отправки email систем использующих
фреймворк Laravel.


## О библиотеке

Данная библиотека расширяет функционал фреймворка laravel, добавляет новый драйвер, который позволяет
сохранять отправляемые email сообщения в log базу в удобном формате и предоставляет маршрут, по которому их можно просматривать
в удобном представлении.

Чтобы посмотреть какие письма были отправлены, нужно перейти по адресу:
http://yourdomain/mailinterceptor

Данный адрес доступен только когда прописаны настройки APP_ENV=local

## Установка

- подключите библиотеку через composer 
```bash
composer require xman12/mailinterceptor
```
- пропишите настройки в .env: MAIL_INTERCEPTOR_LOG=mail-base.log (имя может быть любым) , MAIL_DRIVER=mailinterceptor
- добавьте в config/app.php в массив 'providers' след провайдеры:
  MailInterceptorRouteServiceProvider::class,
  MailInterceptorServiceProvider::class,
  AppMailInterceptorServiceProvider::class
- добавьте в config/logging.php в массив 'channels' след настройки:
```bash
  'mail_interceptor_log' => [
  'driver' => 'single',
  'path' => storage_path('logs/'. env('MAIL_INTERCEPTOR_LOG')),
  'level' => 'debug',
  ],
```
- добавьте в config/mail.php
```bash
  'mail_interceptor_log' => env('MAIL_INTERCEPTOR_LOG', 'mail.log'),
```


