<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>СПО</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/bootstrap.css?1422792965" />
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/materialadmin.css?1425466319" />
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/font-awesome.min.css?1422529194" />
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css?1423393666" />
    <link type="text/css" rel="stylesheet" href="/assets/css/custom.css" />
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}"><img src="/assets/img/logo.png"></a>
        </div>
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Вход</a></li>
                    <li><a href="{{ url('/register') }}">Регистрация</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->email }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выход</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@yield('content')
<script src="/assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="/assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script src="/assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/js/libs/bootstrap/bootstrap.min.js"></script>
<script src="/assets/js/libs/spin.js/spin.min.js"></script>
<script src="/assets/js/libs/autosize/jquery.autosize.min.js"></script>
<script src="/assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
<script src="/assets/js/libs/moment/moment.min.js"></script>
<script src="/assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/js/core/source/App.js"></script>
<script src="/assets/js/core/source/AppNavigation.js"></script>
<script src="/assets/js/core/source/AppOffcanvas.js"></script>
<script src="/assets/js/core/source/AppCard.js"></script>
<script src="/assets/js/core/source/AppForm.js"></script>
<script src="/assets/js/core/source/AppNavSearch.js"></script>
<script src="/assets/js/core/source/AppVendor.js"></script>
<script src="/assets/js/front.js"></script>
<script src="/assets/js/libs/inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="/assets/js/login.js"></script>
@if(URL::to('/') == 'http://cont-spo.ru')
    <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter38458945 = new Ya.Metrika({ id:38458945, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, ut:"noindex" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/38458945?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
@endif
</body>
</html>

