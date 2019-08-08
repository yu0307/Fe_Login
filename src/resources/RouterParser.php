<?php

namespace feiron\fe_login\resources;
use Illuminate\Http\Request;

trait RouterParser
{
    public function ParseTarget(Request $request){
        return session('target')?? (app('request')->input('target')??null);
    }
}
