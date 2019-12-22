<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="/frontend/css/swiper.min.css">
    <link rel="stylesheet" href="/frontend/css/index.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css?1423393666" />
    <link rel="stylesheet" href="/frontend/css/custom.css">
</head>
<body>
<div class="site">
    <div class="site__header">
        <div class="site__header-layout">
            <a class="logo" href="/">
                <img src="/frontend/img/logo.png" alt="edu">
            </a>
            <div class="call-back">
                <a href="tel:+74953767676" class="call-back__phone">
                    <svg>
                        <path fill-rule="evenodd"  fill="rgb(255, 76, 91)" d="M13.775,18.003 C13.380,18.003 12.995,17.936 12.631,17.808 C6.753,15.725 2.098,10.940 0.179,5.006 C-0.278,3.598 0.206,2.049 1.381,1.151 L2.384,0.383 C3.319,-0.334 4.816,-0.007 5.365,1.062 L7.142,4.521 L7.176,4.841 C7.176,5.107 7.076,5.359 6.895,5.551 L6.549,5.927 C5.862,6.676 5.713,7.786 6.179,8.692 C6.871,10.040 7.950,11.120 9.299,11.814 C10.154,12.260 11.352,12.093 12.061,11.444 L12.446,11.089 C12.625,10.921 12.894,10.819 13.158,10.819 L13.329,10.819 L13.612,10.925 L16.920,12.629 C17.590,12.973 18.007,13.655 18.007,14.406 C18.007,14.931 17.801,15.429 17.429,15.805 L16.282,16.972 C15.635,17.627 14.722,18.003 13.775,18.003 Z"/>
                    </svg>
                    +7 (495) 376-76-76
                </a>
                @if(!Auth::check())
                    <a href="/register" class="btn btn_1">
                        <span>
                            <svg>
                                <path fill-rule="evenodd" d="M11.985,10.795 C11.985,8.884 11.534,5.949 9.040,5.949 C8.777,5.949 7.662,7.125 5.994,7.125 C4.326,7.125 3.211,5.949 2.947,5.949 C0.454,5.949 0.003,8.884 0.003,10.795 C0.003,12.166 0.922,12.986 2.275,12.986 L9.713,12.986 C11.066,12.986 11.985,12.166 11.985,10.795 ZM9.262,3.242 C9.262,1.449 7.798,-0.006 5.994,-0.006 C4.190,-0.006 2.726,1.449 2.726,3.242 C2.726,5.035 4.190,6.490 5.994,6.490 C7.798,6.490 9.262,5.035 9.262,3.242 Z"/>
                            </svg>
                            РЕГИСТРАЦИЯ
                        </span>
                    </a>
                @else
                    @if(!empty(Auth::user()->college) && !empty(Auth::user()->college->systems))
                        @if(Auth::user()->college->systems->count() == 1)
                            @if(Auth::user()->college->systems->first()->id == 1)
                                <a href="http://spo.{{config('app.domain')}}" class="btn btn_1">
                                <span>
                                    <svg>
                                        <path fill-rule="evenodd" d="M11.985,10.795 C11.985,8.884 11.534,5.949 9.040,5.949 C8.777,5.949 7.662,7.125 5.994,7.125 C4.326,7.125 3.211,5.949 2.947,5.949 C0.454,5.949 0.003,8.884 0.003,10.795 C0.003,12.166 0.922,12.986 2.275,12.986 L9.713,12.986 C11.066,12.986 11.985,12.166 11.985,10.795 ZM9.262,3.242 C9.262,1.449 7.798,-0.006 5.994,-0.006 C4.190,-0.006 2.726,1.449 2.726,3.242 C2.726,5.035 4.190,6.490 5.994,6.490 C7.798,6.490 9.262,5.035 9.262,3.242 Z"/>
                                    </svg>
                                    ЛИЧНЫЙ КАБИНЕТ
                                </span>
                                </a>
                            @else
                                <a href="http://vo.{{config('app.domain')}}" class="btn btn_1">
                                <span>
                                    <svg>
                                        <path fill-rule="evenodd" d="M11.985,10.795 C11.985,8.884 11.534,5.949 9.040,5.949 C8.777,5.949 7.662,7.125 5.994,7.125 C4.326,7.125 3.211,5.949 2.947,5.949 C0.454,5.949 0.003,8.884 0.003,10.795 C0.003,12.166 0.922,12.986 2.275,12.986 L9.713,12.986 C11.066,12.986 11.985,12.166 11.985,10.795 ZM9.262,3.242 C9.262,1.449 7.798,-0.006 5.994,-0.006 C4.190,-0.006 2.726,1.449 2.726,3.242 C2.726,5.035 4.190,6.490 5.994,6.490 C7.798,6.490 9.262,5.035 9.262,3.242 Z"/>
                                    </svg>
                                    ЛИЧНЫЙ КАБИНЕТ
                                </span>
                                </a>
                            @endif
                        @else
                            <a href="/sub-system" class="btn btn_1">
                                <span>
                                    <svg>
                                        <path fill-rule="evenodd" d="M11.985,10.795 C11.985,8.884 11.534,5.949 9.040,5.949 C8.777,5.949 7.662,7.125 5.994,7.125 C4.326,7.125 3.211,5.949 2.947,5.949 C0.454,5.949 0.003,8.884 0.003,10.795 C0.003,12.166 0.922,12.986 2.275,12.986 L9.713,12.986 C11.066,12.986 11.985,12.166 11.985,10.795 ZM9.262,3.242 C9.262,1.449 7.798,-0.006 5.994,-0.006 C4.190,-0.006 2.726,1.449 2.726,3.242 C2.726,5.035 4.190,6.490 5.994,6.490 C7.798,6.490 9.262,5.035 9.262,3.242 Z"/>
                                    </svg>
                                    ЛИЧНЫЙ КАБИНЕТ
                                </span>
                            </a>
                        @endif
                    @else
                    <a href="/logout" class="btn btn_1">
                        <span>
                            <svg>
                                <path fill-rule="evenodd" d="M11.985,10.795 C11.985,8.884 11.534,5.949 9.040,5.949 C8.777,5.949 7.662,7.125 5.994,7.125 C4.326,7.125 3.211,5.949 2.947,5.949 C0.454,5.949 0.003,8.884 0.003,10.795 C0.003,12.166 0.922,12.986 2.275,12.986 L9.713,12.986 C11.066,12.986 11.985,12.166 11.985,10.795 ZM9.262,3.242 C9.262,1.449 7.798,-0.006 5.994,-0.006 C4.190,-0.006 2.726,1.449 2.726,3.242 C2.726,5.035 4.190,6.490 5.994,6.490 C7.798,6.490 9.262,5.035 9.262,3.242 Z"/>
                            </svg>
                            ВЫХОД
                        </span>
                    </a>
                    @endif
                @endif
            </div>
            <nav class="menu">
                @foreach(\App\Models\Page::where('enabled', 1)->get() as $page)
                    <a href="/{{$page->slug}}" class="menu__item @if($page->slug == Request::path()) active @endif">{{$page->name}}</a>
                @endforeach
            </nav>
        </div>
    </div>
    @yield('content')
    <div class="site__footer">
        <div class="site__footer-wrap">
            <button class="site__footer-scroll" type="button"></button>
            <div class="site__footer-menu">
                @foreach(\App\Models\Page::where('enabled', 1)->get() as $page)
                    <a href="/{{$page->slug}}" class="@if($page->slug == Request::path()) active @endif">{{$page->name}}</a>
                @endforeach
            </div>
            <div class="site__footer-phone">
                <span></span>
                <a href="tel:+74953767676">+7 (495) 376-76-76</a>
            </div>
        </div>
    </div>
</div>
<div class="popup">
    <div class="popup__wrap">
        <div class="popup__content popup__question">
            <a href="#" class="popup__close"></a>
            <h2>Ваш отзыв или вопрос</h2>
            <p>Оставьте ваш вопрос или отзыв о работе платформы.</p>
            <p>На ваши вопросы мы ответим максимально оперативно</p>
            <form method="post" action="/feedback">
                {!! csrf_field() !!}
                <label>
                    <input type="text" name="name" required/>
                    <span>Ваше имя</span>
                </label>
                <label>
                    <input type="email" name="email" required/>
                    <span>e-mail</span>
                </label>
                <label>
                    <input type="text" name="message"/>
                    <span>Текст сообщения</span>
                </label>
                <div class="popup__btn-wrap">
                    <button type="submit" class="btn btn_4">ОТПРАВИТЬ</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/frontend/js/vendors/jquery-2.2.1.min.js"></script>
<script src="/frontend/js/vendors/swiper.jquery.min.js"></script>
<script src="/frontend/js/index.min.js"></script>
<script src="/assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="/frontend/js/custom.js"></script>
</body>
</html>
