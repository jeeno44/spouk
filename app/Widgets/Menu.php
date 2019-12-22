<?php

namespace App\Widgets;

class Menu
{
    public function run()
    {
        $currentUri = \Request::path();
        $items = $this->build();
        return view('widgets.menu')->with(['items' => $items, 'currentUri' => $currentUri]);
    }

    function build()
    {

        $items = [];
        if (\Auth::user()->hasRole('principal') || \Auth::user()->hasRole('teacher')) {
            $items = $this->getMainMenu();
        } elseif (\Auth::user()->hasRole('teacher') && \Auth::user()->is_commission) {
            $items = $this->getTeacherMenu();
        } elseif (\Auth::user()->hasRole('analyst')) {
            $items = $this->getAnalystMenu();
        } elseif (\Auth::user()->hasRole('admin')) {
            $items = $this->getAdminMenu();
        }
        return $items;
    }

    function getAdminMenu()
    {
        return [
            ['title' => 'Справочники', 'icon' => 'fa fa-list', 'uri' => '/dic-type','child' => []],
        ];
    }

    function getAnalystMenu()
    {
        return [
            ['title' => 'Статистика', 'icon' => 'fa fa-table', 'uri' => '/statistics','child' => []],
            ['title' => 'Динамика абитуриентов', 'icon' => 'fa fa-line-chart', 'uri' => '/dynamics', 'child' => []]
        ];
    }

    function getTeacherMenu()
    {
        return [
            ['title' => 'Абитуриенты', 'icon' => 'fa fa-graduation-cap', 'uri' => '/enroll/candidates','child' => []],
            ['title' => 'Отчеты и справки', 'icon' => 'fa fa-file-excel-o', 'uri' => 'dec/reports', 'child' => []]
        ];
    }

