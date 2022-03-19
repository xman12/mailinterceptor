# MailInterceptor

Данный библиотека предназначена для отладки отправки email систем использующих
фреймворк Laravel.

## Установка

- подключите библиотеку через composer 
```bash
composer require xman12/mailinterceptor
```
- пропишите настройки в .env: MAIL_INTERCEPTOR_LOG=mail-base.log (имя может быть любым) , MAIL_DRIVER=mailinterceptor
- добавьте в app/config.php в массив 'providers' след провайдеры:
  MailInterceptorRouteServiceProvider::class,
  MailInterceptorServiceProvider::class,
  AppMailInterceptorServiceProvider::class
- добавьте в app/logging.php в массив 'channels' след настройки:
```bash
  'mail_interceptor_log' => [
  'driver' => 'single',
  'path' => storage_path('logs/'. env('MAIL_INTERCEPTOR_LOG')),
  'level' => 'debug',
  ],
```