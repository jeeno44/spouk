<?php

namespace App\Widgets;

class AdminLeftMenu
{
    public function run()
    {
        $currentUri = \Route::getCurrentRoute()->getPath();
        $items = $this->build();

        return view('admin.widgets.left_menu')
            ->with('adminMenuItems', $items)
            ->with('currentUri', $currentUri);
    }

    function build()
    {
        $items = [
            'Страницы' => [
                'icon'  => 'fa fa-file-o',
                'uri'   => 'admin/pages',
            ],
            'Новости' => [
                'icon'  => 'fa fa-newspaper-o',
                'uri'   => 'admin/articles',
            ],
            'Баннеры' => [
                'icon'  => 'fa fa-image',
                'uri'   => 'admin/banners',
            ],
            'Письма' => [
                'icon'  => 'fa fa-envelope',
                'uri'   => 'admin/letters',
            ],
        ];

        return $items;
    }
}