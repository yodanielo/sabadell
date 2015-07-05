<?php
/**
 * la clase que inica la aplicación
 */
class start extends object {
    var $cfg;
    //overrides loadLib of Object class becouse it must be load libraries from the core
    function loadLib($class) {
        require(SYSTEM_PATH."/".$class.".php");
        $realclass=basename($class);
        $obj=new $realclass();
        return $obj;
    }
    function destripar() {
        $path='';
        // Is there a PATH_INFO variable?
        $path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');
        if($path=="") {
            // No PATH_INFO?... What about QUERY_STRING?
            $path =  (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');
            if($path=="") {
                // No QUERY_STRING?... Maybe the ORIG_PATH_INFO variable exists?
                $path = str_replace($_SERVER['SCRIPT_NAME'], '', (isset($_SERVER['ORIG_PATH_INFO'])) ? $_SERVER['ORIG_PATH_INFO'] : @getenv('ORIG_PATH_INFO'));
                if($path=="") {
                    // There is not tripas
                    $path = '';
                }
            }
        }
        return $path;
    }
    function bootClasses($tripas) {
        if(file_exists(CONTROLLERS."/".$tripas[1].".php")) {
            //first tripa is the class to call
            $x=$this->loadController($tripas[1]);
            if($x) {
                if($tripas[2]=="")
                    $tripas[2]=$this->cfg->item("system","default_method");
                if(method_exists($x,$tripas[2]) && substr($tripas[2],1)!="_") {
                    $params=array();
                    for($i=3;$i<count($tripas);$i++) {
                        array_push($params, $this->variable($tripas[$i],""));
                    }
                    call_user_func_array(array($x,$tripas[2]), $params);
                    return true;
                }
                else
                    die("Call to inexists method");
            }
            return true;
        }else {
            return false;
        }
    }
    function bootModules($tripas) {
        if(file_exists(MODULES)) {
            include(MODULES);
            $x=new modules();
            if(method_exists($x,$tripas[1])) {
                $params=array();
                for($i=2;$i<count($tripas);$i++)
                    $params[]=$tripas[$i];
                call_user_func_array(array($x,$tripas[1]), $params);
                return true;
            }else {
                return false;
            }
        }else{
            return false;
        }
    }
    function start($config_file) {
        //load configuration file
        $this->cfg=$this->loadLib("config");
        $this->cfg->loadFile($config_file);
        $_SESSION["config_file"]=$config_file;
        $path=$this->destripar();
        if($path=="/" || $path=="")
            $path="/".$this->cfg->item("system","default_controller");
        $tripas=explode("/",$path);
        $boot=$this->cfg->item("boot");
        $booted=false;
        for($i=0;$i<count($boot);$i++) {
            if($boot[$i]=="classes") {
                $booted=$this->bootClasses($tripas);
            }else {
                $booted=$this->bootModules($tripas);
            }
            if($booted==true){
                break;
            }
        }
    }
}
?>