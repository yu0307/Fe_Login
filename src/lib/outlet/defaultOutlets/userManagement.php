<?php

namespace feiron\fe_login\lib\outlet\defaultOutlets;

use feiron\fe_login\lib\outlet\feOutlet;

class userManagement extends feOutlet
{
    public function __construct()
    {
        // $this->resource = '';
        // $this->callback = '';        
        $this->setName('fe_userManagement');
        $this->setView(view('fe_login::outletViews.userManagement'));
        $this->setResource('/feiron/fe_login/js/Fe_Login_usrManager.js');
        $this->setResource('/feiron/fe_login/css/Fe_Login_usrMnager_ui.css');
        return $this;
    }
}

?>