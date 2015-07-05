<?php
/**
 * database settings
 */
$cfg["database"]["user"]="db78004_0prg9";
$cfg["database"]["password"]="0dDsrrll9";
$cfg["database"]["database"]="db78004_dbddesarrollo";
$cfg["database"]["server"]="internal-db.s78004.gridserver.com";
$cfg["database"]["prefix"]="sab_";
/**
 * site settings
 */
$cfg["site"]["indexfile"]="index.php";//el index del sitio
$cfg["site"]["useFriendlyUrl"]=false;//determina si se usan urls amigables, poner un .htaccess para habilitar esta opcion
$cfg["site"]["livesite"]="http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["SCRIPT_NAME"]);//no tocar
$cfg["site"]["charset"]="utf-8";//el charset
$cfg["site"]["permitted_uri_chars"]="a-z 0-9~%.:_\-";//caracteres permitidos para las url amigables
$cfg["site"]["sitename"]="E-Sabadell";//nombre del site
$cfg["site"]["sitedescription"]="Sabadell";
$cfg["site"]["keywords"]="Sabadell";
$cfg["site"]["author"]="EdMultimedia";
$cfg["site"]["owner"]="Sabadell";
/**
 * system settings
 */
$cfg["system"]["default_controller"]="menu";
$cfg["system"]["default_method"]="index";
$cfg["system"]["default_module"]="index";
/**
 * Boot settings
 */
$cfg["boot"][1]="modules";
$cfg["boot"][0]="classes";
?>
