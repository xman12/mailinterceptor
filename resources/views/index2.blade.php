@php
    /**
     * @var \MailInterceptor\DTO\MailDTO[] $mails
    *  @var \MailInterceptor\DTO\MailDTO $selectedMail
    *  @var int $id
    */
@endphp

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Xman12 MailInterceptor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }

        .sidebar-nav {
            padding: 9px 0;
        }
    </style>
    <link href="{{ asset('css/bootstrap-responsive.css') }}" rel="stylesheet">
</head>

<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">MailInterceptor</a>
            <div class="nav-collapse">
                <p class="navbar-text pull-right">#</p>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header">Входящие</li>
                    @foreach($mails as $key => $mail)
                        <li @if($id === $key) class="active" @endif><a href="{{ route('mailinterceptor.index', ['id' => $key]) }}">{{ $mail->getHeaders()->getSubject() }}</a></li>
                    @endforeach
                </ul>
            </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
            <div class="hero-unit">
                <p>Message Id: {{ $selectedMail->getHeaders()->getMessageId() }}</p>
                <p>Когда: {{ $selectedMail->getHeaders()->getDate() }}</p>
                <p>Кому: {{ $selectedMail->getHeaders()->getTo() }}</p>
                <p>Тема: {{ $selectedMail->getHeaders()->getSubject() }}</p>
                <p>От кого: {{ $selectedMail->getHeaders()->getFrom() }}</p>
                <p>MIME-Version: {{ $selectedMail->getHeaders()->getMimeVersion() }}</p>
                <p>Content-Type: {{ $selectedMail->getHeaders()->getContentType() }}</p>
                <p>Content-Transfer-Encoding: {{ $selectedMail->getHeaders()->getContentTransferEncoding() }}</p>{{--                <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>--}}
            </div>
            <div class="row-fluid text-center">
                <div class="span4"><button class="btn btn-primary" onclick="showView('view-mob')">мобила</button></div>
                <div class="span4"><button class="btn btn-info" onclick="showView('view-table')">планшет</button></div>
                <div class="span4"><button class="btn btn-success" onclick="showView('view-pc')">Комп</button></div>

                <br/>
                <div class="span12" style="margin-top: 50px">

                    <iframe src="{{ route('mailinterceptor.view', ['id' => $id]) }}" class="iPhoneX text-center" id="view-mob"></iframe>
                    <iframe src="{{ route('mailinterceptor.view', ['id' => $id]) }}" class="IPad text-center" style="display: none" id="view-table"></iframe>
                    <iframe src="{{ route('mailinterceptor.view', ['id' => $id]) }}" class="pc text-center" style="display: none" id="view-pc"></iframe>

                </div>
            </div><!--/row-->
        </div><!--/span-->
    </div><!--/row-->

    <hr>

    <footer>
        <p>&copy; Company 2012</p>
    </footer>

</div><!--/.fluid-container-->

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap-alert.js') }}"></script>
<script src="{{ asset('js/bootstrap-modal.js') }}"></script>
<script src="{{ asset('js/bootstrap-dropdown.js') }}"></script>
<script src="{{ asset('js/bootstrap-scrollspy.js') }}"></script>
<script src="{{ asset('js/bootstrap-tab.js') }}"></script>
<script src="{{ asset('js/bootstrap-tooltip.js') }}"></script>
<script src="{{ asset('js/bootstrap-popover.js') }}"></script>
<script src="{{ asset('js/bootstrap-button.js') }}"></script>
<script src="{{ asset('js/bootstrap-collapse.js') }}"></script>

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

<script>
    function showView(id)
    {
        if ('view-mob' === id) {
            $('#'+id).show();
            $('#view-pc').hide();
            $('#view-table').hide();
        }

        if ('view-pc' === id) {
            $('#'+id).show();
            $('#view-mob').hide();
            $('#view-table').hide();
        }

        if ('view-table' === id) {
            $('#'+id).show();
            $('#view-mob').hide();
            $('#view-pc').hide();
        }
    }

</script>

</body>
</html>
