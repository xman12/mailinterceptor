<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700&display=swap&subset=cyrillic-ext" rel="stylesheet">

    <title>Главная</title>
    <meta name="description" lang="ru" content="@yield('description')" />
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

</head>
<body>

    @php
    /**
    * @var \MailInterceptor\DTO\MailDTO[] $mails
    */
    @endphp
    @foreach($mails as $key => $mail)
        <p>Message Id: {{ $mail->getHeaders()->getMessageId() }}</p>
        <p>Когда: {{ $mail->getHeaders()->getDate() }}</p>
        <p>Кому: {{ $mail->getHeaders()->getTo() }}</p>
        <p>Тема: {{ $mail->getHeaders()->getSubject() }}</p>
        <p>От кого: {{ $mail->getHeaders()->getFrom() }}</p>
        <p>MIME-Version: {{ $mail->getHeaders()->getMimeVersion() }}</p>
        <p>Content-Type: {{ $mail->getHeaders()->getContentType() }}</p>
        <p>Content-Transfer-Encoding: {{ $mail->getHeaders()->getContentTransferEncoding() }}</p>

        <iframe src="{{ route('mailinterceptor.view', ['id' => $key]) }}" class="iPhoneX"></iframe>
        <iframe src="{{ route('mailinterceptor.view', ['id' => $key]) }}" class="IPad"></iframe>
        <iframe src="{{ route('mailinterceptor.view', ['id' => $key]) }}" class="pc"></iframe>
    @endforeach

    <style>
        .iPhoneX {
            width: 375px;
            height: 812px;
            transform-origin: 0 0;
            transform: scale(0.67);
        }

        .IPad {
            width: 768px;
            height: 1024px;
            transform-origin: 0 0;
            transform: scale(0.67);
        }

        .pc {
            width: 1200px;
            height: 1600px;
            transform-origin: 0 0;
            transform: scale(0.67);
        }

    </style>

</body>
</html>
