<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Панель управления</title>
    <meta name="description" content="OneUI - Admin Dashboard Template & UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
    <link rel="shortcut icon" href="/assets/admin/img/favicons/favicon.png">
    <link rel="icon" type="image/png" href="/assets/admin/img/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/assets/admin/img/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/assets/admin/img/favicons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/assets/admin/img/favicons/favicon-160x160.png" sizes="160x160">
    <link rel="icon" type="image/png" href="/assets/admin/img/favicons/favicon-192x192.png" sizes="192x192">
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/admin/img/favicons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/admin/img/favicons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/admin/img/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/admin/img/favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/admin/img/favicons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/admin/img/favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/admin/img/favicons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/admin/img/favicons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/admin/img/favicons/apple-touch-icon-180x180.png">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
    <link rel="stylesheet" href="/assets/admin/js/plugins/slick/slick.min.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/slick/slick-theme.min.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/summernote/summernote.min.css">
    <link rel="stylesheet" href="/assets/admin/js/plugins/summernote/summernote-bs3.min.css">
    <link rel="stylesheet" id="css-main" href="/assets/admin/css/oneui.css">
    <link rel="stylesheet" id="css-main" href="/assets/admin/js/plugins/datetime/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" id="css-main" href="/assets/admin/js/plugins/select2/select2.min.css">
</head>
<body>
<div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">
    <!-- Sidebar -->
    <nav id="sidebar">
        <!-- Sidebar Scroll Container -->
        <div id="sidebar-scroll">
            <!-- Sidebar Content -->
            <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
            <div class="sidebar-content">
                <!-- Side Header -->
                <div class="side-header side-content bg-white-op">
                    <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                    <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                        <i class="fa fa-times"></i>
                    </button>
                    <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
                    <div class="btn-group pull-right">
                        <button class="btn btn-link text-gray dropdown-toggle" data-toggle="dropdown" type="button">
                            <i class="si si-drop"></i>
                        </button>
                    </div>
                    <a class="h5 text-white" href="/admin">
                        <i class="fa fa-circle-o-notch text-primary"></i> <span class="h4 font-w600 sidebar-mini-hide">ne</span>
                    </a>
                </div>
                <!-- END Side Header -->

                <!-- Side Content -->
                <div class="side-content">
                    {!! widget('AdminLeftMenu') !!}
                </div>
                <!-- END Side Content -->
            </div>
            <!-- Sidebar Content -->
        </div>
        <!-- END Sidebar Scroll Container -->
    </nav>
    <!-- END Sidebar -->

    <!-- Header -->
    <header id="header-navbar" class="content-mini content-mini-full">
        <!-- Header Navigation Right -->
        <ul class="nav-header pull-right">
            <li>
                <div class="btn-group">
                    <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button">
                        <img src="/assets/admin/img/avatars/avatar10.jpg" alt="Avatar">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-header">Actions</li>
                        <li>
                            <a tabindex="-1" href="/">
                                <i class="si si-home pull-right"></i>На сайт
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="/logout">
                                <i class="si si-logout pull-right"></i>Выход
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
        <!-- END Header Navigation Right -->

        <!-- Header Navigation Left -->
        <ul class="nav-header pull-left">
            <li class="hidden-md hidden-lg">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
                    <i class="fa fa-navicon"></i>
                </button>
            </li>
            <li class="hidden-xs hidden-sm">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
            </li>
        </ul>
        <!-- END Header Navigation Left -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
        <div class="content">
            @yield('content')
        </div>

    </main>
    <!-- END Main Container -->
</div>
<!-- END Page Container -->

