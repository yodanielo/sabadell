<?php
class application extends object {
    function application() {
    }
    function load_html($view,$params=array()) {
        //pasarle los parametros por defecto para estilos y scripts
        $defecto["scripts"]=array(
            "jquery-1.4.4.min.js",
        );
        $defecto["css"]=array(
        );
        //print_r($defecto);
        $params=$this->mergeVars($defecto, $params);
        $this->loadView("header.php", $params);
        if($view)
            $this->loadView($view, $params);
        $this->loadView("footer.php", $params);
    }
}
?>
