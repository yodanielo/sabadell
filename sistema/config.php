<?php
class config extends object {
    var $vars;
    var $default;
    var $currentfile;
    function config() {
        $def["database"]["user"]="root";
        $def["database"]["password"]="";
        $def["database"]["database"]="DFW";
        $def["database"]["server"]="localhost";
        $def["database"]["prefix"]="db_";
        $def["site"]["useFriendlyUrl"]=false;
        $def["site"]["livesite"]="http://localhost";
        $def["site"]["charset"]="utf-8";
        $def["site"]["permitted_uri_chars"]="a-z 0-9~%.:_\-";
        $def["meta"]["sitename"]="DFW Site";
        $def["meta"]["sitedescription"]="DFW is a Lite Framework created to make more easy the programmers life implementing one front-end, one backend, and any subsites";
        $def["meta"]["keywords"]="DFW, DFW Framework, Framework";
        $def["meta"]["default_css"]="/css/nav.css";
        $def["meta"]["default_css_ie"]="/css/ie.css";
        $def["meta"]["default_script"]="/js/general.js";
        $def["system"]["default_controller"]="start";
        $def["system"]["default_method"]="index";
        $this->default=$def;
    }
    function loadFile($file,$extra_vars=null) {
        static $filesconfig;
        if(!isset($filesconfig))
            $filesconfig=array();
        $found=false;
        for($i=0;$i<count($filesconfig);$i++) {
            if($filesconfig[$i]["path"]==$file) {
                $found=true;
                if($extra_vars)
                    $filesconfig[$i]["cfg"]=array_merge($filesconfig[$i]["cfg"], $extra_vars);
                $this->vars=$filesconfig[$i]["cfg"];
            }
        }
        if(!$found) {
            if(file_exists($file)) {
                require_once $file;
                $this->vars=$this->mergeVars($this->default, $cfg);
                $this->currentfile=$file;
                if($extra_vars)
                    $this->vars=array_merge($this->vars, $extra_vars);
                $filesconfig[]=array("path"=>$file,"cfg"=>$cfg);
            }else{
                //if file is not found, system will display an error
                die("Config file is not Found");
                //$this->vars=$this->default;
            }
        }
    }
    function item($section,$var=null) {
        if($var==null)
            return $this->vars[$section];
        else
            return $this->vars[$section][$var];
    }
}
?>
