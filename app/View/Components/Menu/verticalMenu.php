<?php

namespace App\View\Components\Menu;

use Illuminate\View\Component;
use App\Models\Menu;

class verticalMenu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $menus = Menu::orderBy("position", "asc")->get();
        return view('components.menu.vertical-menu', compact("menus"));
    }
}
