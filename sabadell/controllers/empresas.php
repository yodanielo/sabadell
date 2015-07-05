<?php

class Cempresas extends application {

    var $params;

    /**
     * constructor, ta,bien inicia los preparativos
     */
    function Cempresas() {
        $this->params = array();
        $this->_preparativos();
    }

    /**
     * recien voy a ver lo que se va cargar por defecto aqui
     */
    function index($id="") {
        /* if ($id == "") {
          $this->redirect("");
          } */
        //$this->load_html("", $this->params);
        $this->directorio("A");
    }

    /**
     * cargas constantes en toda la navegacion
     */
    function _preparativos() {
        $db = $this->dbInstance();
        //el banner que cambia
        $this->params["banner"] = $db->loadObjectRow("select * from #_menus where id=2");
        //empresas sabadell - directorio de empresas
        $sql = "SELECT a.id, a.nombre_" . $_SESSION["lang"] . " as nombre, count(*) as conteo FROM sab_categorias a inner join sab_empresas b
                on a.id=b.idcategoria where a.estado=1 and b.lng='".$_SESSION["lang"]."' group by a.id,a.nombre_" . $_SESSION["lang"] . "";
        $this->params["categorias"] = $db->loadObjectList($sql);
        //texto introduccion
        $sql="select * from sab_estatico where id=1";
        $this->params["textofooter"]=$db->loadObjectRow($sql);
    }

    /**
     * muestra el directorio de empresas de la A-Z
     * @param Char $id la letra que se va cargar
     */
    function directorio($id="") {
        if ($id == "") {
            $this->redirect("");
        } else {
            $this->params["sl"] = $this->loadLib("textlibs");
            $id = substr($id, 0, 1);
            $this->params["def"] = $id;
            $db = $this->dbInstance();
            $sql = "select *,descripcion_" . $_SESSION["lang"] . " as descripcion from #_empresas where lng='".$_SESSION["lang"]."' and nombre like '$id%'";
            $this->params["empresas"] = $db->loadObjectList($sql);
            //obtengo categorias
            $sql = "select *,
                nombre_" . $_SESSION["lang"] . " as nombre
                from sab_categorias where estado=1 order by nombre_" . $_SESSION["lang"] . "";
            $this->params["submenus"] = $db->loadObjectList($sql);
            $this->load_html("directorio.php", $this->params);
        }
    }

    /**
     * muestra las empresas por categoria
     * @param int $id el id de la categoria
     */
    function categorias($id="", $pactual=1) {
        if ($id == "") {
            $this->redirect("");
        } else {
            $this->params["pagactual"] = $pactual;
            $lib_1 = $this->loadLib("paginacion");
            $lib_2 = $this->loadLib("textlibs");
            $db = $this->dbInstance();
            $this->params["lib2"] = $lib_2;
            //obtengo el breadcrumb
            $sql = "select nombre_" . $_SESSION["lang"] . " as nombre from #_categorias where estado=1 and id=" . intval($id);
            $this->params["uno"] = $db->loadResult($sql);
            $this->params["idcat"] = $id;
            //obtengo empresas
            $sql = "select *,
                descripcion_" . $_SESSION["lang"] . " as descripcion from #_empresas where lng='".$_SESSION["lang"]."' and idcategoria=" . intval($id) . " order by nombre";
            $this->params["empresascuerpo"] = $lib_1->doPagination($db, $sql, 6, $this->params["pagactual"], $this->params["numpaginas"]);
            //google maps
            $sql = "select *,
                descripcion_" . $_SESSION["lang"] . " as descripcion from #_empresas where lng='".$_SESSION["lang"]."' and idcategoria=".intval($id)." order by nombre";
            $this->params["googlemaps"] = $db->loadObjectList($sql);
            //obtengo patrocinadores
            $sql = "select *,
                nombre,
                descripcion_" . $_SESSION["lang"] . " as descripcion
                from #_empresas where espatrocinador=1 and estado=1 and lng='".$_SESSION["lang"]."' and idcategoria=" . $id;
            $this->params["patros"] = $db->loadObjectList($sql);
            //obtengo categorias
            $sql = "select *,
                nombre_" . $_SESSION["lang"] . " as nombre
                from sab_categorias where estado=1 order by nombre_" . $_SESSION["lang"] . "";
            $this->params["submenus"] = $db->loadObjectList($sql);
            $this->params["scripts"] = array(
                "http://maps.google.com/maps/api/js?sensor=false"
            );
            $this->load_html("categorias.php", $this->params);
        }
    }

