@php
    /**
     * @var \MailInterceptor\DTO\MailDTO[] $mails
    *  @var \MailInterceptor\DTO\MailDTO $selectedMail
    *  @var int $id
    */
use Illuminate\Support\Carbon;

$date = Carbon::parse($selectedMail->getTime());
@endphp
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
            href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"
            rel="stylesheet"
    />
    <link
            href="https://fonts.googleapis.com/icon?family=Material+Icons"
            rel="stylesheet"
    />
    <link href="{{ asset('css/bootstrap.min.css') }}"
          rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous"
    >
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<div class="wrapper vh-100">
    <div class="aside">
        <div class="aside-header pt-3 pb-2 px-2">
            <div class="logo-wrap pt-0 pb-2 px-2">
                <img src="{{ asset('img/logo.png') }}" alt="logo"/>
            </div>
            <div class="title-wrap py-1 px-2">
                <h5 class="aside-title m-0">Входящие</h5>
            </div>
        </div>
        <div class="aside-content">
            @foreach($mails as $key => $mail)
                <div class="message-wrap pt-2 pb-1 px-3 @if($id === $key) active-message @endif">
                    <div class="message">
                        <p id="mail_id_{{ $key }}" class="message-title bodyM m-0">
                            {{ $mail->getHeaders()->getSubject() }}
                        </p>
                        <div
                                class="black50 d-flex justify-content-between align-items-end"
                        >
                            <div>
                                <p class="message-email bodyS mb-1">{{ $mail->getHeaders()->getFrom() }}</p>
                            </div>
                            <div>
                                <p class="message-time captionS m-0">{{ $date->format('Y-m-d H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <div class="d-flex flex-column vh-100">
        <div class="header position-relative">
            <div class="header-inner py-3 pe-3 ps-4">
                <div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="message-details">
                                <div>
                                    <p
                                            class="sender-email bodyM m-0 text-white d-inline-block me-2"
                                    >
                                        {{ $selectedMail->getHeaders()->getFrom() }}
                                    </p>
                                    <p class="message-data bodyM m-0 white60 d-inline-block">
                                        <span class="message-day">{{ $date->format('d') }}</span>
                                        <span class="message-month">{{ $date->format('M') }}</span>
                                        <span class="message-year">{{ $date->format('Y') }}</span> в
                                        <span class="message-hour">{{ $date->format('H') }}</span>:<span class="message-minute">{{ $date->format('i') }}</span
                                        >
                                    </p>
                                </div>
                            </div>
                            <h3 class="title text-white m-0">
                                {{ $selectedMail->getHeaders()->getSubject() }}
                            </h3>
                        </div>
                        <div class="menu d-flex position-absolute">
{{--                            <div class="cursor-pointer">--}}
{{--                                <span class="material-icons white50">forward</span>--}}
{{--                            </div>--}}
                            <div class="cursor-pointer">
                                <span class="material-icons white50" onclick="deleteMail()">delete</span>
                            </div>
                            <div class="cursor-pointer">
                                <span class="material-icons white50">more_horiz</span>
                            </div>
                        </div>
                    </div>
                    <div class="accordion d-inline-block h-auto" id="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button
                                        class="accordion-button p-0"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne"
                                        aria-expanded="true"
                                        aria-controls="collapseOne"
                                >
                                    <div class="recipient-wrap">
                                        <div class="d-inline-block">
                                            <p class="d-inline-block bodyM white60 m-0">Получатель</p>
                                            <p class="recipient-email d-inline-block bodyM white60 m-0">
                                                {{ $selectedMail->getHeaders()->getTo() }}
                                            </p>
                                            <div class="expand-circle-down-wrap d-inline-block m-2 ms-1 mb-0">
                          <span
                                  class="expand-circle-down material-icons white50 align-middle"
                          >expand_circle_down</span
                          >
                                            </div>
                                        </div>
                                </button>
                            </h2>
                            <div
                                    id="collapseOne"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample"
                            >
                                <div class="accordion-body p-0 pt-1">
                                    <p class="bodyS white60 m-0">Message Id: {{ $selectedMail->getHeaders()->getMessageId() }}</p>
                                    <p class="bodyS white60 m-0">MIME-Version: {{ $selectedMail->getHeaders()->getMimeVersion() }}</p>
                                    <p class="bodyS white60 m-0">Content-Type: {{ $selectedMail->getHeaders()->getContentType() }}</p>
                                    <p class="bodyS white60 m-0">Content-Transfer-Encoding: {{ $selectedMail->getHeaders()->getContentTransferEncoding() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-wrap">
                <div class="nav">
                    <ul class="bodyM white60 d-flex m-0 p-0">
                        <li id="html" class="nav-item d-inline-block px-4 py-3 active-nav">HTML</li>
                        <li id="html-source" class="nav-item d-inline-block px-4 py-3">
                            HTML Source
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main p-3">
            <div id="html-content" class="content p-3">
                <div style="text-align: center; margin-left: 100px">
                    <iframe src="{{ route('mailinterceptor.view', ['id' => $id]) }}" class="iPhoneX"
                            style="display: none" id="view-mob"></iframe>
                </div>
                <div style="text-align: center;margin-left: 100px">
                    <iframe src="{{ route('mailinterceptor.view', ['id' => $id]) }}" class="IPad" style="display: none"
                            id="view-table"></iframe>
                </div>
                <div style="text-align: center;margin-left: 100px">
                    <iframe src="{{ route('mailinterceptor.view', ['id' => $id]) }}" class="pc" id="view-pc"></iframe>
                </div>
            </div>

            <div id="html-content-source" class="content p-3" style="display: none">
                {{ $selectedMail->getBody() }}
            </div>

        </div>
    </div>
    <div class="tab-group-wrap m-4 position-fixed bottom-0 end-0">
        <div class="tab-group">
            <div id="show-desktop"
                 class="tab bodyM py-2 px-3 d-inline-block white60 radius-4-top-left radius-4-bottom-left active-tab">
                Desktop
            </div>
            <div id="show-mob" class="tab bodyM py-2 px-3 d-inline-block white60">Mobile</div>
            <div id="show-tablet"
                 class="tab bodyM py-2 px-3 d-inline-block white60 radius-4-top-right radius-4-bottom-right">
                Tablet
            </div>
        </div>
    </div>
</div>

</body>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>

<script>
    function showView(id) {
        if ('view-mob' === id) {
            $('#' + id).show();
            $('#view-pc').hide();
            $('#view-table').hide();
        }

        if ('view-pc' === id) {
            $('#' + id).show();
            $('#view-mob').hide();
            $('#view-table').hide();
        }

        if ('view-table' === id) {
            $('#' + id).show();
            $('#view-mob').hide();
            $('#view-pc').hide();
        }
    }

    function showContent(id) {

        if ('html-content' === id) {
            $('#' + id).show();
            $('#html-content-source').hide();

        }

        if ('html-content-source' === id) {
            $('#' + id).show();
            $('#html-content').hide();
        }
    }

    function deleteMail()
    {
        if (confirm('Удалить')) {
            window.location.href = "{{ route('mailinterceptor.mail.delete', ['id' => $id])}}"
        }
    }


    function toggleActiveClass(arr, className) {
        for (const item of arr) {
            item.onclick = (data) => {
                const mask = 'mail_id_';
                const id = data.target.id;
                const rExp = new RegExp(mask);
                const thisRegex = new RegExp(mask);

                if(thisRegex.test(id)){
                    const idClear = id.replace(rExp, '');
                    window.location.href = "{{ route('mailinterceptor.index')}}?id="+idClear;
                }

                if ('show-desktop' === data.target.id) {
                    showView('view-pc');
                }

                if ('show-mob' === data.target.id) {
                    showView('view-mob');
                }

                if ('show-tablet' === data.target.id) {
                    showView('view-table');
                }

                if ('html' === data.target.id) {
                    showContent('html-content')
                }

                if ('html-source' === data.target.id) {
                    showContent('html-content-source')
                }

                for (const k of arr) {
                    k.classList.remove(className);
                }
                item.classList.add(className);
            };
        }
    }

    // ===== active tab =====

    const tabs = document.querySelectorAll(".tab");
    toggleActiveClass(tabs, "active-tab");

    // ===== active message =====

    const messages = document.querySelectorAll(".message-wrap");
    toggleActiveClass(messages, "active-message");

    // ===== active nav =====

    const nav = document.querySelectorAll(".nav-item");
    toggleActiveClass(nav, "active-nav");

    // ===== rotate arrow =====

    const accordionArrow = document.querySelector(".expand-circle-down-wrap");
    const accordion = document.querySelector(".accordion");

    accordion.onclick = () => {
        accordionArrow.classList.toggle("accordionShow");
    };


</script>

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

</html>
