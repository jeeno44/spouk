@extends('layouts.frontend')

@section('title') EDU360 @endsection

@section('content')
    <div class="promo">
        <div class="promo__swiper swiper-container">
            <div class="swiper-wrapper">
                @foreach(\App\Models\Banner::all() as $banner)
                <a href="{{$banner->link}}" class="promo__item swiper-slide" style="background-image: url(/frontend/pic/slide_001.jpg)">
                    <div class="promo__content">
                        <h2 class="promo__title">{{$banner->name}}</h2>
                        <p>{{$banner->desc}}</p>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        @if(!Auth::check())
        <div class="promo__enter-wrap">
            <div class="promo__enter">
                <form action="/login" method="post">
                    {!! csrf_field() !!}
                    <input class="site__input" required type="email" name="email" placeholder="Ваш e-mail">
                    @if($errors->has('email'))<span class="text-red">{{$errors->first('email')}}</span>@endif
                    <input class="site__input" required type="password" name="password" placeholder="Пароль">
                    @if($errors->has('password'))<span class="text-red">{{$errors->first('password')}}</span>@endif
                    <div class="promo__enter-footer">
                        <div class="nice-checkbox">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Запомнить</label>
                        </div>
                        <button class="btn btn_3" type="submit"><span>ВОЙТИ</span></button>
                    </div>
                    <a href="/password/reset" class="promo__enter-restore">Восстановить пароль?</a>
                </form>
            </div>
        </div>
        @endif
    </div>
    <div class="tasks">
        <h2 class="site__title">Решаемые задачи</h2>
        <div class="tasks__wrap slides">
            <div class="tasks__item">
                <div class="tasks__pic">
                    <div class="tasks__animation"></div>
                    <img src="/frontend/img/tasks-pic01.png" alt="Icon">
                </div>
                Автоматизация образовательных процессов
            </div>
            <div class="tasks__item">
                <div class="tasks__pic">
                    <div class="tasks__animation"></div>
                    <img src="/frontend/img/tasks-pic02.png" alt="Icon">
                </div>
                Единое информационное пространство для всех участников
            </div>
            <div class="tasks__item">
                <div class="tasks__pic">
                    <div class="tasks__animation"></div>
                    <img src="/frontend/img/tasks-pic03.png" alt="Icon">
                </div>
                Автоматическое формирование приказов, отчетов и других документов
            </div>
            <div class="tasks__item">
                <div class="tasks__pic">
                    <div class="tasks__animation"></div>
                    <img src="/frontend/img/tasks-pic04.png" alt="Icon">
                </div>
                Автоматизация обмена данными с внешними системами
            </div>
        </div>
    </div>
    <div class="news slides">
        <div class="news__wrap">
            <h2 class="news__title">
                Новости
            </h2>
            <div class="news__items-wrap">
                @foreach(\App\Models\Article::take(4)->orderBy('date', 'desc')->get() as $new)
                <a href="/news/{{$new->slug}}" class="news__item">
                    <article>
                        <img src="/uploads/images/{{$new->image}}" alt="">
                        <p class="news__item-time">
                            <time datetime="2017-01-21">{{ruDateMonth($new->date)}} <span>/ {{date('Y', $new->date)}}</span></time>
                        </p>
                        <h3 class="news__item-title">
                            {{$new->name}}
                        </h3>
                        <p class="news__item-text">
                            {{$new->desc}}
                        </p>
                    </article>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="platform">
        <h2 class="site__title">Сегодня платформа – это...</h2>
        <div class="platform__item">
            <div class="platform__number">{{\App\Models\User::count()}}</div>
            Пользователей
        </div>
        <div class="platform__item">
            <div class="platform__number">{{DB::table('college_system')->where('system_id', 1)->count()}}</div>
            Колледжей
        </div>
        <div class="platform__item">
            <div class="platform__number">{{DB::table('college_system')->where('system_id', 2)->count()}}</div>
            Вузов
        </div>
        <div class="platform__item">
            <div class="platform__number">{{\App\Models\Region::count()}}</div>
            Регионов
        </div>
    </div>
    <div class="system">
        <div class="system__wrap">
            <p class="system__title">
                Что вы думаете по поводу новой системы управления
                образовательным процессом?
            </p>
            <a href="#" class="system__btn btn btn_2 popup__open" data-popup="question">
                 <span>
                    <svg>
                        <path fill-rule="evenodd" d="M3.355,12.821H2.366V11.638H1.183V10.648l0.841-.841L4.2,11.98ZM8.189,4.243a0.217,0.217,0,0,1-.065.157L3.115,9.41a0.216,0.216,0,0,1-.157.065,0.194,0.194,0,0,1-.2-0.2,0.217,0.217,0,0,1,.065-0.157L7.829,4.1a0.217,0.217,0,0,1,.157-0.065A0.194,0.194,0,0,1,8.189,4.243ZM7.69,2.468L0,10.159V14H3.845l7.691-7.691ZM14,3.355a1.229,1.229,0,0,0-.342-0.841L11.489,0.351A1.2,1.2,0,0,0,10.648,0a1.16,1.16,0,0,0-.832.351L8.282,1.876l3.845,3.845,1.534-1.534A1.19,1.19,0,0,0,14,3.355Z"/>
                        </svg>
                        написать отзыв
                    </span>
            </a>
        </div>
    </div>
    <div class="progress slides">
        <div class="progress__wrap">
            <div class="site__title">ПЛАНЫ РАЗВИТИЯ
                НА БЛИЖАЙШЕЕ БУДУЩЕЕ</div>
            <div class="progress__list">
                <div class="progress__item">
                    <div class="progress__item-title">
                        <h3>Сейчас</h3>
                        <span>Октябрь / 2016</span>
                    </div>
                    <p>
                        На данный момент уже существует личный кабинет, где вы можете вести учёт студентов,
                        загружать документы.
                    </p>

                </div>
                <div class="progress__item">
                    <div class="progress__item-title">
                        <h3>Январь</h3>
                        <span>2017</span>
                    </div>
                    <p>
                        На данный момент уже существует личный кабинет, где вы можете вести учёт студентов,
                        загружать документы.
                    </p>

                </div>
                <div class="progress__item">
                    <div class="progress__item-title">
                        <h3>Март</h3>
                        <span>2017</span>
                    </div>
                    <p>
                        На данный момент уже существует личный кабинет, где вы можете вести учёт студентов,
                        загружать документы.
                    </p>
                </div>
                <div class="progress__item">
                    <div class="progress__item-title">
                        <h3>Сентябрь</h3>
                        <span>2017</span>
                    </div>
                    <p>
                        На данный момент уже существует личный кабинет, где вы можете вести учёт студентов,
                        загружать документы.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection