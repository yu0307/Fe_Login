<?php
namespace feiron\fe_login\lib\outlet;

interface feOutletContract{

    public function setCallback(callable $callback);

    public function CallOutlet();

    public function setResource($resource);

    public function getResource();

    public function setView(\Illuminate\View\View $view);

    public function getView($flush);

    public function setName($outletname);

    public function MyName():string;

}
