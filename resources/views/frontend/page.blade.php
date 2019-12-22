@extends('layouts.frontend')

@section('title') {!! $page->title !!} @endsection

@section('content')
    {!! $page->content !!}
    @if($page->id == 5)
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
    @endif
@endsection