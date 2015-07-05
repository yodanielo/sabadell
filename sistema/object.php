<?php

//la clase base de todo el engranaje
class object {

    /**
     * funciones para validar variables
     */
    private function check($variable, $defecto, $html, $sql, $error) {
        $malo = false;
        if ($variable == null) {
            $variable = $defecto;
        }
        if (is_array($variable)) {
            foreach ($variable as $key => $value) {
                $variable[$key] = $this->check($value, $defecto, $html, $sql, $error);
            }
        } else {
            $variable = htmlentities($variable, ENT_QUOTES, 'ISO-8859-1');  // XSS PROTECTION
            if ($html) {
                $variable = htmlspecialchars($variable);
            }
            /* if($sql) {
              if($this->wordExists($variable)>0) {
              die("La pagina ha sido bloqueada por detectarse un intento de hacking.");
              }
              } */
        }
        return $variable;
    }

    private function loadClass($path, $pref, $class) {
        if (file_exists($path . "/" . $class . ".php")) {
            require $path . "/" . $class . ".php";
            $class = $pref . $class;
            $x = new $class();
            return $x;
        }else
            return null;
    }

    function get($variable, $defecto=null, $html=true, $sql=true, $error=true) {
        return $this->check($_GET[$variable], $defecto, $html, $sql, $error);
    }

    function post($variable, $defecto=null, $html=true, $sql=true, $error=true) {
        return $this->check($_POST[$variable], $defecto, $html, $sql, $error);
    }

    function session($variable, $defecto=null, $html=true, $sql=true, $error=true) {
        return $this->check($_SESSION[$variable], $defecto, $html, $sql, $error);
    }

    function variable($variable, $defecto=null, $html=true, $sql=true, $error=true) {
        return $this->check($variable, $defecto, $html, $sql, $error);
    }

    /**
     * functiones para arreglos
     */
    function mergeVars($defecto, $custom) {
        $total = array();
        $total = $defecto;
        if (count($custom) > 0)
            foreach ($custom as $key => $val) {
                if (is_array($val)) {
                    if (is_numeric($key)) {
                        $total[] = $this->mergeVars($defecto[$key], $custom[$key]);
                    } else {
                        $total[$key] = $this->mergeVars($defecto[$key], $custom[$key]);
                    }
                } else {
                    if (is_numeric($key)) {
                        $total[] = $val;
                    } else {
                        $total[$key] = $custom[$key];
                    }
                }
            }
        return $total;
    }

    function dbInstance() {
        $cfg = new config();
        $cfg->loadFile(CONFIG_PATH);
        $dbp = $cfg->item("database");
        require_once SYSTEM_PATH . '/database.php';
        $db = new database($dbp["server"], $dbp["user"], $dbp["password"], $dbp["database"], $dbp["prefix"]);
        return $db;
    }

    /**
     * funciones de vinculacion
     */
    function loadController($controller) {
        if (file_exists(CONTROLLERS . "/" . $controller . ".php")) {
            require CONTROLLERS . "/" . $controller . ".php";
            $controller = "C" . $controller;
            $x = new $controller();
            return $x;
        } else {
            die("Call to inexists controller");
            return null;
        }
    }

    function loadModel($model) {
        if (file_exists(MODELS . "/" . $model . ".php")) {
            require MODELS . "/" . $model . ".php";
            $model = "M" . $model;
            $x = new $model();
            return $x;
        } else {
            die("Call to inexists model");
            return null;
        }
    }

    function loadView($view, $params=array()) {
        $obj = new config();
        $obj->loadFile(CONFIG_PATH);
        $params = array_merge($params, $obj->item("site"));
        unset($obj);
        if (file_exists(VIEWS . "/" . $view) && is_file(VIEWS . "/" . $view)) {
            require VIEWS . "/" . $view;
        } else {
            die("Call to undefined view");
        }
    }

    function loadLib($lib) {
        $obj = $this->loadClass(LIBRARIES, "L", $lib);
        if ($obj)
            return $obj;
        else {
            $obj2 = $this->loadClass(SYSTEM_PATH, "", $lib);
            if ($obj2)
                return $obj2;
            else
                die("Library not recognized");
        }
        if (file_exists(LIBRARIES . $lib . ".php")) {
            require LIBRARIES . $lib . ".php";
            $lib = "L" . $lib;
            $x = new $lib();
            return $x;
        } else {
            die("Call to inexists library");
            return null;
        }
    }

    function getURL($url, $withIndex=true) {
        $c = new config();
        $c->loadFile(CONFIG_PATH);
        $livesite = $c->item("site", "livesite");
        if ($c->item("site", "useFriendlyUrl")) {
            //quiere decir que tiene url amigables
            return $livesite . "/" . $url;
        } else {
            if ($withIndex) {
                //there are no friendly URLs
                $index = $c->item("site", "indexfile");
                return $livesite . "/" . $index . $url;
            }else{
                //there are no friendly URLs but it don't include index
                $index = $c->item("site", "indexfile");
                return $livesite . $url;
            }
        }
    }

    function redirect($url) {
        header("location: " . $this->getURL($url));
    }

}

?>
