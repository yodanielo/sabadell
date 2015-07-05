<?php
class modules extends application{
    /**
     * cargas constantes en toda la navegacion
     */
    function _preparativos($id) {
        $db = $this->dbInstance();
        //el banner que cambia
        $this->params["banner"] = $db->loadObjectRow("select * from #_menus where id=$id");
        //empresas sabadell - directorio de empresas
        $sql = "SELECT a.id, a.nombre_" . $_SESSION["lang"] . " as nombre, count(*) as conteo FROM sab_categorias a inner join sab_empresas b
                on a.id=b.idcategoria where a.estado=1 and b.lng='".$_SESSION["lang"]."' group by a.id,a.nombre_" . $_SESSION["lang"] . "";
        $this->params["categorias"] = $db->loadObjectList($sql);
        //texto introduccion
        $sql="select * from sab_estatico where id=$id";
        $this->params["textofooter"]=$db->loadObjectRow($sql);
    }
    function informacion(){
        $this->_preparativos(2);
        $db=$this->dbInstance();
        $this->params["articulo"]=$db->loadObjectRow("select * from #_estatico where id=2");
        $this->load_html("estatico.php",$this->params);
    }
    function servicios(){
        $this->_preparativos(3);
        $db=$this->dbInstance();
        $this->params["articulo"]=$db->loadObjectRow("select * from #_estatico where id=3");
        $this->load_html("estatico.php",$this->params);
    }
    function contacto(){
        $this->_preparativos(4);
        $db=$this->dbInstance();
        $this->params["articulo"]=$db->loadObjectRow("select * from #_estatico where id=4");
        $this->load_html("estatico.php",$this->params);
    }
}
?>