    function getMainMenu()
    {

        $dictionaries = \App\Models\DictionaryType::getMenuDictionaries();
        $dictionaries = array_merge([
            ['title' => 'Специальности', 'icon' => '', 'uri' => 'dic/specializations'],
            ['title' => 'Школы', 'icon' => '', 'uri' => 'dic/schools'],
            ['title' => 'Курсы', 'icon' => '', 'uri' => 'dic/courses'],
            ['title' => 'Причины зачисления', 'icon' => '', 'uri' => 'dic/enrollment-reasons']],
            $dictionaries);
        $items[] = ['title' => 'Главная', 'icon' => 'fa fa-home', 'uri' => '/',
            'child' => []];
        if (\Session::get('educationSystemId') == 2) {
            if (\Auth::user()->hasRole('principal') || \Auth::user()->hasAccess('sd')) {
                $items[] = ['title' => 'Деканат', 'icon' => 'fa fa-cube', 'uri' => '#',
                    'child' => [
                        ['title' => 'Студенты', 'icon' => 'fa fa-graduation-cap', 'uri' => 'dec/students'],
                        ['title' => 'Движение контингента', 'icon' => '', 'uri' => 'dec/move-contingent'],
                        ['title' => 'Отчисление и выпуск', 'icon' => '', 'uri' => 'dec/output-contingent'],
                        ['title' => 'Приказы', 'icon' => '', 'uri' => 'dec/protocol'],
                        ['title' => 'Отчеты и справки', 'icon' => '', 'uri' => 'dec/reports'],
                        ['title' => 'Факультеты', 'icon' => 'fa fa-cube', 'uri' => 'dec/faculties'],
                        ['title' => 'Группы', 'icon' => 'fa fa-cube', 'uri' => 'dec/groups'],
                        ['title' => 'Выпускники', 'icon' => '', 'uri' => 'dec/output'],
                        ['title' => 'Отчисленные студенты', 'icon' => '', 'uri' => 'dec/deduct']]];
            }
            if (\Auth::user()->hasRole('principal')) {
                $items[] = ['title' => 'Справочники', 'icon' => 'fa fa-list', 'uri' => '#',
                    'child' => $dictionaries];
                $items[] = ['title' => 'ВУЗ', 'icon' => 'fa fa-university', 'uri' => '#',
                    'child' => [
                        ['title' => 'Данные вуза', 'icon' => 'fa fa-university', 'uri' => 'college'],
                        ['title' => 'Подразделения', 'icon' => 'fa fa-tasks', 'uri' => 'college/subdivisions'],
                        ['title' => 'Сотрудники', 'icon' => '', 'uri' => 'college/teachers'],
                        ]];
            }
        } else {
            if (\Auth::user()->hasRole('principal') || \Auth::user()->hasAccess('pk')) {
                $items[] = ['title' => 'Приемная комиссия', 'icon' => 'fa fa-pencil', 'uri' => '#',
                    'child' => [
                        ['title' => 'Абитуриенты', 'icon' => 'fa fa-graduation-cap', 'uri' => 'enroll/candidates'],
                        ['title' => 'Зачисление', 'icon' => 'fa fa-certificate', 'uri' => 'enroll'],
                        ['title' => 'Отчеты', 'icon' => 'fa fa-certificate', 'uri' => 'enroll/reports']]];
            }
            if (\Auth::user()->hasRole('principal') || \Auth::user()->hasAccess('sd')) {
                $items[] = ['title' => 'Деканат', 'icon' => 'fa fa-cube', 'uri' => '#',
                    'child' => [
                        ['title' => 'Студенты', 'icon' => 'fa fa-graduation-cap', 'uri' => 'dec/students'],
                        ['title' => 'Движение контингента', 'icon' => '', 'uri' => 'dec/move-contingent'],
                        ['title' => 'Отчисление и выпуск', 'icon' => '', 'uri' => 'dec/output-contingent'],
                        ['title' => 'Приказы', 'icon' => '', 'uri' => 'dec/protocol'],
                        ['title' => 'Отчеты и справки', 'icon' => '', 'uri' => 'dec/reports'],
                        ['title' => 'Группы', 'icon' => 'fa fa-cube', 'uri' => 'dec/groups'],
                        ['title' => 'Выпускники', 'icon' => '', 'uri' => 'dec/output'],
                        ['title' => 'Отчисленные студенты', 'icon' => '', 'uri' => 'dec/deduct']]];
            }
            $items[] = ['title' => 'Учебная часть', 'icon' => 'fa fa-book', 'uri' => '#', 'child' => $this->getUPItems()];
            if (\Auth::user()->hasRole('principal')) {
                $items[] = ['title' => 'Справочники', 'icon' => 'fa fa-list', 'uri' => '#',
                    'child' => $dictionaries];
                $items[] = ['title' => 'Колледж', 'icon' => 'fa fa-university', 'uri' => '#',
                    'child' => [
                        ['title' => 'Данные колледжа', 'icon' => 'fa fa-university', 'uri' => 'college'],
                        ['title' => 'Подразделения', 'icon' => 'fa fa-tasks', 'uri' => 'college/subdivisions'],
                        ['title' => 'Сотрудники', 'icon' => '', 'uri' => 'college/teachers'],
                        ['title' => 'События', 'icon' => '', 'uri' => 'college/events']]];
            }
        }
        return $items;
    }

    public function getUPItems()
    {
        if (\Auth::user()->hasRole('principal') || \Auth::user()->hasAccess('training')) {
            $items = [
                ['title' => 'Кафедры', 'icon' => '', 'uri' => '/training/pulpits'],
                ['title' => 'Дисциплины', 'icon' => '', 'uri' => '/training/disciplines'],
                ['title' => 'Компетенции', 'icon' => '', 'uri' => '/training/competences'],
                ['title' => 'Аудитории', 'icon' => '', 'uri' => '/training/halls'],
                ['title' => 'Учебные планы', 'icon' => '', 'uri' => '/training/plans'],
                ['title' => 'Отчеты', 'icon' => '', 'uri' => '/training/reports'],
                ['title' => 'Расписание', 'icon' => '', 'uri' => '/training/schedules'],
            ];
        } elseif (\Auth::user()->hasAccess('pulpit') || \Auth::user()->hasAccess('schedule')) {
            $items = [
                ['title' => 'Дисциплины', 'icon' => '', 'uri' => '/training/disciplines'],
                ['title' => 'Отчеты', 'icon' => '', 'uri' => '/training/reports'],
            ];
        } else {
            $items = [
                ['title' => 'Отчеты', 'icon' => '', 'uri' => '/training/reports'],
            ];
        }
        return $items;
    }
}