<?php

namespace App\View\Components;

use Illuminate\View\Component;

class modal extends Component
{
    public $id = "";
    public $title = "";
    public $onlyClose = false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $onlyClose = false)
    {
        $this->id = $id;
        $this->title = $title;
        $this->onlyClose = $onlyClose;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
