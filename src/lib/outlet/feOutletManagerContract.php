<?php
namespace feiron\fe_login\lib\outlet;

interface feOutletManagerContract{

    public function FetchOutlet($outletName);

    public function bindOutlet($outletName, \feiron\fe_login\lib\outlet\feOutletContract $outlet);

    public function replaceOutlet($outletName, \feiron\fe_login\lib\outlet\feOutletContract $outlet);

    public function removeOutlet($outletName,$target);

    public function hasOutlet($outletName);

    public function registerOutlet($outletName);

    public function getAvailableOutlets();

    public function OutletCalls($outletName);

    public function OutletResources($outletName);

    public function OutletRenders($outletName, $asObjects);
}

?>