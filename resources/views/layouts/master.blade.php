<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - @if(Session::get('educationSystemId') == 2) ВО @else СПО @endif</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/bootstrap.css?1422792965" />
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/materialadmin.css?1425466319" />
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/font-awesome.min.css?1422529194" />
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css?1423393666" />
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/libs/select2/select2.css" />
    <link type="text/css" rel="stylesheet" href="/assets/css/custom.css" />
    <link type="text/css" rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css" />
    @foreach($styles as $style)
        <link type="text/css" rel="stylesheet" href="{!! $style !!}">
    @endforeach
    <style type="text/css">
        .cont{
            margin: 40px 10px;
            padding: 0;
            font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
            font-size: 14px;
        }
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
    <!--END Jquery Full Calendar-->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>
<body class="menubar-hoverable header-fixed menubar-pin">
<header id="header">
    <div class="headerbar">
        <div class="headerbar-left">
            <ul class="header-nav header-nav-options">
                <li class="header-nav-brand" >
                    <div class="brand-holder">
                        <a href="/">
                            <img src="/assets/img/logo.png">
                        </a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="headerbar-right">
            <ul class="header-nav header-nav-profile">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown" aria-expanded="false">
                        <img src="/assets/img/avatar1.jpg" alt=""><span class="profile-info">{{Auth::user()->first_name}} {{Auth::user()->last_name}}<small>{{Auth::user()->email}}</small>								</span>
                    </a>
                    <ul class="dropdown-menu animation-dock">
                        <li><a href="/profile"><i class="fa fa-fw fa-lock"></i> Профиль</a></li>
                        @if(!empty($educationSystems) && $educationSystems->count() > 1)
                            <li><a href="http://{{config('app.domain')}}/sub-system"><i class="fa fa-fw fa-exchange"></i> Выбрать подсистему</a></li>
                        @endif
                        <li><a href="http://{{config('app.domain')}}/logout"><i class="fa fa-fw fa-power-off text-danger"></i> Выход</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
<div id="base">
    <div id="content">
        @yield('content')
    </div>
    <div id="menubar" class="menubar-inverse">
        <div class="menubar-scroll-panel">
            {!! widget('Menu') !!}
        </div>
    </div>
</div>
<script src="/assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="/assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script src="/assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/js/libs/bootstrap/bootstrap.min.js"></script>
<script src="/assets/js/libs/spin.js/spin.min.js"></script>
<script src="/assets/js/libs/autosize/jquery.autosize.min.js"></script>
<script src="/assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
<script src="/assets/js/libs/moment/moment-with-langs.min.js"></script>
<script src="/assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/js/libs/select2/select2.min.js"></script>
<script src="/assets/js/core/source/App.js"></script>
<script src="/assets/js/core/source/AppNavigation.js"></script>
<script src="/assets/js/core/source/AppOffcanvas.js"></script>
<script src="/assets/js/core/source/AppCard.js"></script>
<script src="/assets/js/core/source/AppForm.js"></script>
<script src="/assets/js/core/source/AppNavSearch.js"></script>
<script src="/assets/js/core/source/AppVendor.js"></script>
<script src="/assets/js/libs/inputmask/jquery.inputmask.bundle.min.js"></script>
<!--Jquery Full Calendar-->

<script src="/assets/js/bootstrap-datetimepicker.min.js"></script>

<!-- END Jquery Full Calendar-->


<script src="/assets/js/app.js"></script>

@if (isset($controller) && ($controller == 'CandidatesController' || $controller == 'StudentsController'))
    <script type="text/javascript" src="/assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>
    <script type="text/javascript" src="/assets/js/libs/jquery-validation/dist/localization/messages_ru.js"></script>
    <script type="text/javascript" src="/assets/js/candidates.js"></script>
@endif

@if (isset($controller) && $controller == 'EnrollmentController')
    <script type="text/javascript" src="/assets/js/enroll.js"></script>
@endif

@if(URL::to('/') == 'https://cont-spo.ru')
    <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter38458945 = new Ya.Metrika({ id:38458945, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, ut:"noindex" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/38458945?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
@endif
@foreach($scripts as $script)
    <script src="{!! $script !!}"></script>
@endforeach
</body>
</html>
