<?php

namespace feiron\fe_login\lib\outlet\defaultOutlets;

use feiron\fe_login\lib\outlet\feOutlet;

class userCreation extends feOutlet
{
    public function __construct()
    {
        // $this->resource = '';
        // $this->callback = '';        
        $this->view = view('fe_login::outletViews.userCreation');
        $this->myName = 'fe_userCreation';
        return $this;
    }

}

?>