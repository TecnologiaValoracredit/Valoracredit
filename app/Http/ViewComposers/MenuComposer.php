<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Menu;

class MenuComposer
{
    public function compose(View $view)
    {
        $menus = Menu::orderBy('position', 'asc')->get();
        $view->with('menus', $menus);
    }
}