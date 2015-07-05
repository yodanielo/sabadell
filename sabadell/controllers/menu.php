<?php

class Cmenu extends application {

    function Cmenu() {
        $this->params = array();
        $this->_preparativos();
    }

    function index() {
        $this->load_html("", $this->params);
    }

    function _preparativos() {
        $db = $this->dbInstance();
        //el banner que cambia
        $this->params["banner"] = $db->loadObjectRow("select * from #_menus where id=1");
        //empresas sabadell - directorio de empresas
        $sql = "SELECT a.id, a.nombre_" . $_SESSION["lang"] . " as nombre, count(*) as conteo FROM sab_categorias a inner join sab_empresas b
                on a.id=b.idcategoria where a.estado=1 and b.lng='" . $_SESSION["lang"] . "' group by a.id,a.nombre_" . $_SESSION["lang"] . "";
        $this->params["categorias"] = $db->loadObjectList($sql);
        //texto introduccion
        $sql = "select * from sab_estatico where id=1";
        $this->params["textofooter"] = $db->loadObjectRow($sql);
    }

    function menu() {
        $db = $this->dbInstance();
        $params["sl"] = $this->loadLib("textlibs");
        //el banner que cambia
        $this->params["banner"] = $db->loadObjectRow("select * from #_menus where id=1");
        //empresas sabadell - directorio de empresas
        $sql = "SELECT a.id, a.nombre_" . $_SESSION["lang"] . " as nombre, count(*) as conteo FROM sab_categorias a inner join sab_empresas b
                on a.id=b.idcategoria  where a.estado=1 group by a.id,a.nombre_" . $_SESSION["lang"] . "";
        $params["categorias"] = $db->loadObjectList($sql);
        //ultimas empresas añadidas
        $sql = "select *,descripcion_" . $_SESSION["lang"] . " as descripcion from sab_empresas order by id desc limit 3";
        $params["ultempresas"] = $db->loadObjectList($sql);
        //texto introduccion
        $sql = "select * from sab_estatico where id=1";
        $this->params["textofooter"] = $db->loadObjectRow($sql);
        $this->load_html("menu.php", $params);
    }

}

?>
