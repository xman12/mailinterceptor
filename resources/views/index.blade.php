@extends('layouts.base')

@section('title')Главная@endsection

@section('content')
    @php
    /**
    * @var \src\DTO\MailDTO[] $mails
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

        <iframe src="{{ route('view', ['id' => $key]) }}" class="iPhoneX"></iframe>
        <iframe src="{{ route('view', ['id' => $key]) }}" class="IPad"></iframe>
        <iframe src="{{ route('view', ['id' => $key]) }}" class="pc"></iframe>
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
@endsection
