<?php

namespace feiron\fe_login\lib\view\components;

use Illuminate\View\Component;

class feUserManager extends Component
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
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('fe_login::components.feUserManager');
    }
}
