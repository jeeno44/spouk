<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * Объект \App\Models\College текущего пользователя
     * @var College|null
     */
    protected $college = null;

    public $scripts = [];

    public $styles = [];

    /**
     * Подсистема образования
     * @var int
     */
    protected $educationSystemId;

    public function __construct()
    {
        if (\Auth::check()) {
            $this->college = College::find(\Auth::user()->college_id);
            \View::share('educationSystems', $this->college->systems);
            $paths = explode('.', \Request::getHost());
            switch ($paths[0]) {
                case 'vo':  $this->educationSystemId = 2; break;
                case 'spo': $this->educationSystemId = 1; break;
                default: $this->educationSystemId = 1;
            }
            \Session::set('educationSystemId', $this->educationSystemId);
            \View::share('educationSystemId', $this->educationSystemId);
            \View::share('scripts', $this->scripts);
            \View::share('styles', $this->styles);
        }
    }
}
