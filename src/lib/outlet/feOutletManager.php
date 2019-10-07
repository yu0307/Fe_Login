<?php
namespace feiron\fe_login\lib\outlet;
use feiron\fe_login\lib\outlet\feOutletManagerContract;
use feiron\fe_login\lib\outlet\feOutletContract;
use feiron\fe_login\lib\outlet\feOutlet;
class feOutletManager implements feOutletManagerContract{

    private $OutletList;

    public function __construct(){
        //Outlets are array of arrays that when called will loop through and implement all in turn. 
        $this->OutletList=[];
        return $this;
    }

    public function FetchOutlet($outletName){
        return $this->OutletList[$outletName]??false;
    }

    public function registerOutlet($outletName){
        $this->OutletList[$outletName]=[];
        return $this;
    }

    public function getAvailableOutlets(){
        return array_keys($this->OutletList);
    }

    public function hasOutlet($outletName){
        return (array_key_exists($outletName,$this->OutletList));
    }

    public function bindOutlet($outletName, feOutletContract $outlet){
        $name= ($outlet->MyName()?? $outlet->setName(($outletName.'_'.count($this->OutletList[$outletName])+1))->MyName());
        $this->OutletList[$outletName][$name]=$outlet;
        return $outlet;
    }

    public function replaceOutlet($outletName, feOutletContract $outlet, $target=null){
        if(!empty($target) && array_key_exists($target,$this->OutletList[$outletName])){
            $this->OutletList[$outletName][$target]=$outlet;
        }else{
            $this->OutletList[$outletName]=[$outlet];
        }
        return $this;
    }

    public function removeOutlet($outletName, $target){
        if(array_key_exists($outletName, $this->OutletList) && array_key_exists($target, $this->OutletList[$outletName])){
            unset($this->OutletList[$outletName][$target]);
        }
        return $this;
    }

    public function CreateOulet($outletName,$outletParams){
        if(false===$this->hasOutlet($outletName)){
            $this->registerOutlet($outletName);
        }
        $this->bindOutlet($outletName, new feOutlet($outletParams));
        return $this;
    }

    public function OutletCalls($outletName){
        foreach($this->OutletList[$outletName] as $key=>$outlet){
            $outlet->CallOutlet();
        }
    }

    public function OutletResources($outletName,$target=false,$formater=null){
        $resources = [];
        if($target===fase){
            foreach($this->OutletList[$outletName] as $key=>$outlet){
                array_push($resources, $outlet->getResource());
            }
        }else{
            $resources= $this->OutletList[$outletName][$target];
        }
        return (is_callable($formater)? $formater($resources): $resources);
    }

    public function OutletRenders($outletName,$asObjects=true){
        $view= $asObjects?[]:'';
        foreach($this->OutletList[$outletName] as $key=>$outlet){
            if($asObjects){
                array_push($view, $outlet->getView());
            }else{
                $view .= $outlet->getView($asObjects)->render();
            }
        }
        return $view;
    }
}
