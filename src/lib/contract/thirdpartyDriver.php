<?php

namespace feiron\fe_login\lib\contract;

use Illuminate\Http\Request;

interface thirdpartyDriver
{

    public function getName(): string;

    public function getEmail(): string;

    public function getID(): string;

    public function getDriverType(): string;

    public function handle(Request $request): thirdpartyDriver; // return false on error

    public function Login(Request $request);
}

?>