    function buscar() {
        $id = str_replace("'", "", $_GET["query"]);
        if ($id == "") {
            $this->redirect("");
        } else {
            $this->params["pagactual"] = $pactual;
            $lib_1 = $this->loadLib("paginacion");
            $lib_2 = $this->loadLib("textlibs");
            $db = $this->dbInstance();
            $this->params["lib2"] = $lib_2;
            //obtengo el breadcrumb
            $this->params["idcat"] = $id;
            //obtengo empresas
            $sql = "select *,
                descripcion_" . $_SESSION["lang"] . " as descripcion from #_empresas where lng='".$_SESSION["lang"]."' and nombre like '%" . $id . "%' order by nombre";
            $this->params["empresascuerpo"] = $lib_1->doPagination($db, $sql, 6, $this->params["pagactual"], $this->params["numpaginas"]);
            $sql = "select *,
                descripcion_" . $_SESSION["lang"] . " as descripcion from #_empresas where lng='".$_SESSION["lang"]."' order by nombre";
            $this->params["googlemaps"] = $db->loadObjectList($sql);
            //obtengo patrocinadores
            $sql = "select *,
                nombre,
                descripcion_" . $_SESSION["lang"] . " as descripcion
                from #_empresas where espatrocinador=1 and estado=1 and lng='".$_SESSION["lang"]."' and nombre like '%" . $id . "%'";
            $this->params["patros"] = $db->loadObjectList($sql);
            //obtengo categorias
            $sql = "select *,
                nombre_" . $_SESSION["lang"] . " as nombre
                from sab_categorias where estado=1 and lng='".$_SESSION["lang"]."' order by nombre_" . $_SESSION["lang"] . "";
            $this->params["submenus"] = $db->loadObjectList($sql);
            $this->params["scripts"] = array(
                "http://maps.google.com/maps/api/js?sensor=false"
            );
            $this->load_html("categorias.php", $this->params);
        }
    }

    /**
     * ficha de las empresas
     */
    function detalle($id="") {
        if ($id == "")
            $this->redirect("");
        else {
            $db=$this->dbInstance();
            $this->params["lib2"]=$this->loadLib("textlibs");
            //obtengo el breadcrumb
            $sql = "select b.*, b.nombre_".$_SESSION["lang"]." as nombre from sab_empresas a inner join sab_categorias b on a.idcategoria=b.id where a.lng='".$_SESSION["lang"]."' and a.id=" . intval($id);
            $dc=$db->loadObjectRow($sql);
            $this->params["uno"] = $dc->nombre;
            $this->params["idcat"] = $dc->id;
            //obtengo patrocinadores
            $sql = "select *,
                nombre,
                descripcion_" . $_SESSION["lang"] . " as descripcion
                from #_empresas where lng='".$_SESSION["lang"]."' and espatrocinador=1 and estado=1 and idcategoria = ".$dc->id;
            $this->params["patros"] = $db->loadObjectList($sql);
            //obtengo empresa
            $sql="select *,descripcion_" . $_SESSION["lang"] . " as descripcion from #_empresas where lng='".$_SESSION["lang"]."' and id=".intval($id);
            $this->params["empresa"]=$db->loadObjectRow($sql);
            //obtengo noticias
            $sql="select * from #_noticias where idempresa=".intval($id)." order by fecha desc limit 5";
            $this->params["noticias"]=$db->loadObjectList($sql);
            //googlemaps
            $this->params["scripts"] = array(
                "http://maps.google.com/maps/api/js?sensor=false",
                "../fancybox/jquery.fancybox-1.3.1.js",
            );
            $this->params["css"] = array(
                "../fancybox/jquery.fancybox-1.3.1.css",
            );

            $this->load_html("detalle_empresa.php",$this->params);
        }
    }

}

?>