<!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
<script src="/assets/admin/js/core/jquery.min.js"></script>
<script src="/assets/admin/js/core/bootstrap.min.js"></script>
<script src="/assets/admin/js/core/jquery.slimscroll.min.js"></script>
<script src="/assets/admin/js/core/jquery.scrollLock.min.js"></script>
<script src="/assets/admin/js/core/jquery.appear.min.js"></script>
<script src="/assets/admin/js/core/jquery.countTo.min.js"></script>
<script src="/assets/admin/js/core/jquery.placeholder.min.js"></script>
<script src="/assets/admin/js/core/js.cookie.min.js"></script>
<script src="/assets/admin/js/plugins/summernote/summernote.min.js"></script>
<script src="/assets/admin/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/assets/admin/js/pages/base_forms_validation.js"></script>
<script src="/assets/admin/js/plugins/moment/moment-with-locales.min.js"></script>
<script src="/assets/admin/js/plugins/datetime/js/bootstrap-datetimepicker.min.js"></script>
<script src="/assets/admin/js/app.js"></script>
<script src="/assets/admin/js/plugins/slick/slick.min.js"></script>
<script src="/assets/admin/js/plugins/chartjs/Chart.min.js"></script>
<script src="/assets/admin/js/pages/base_pages_dashboard.js"></script>
<script src="/assets/admin/js/plugins/select2/select2.full.min.js"></script>
<script>
    $(function () {
        // Init page helpers (Slick Slider plugin)
        App.initHelpers('slick', 'datepicker');
        $(function () {
            $('#datetimepicker').datetimepicker();
            $('.datepicker').datetimepicker({locale: 'ru'});
            $('.select-event').change(function () {
                $(this).closest('form').submit();
            });
            $('.tags').select2({
                tags: true,
                language: "ru"
            });
            if ($('select[name=type]') != undefined) {
                if ($('select[name=type]').val() == 'Видео') {
                    $('.image-media').hide();
                    $('.video-media').show();
                } else {
                    $('.image-media').show();
                    $('.video-media').hide();
                }
            }
            $('.add-social').click(function (e) {
                $('.socials').append('<div class="row"><div class="col col-sm-8">' +
                    '<input class="form-control" name="socials[]" value="" placeholder="Ссылка" required></div>' +
                    '<div class="col col-sm-2">' +
                    '<button class="btn btn-sm btn-danger pull-right remove-social" type="button">Удалить</button>' +
                    '</div></div>');
                e.preventDefault();
            });
            $(document).on('click', '.remove-social', function () {
                $(this).closest('.row').remove();
            });
            $('.add-video').click(function (e) {
                $('.videos').append('<div class="row"><div class="col col-sm-8"><textarea class="form-control" ' +
                    'name="videos[]" placeholder="Код ролика" required rows="5"></textarea></div>' +
                    '<div class="col col-sm-2"><button class="btn btn-sm btn-danger pull-right ' +
                    'remove-video" type="button">Удалить</button></div></div>');
                e.preventDefault();
            });
            $(document).on('click', '.remove-video', function () {
                $(this).closest('.row').remove();
            });
            $('select[name=type]').change(function () {
                if ($('select[name=type]').val() == 'Видео') {
                    $('.image-media').hide();
                    $('.video-media').show();
                } else {
                    $('.image-media').show();
                    $('.video-media').hide();
                }
            });
            $('.add-row-1').click(function (e) {
                e.preventDefault();
                $('.rows-1').append('<div class="block-content row"><div class="col-sm-3"> \
                        <input type="text" class="form-control" name="years1[]" value="2016"></div> \
                        <div class="col-sm-3"> \
                        <select class="form-control valid" name="months1[]" aria-invalid="false"> \
                        <option value="1">Январь</option> \
                        <option value="2">Февраль</option> \
                        <option value="3">Март</option> \
                        <option value="4">Апрель</option> \
                        <option value="5">Май</option> \
                        <option value="6">Июнь</option> \
                        <option value="7">Июль</option> \
                        <option value="8">Август</option> \
                        <option value="9">Сентябрь</option> \
                        <option value="10">Октябрь</option> \
                        <option value="11">Ноябрь</option> \
                        <option value="12">Декабрь</option> \
                        </select> \
                        </div> \
                        <div class="col-sm-3"> \
                        <input type="text" class="form-control" name="values1[]" value="0"> \
                        </div> \
                        <div class="col-sm-3"> \
                        <button type="button" class="btn btn-default rem-row"><i class="fa fa-times"></i></button> \
                        </div> \
                        </div>');
            })

            $('.add-row-2').click(function (e) {
                e.preventDefault();
                $('.rows-2').append('<div class="block-content row"><div class="col-sm-3"> \
                        <input type="text" class="form-control" name="years2[]" value="2016"></div> \
                        <div class="col-sm-3"> \
                        <select class="form-control valid" name="months2[]" aria-invalid="false"> \
                        <option value="1">Январь</option> \
                        <option value="2">Февраль</option> \
                        <option value="3">Март</option> \
                        <option value="4">Апрель</option> \
                        <option value="5">Май</option> \
                        <option value="6">Июнь</option> \
                        <option value="7">Июль</option> \
                        <option value="8">Август</option> \
                        <option value="9">Сентябрь</option> \
                        <option value="10">Октябрь</option> \
                        <option value="11">Ноябрь</option> \
                        <option value="12">Декабрь</option> \
                        </select> \
                        </div> \
                        <div class="col-sm-3"> \
                        <input type="text" class="form-control" name="values2[]" value="0"> \
                        </div> \
                        <div class="col-sm-3"> \
                        <button type="button" class="btn btn-default rem-row"><i class="fa fa-times"></i></button> \
                        </div> \
                        </div>');
            })
        });
        $(document).on('click', '.rem-row', function () {
            $(this).closest('.row').remove();
        })
    });
</script>
</body>
</html>