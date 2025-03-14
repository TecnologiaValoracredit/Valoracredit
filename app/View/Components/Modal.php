<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $id;
    public $title;
    public $size;
    public $btnSubmitId;

    public function __construct($id, $title, $size, $btnSubmitId = "btnModalSubmit")
    {
        $this->id = $id;
        $this->title = $title;
        $this->size = $size;
        $this->btnSubmitId = $btnSubmitId;
    }

    public function render()
    {
        return view('components.custom.modal');
    }
}