<?php

class Czonasegura extends application {

    var $autenticated;
    var $datos;
    var $params;

    function Czonasegura() {
        $db = $this->dbInstance();
        $auth = $this->loadModel("autentication");
        $auth->table = "#_empresas";
        $auth->sessionName = "sabadell_front";
        $auth->userField = "username";
        $auth->passwordField = "userpass";
        if ($this->post("usuario")) {
            //tengo que autenticar
            $us = $this->post("usuario");
            $pa = $this->post("password");
            $this->autenticated = $auth->login($us, $pa);
            if (!$this->autenticated) {
                $this->params["mensaje"] = __("Usuario o Contraseña incorrectos");
                $this->load_html("mensaje.php", $this->params);
                exit;
            }
        } else {
            $this->autenticated = $auth->isLogged();
            if (!$this->autenticated) {
                $this->redirect("");
                exit;
            }
        }
        $this->_preparativos();
    }

    /**
     * cargas constantes en toda la navegacion
     */
    function _preparativos() {
        $db = $this->dbInstance();
        //el banner que cambia
        $this->params["banner"] = $db->loadObjectRow("select * from #_menus where id=7");
        //empresas sabadell - directorio de empresas
        $sql = "SELECT a.id, a.nombre_" . $_SESSION["lang"] . " as nombre, count(*) as conteo FROM sab_categorias a inner join sab_empresas b
                on a.id=b.idcategoria  where a.estado=1 and b.lng='" . $_SESSION["lang"] . "' group by a.id,a.nombre_" . $_SESSION["lang"] . "";
        $this->params["categorias"] = $db->loadObjectList($sql);
        //obtengo patrocinadores
        $sql = "select *,
                nombre,
                descripcion_" . $_SESSION["lang"] . " as descripcion
                from #_empresas where lng='" . $_SESSION["lang"] . "' and espatrocinador=1 and estado=1 and idcategoria=" . $this->datos->idcategoria;
        $this->params["lib2"] = $this->loadLib("textlibs");
        $this->params["patros"] = $db->loadObjectList($sql);
        //texto introduccion
        $sql="select * from sab_estatico where id=1";
        $this->params["textofooter"]=$db->loadObjectRow($sql);
    }

    /**
     * mi empresa
     */
    function index() {
        $db = $this->dbInstance();
        $this->params["scripts"] = array(
            "http://maps.google.com/maps/api/js?sensor=false",
            "plugins.js",
        );
        $this->params["slug"] = "/zonasegura";
        $this->params["nomslug"] = "Mi empresa";
        //guardo los datos
        if (is_uploaded_file($_FILES["field12"]['tmp_name'])) {
            $narchivo = mktime() . str_replace(" ", "", basename(strtolower($_FILES['field12']['name'])));
            $ruta0 = PHISICAL_PATH . "/images/recursos/" . strtolower($narchivo);
            move_uploaded_file($_FILES["field12"]['tmp_name'], $ruta0);
            include(PHISICAL_PATH . "/cpanel/fimagenes.php");
            ajuste_imgmax($ruta0, $ruta0, 226, 166);
            $valido = false;
            $arsql[] = "'" . $narchivo . "'";
            unlink(PHISICAL_PATH . "/images/recursos/" . $_POST["field12_ant"]);
        } else {
            $arsql[] = "''";
            $valido = false;
        }
        if ($_POST["field1"]) {
            $arrp = array(
                "nombre" => $_POST["field1"],
                "nombre_sociedad" => $_POST["field2"],
                "cif" => $_POST["field3"],
                "direccion" => $_POST["field4"],
                "cp" => $_POST["field5"],
                "provincia" => $_POST["field6"],
                "localidad" => $_POST["field7"],
                "telefono" => $_POST["field8"],
                "fax" => $_POST["field9"],
                "email" => $_POST["field10"],
                "web" => $_POST["field11"],
                "logo" => ($_FILES["field12"]["name"] ? $narchivo : $_POST["field12_ant"]),
                "descripcion_" . $_SESSION["lang"] => $_POST["field13"],
                "idcategoria" => $_POST["field14"],
                "tags" => $_POST["field15"],
                "latlong" => $_POST["field16"],
            );
            $sql = "update #_empresas set ";
            foreach ($arrp as $key => $a) {
                $sql.="$key = '$a', ";
            }
            $sql = substr($sql, 0, strlen($sql) - 2);
            $sql.=" where id=" . $_SESSION["sabadell_front"]["id"];
            $db->setQuery($sql);
            $db->query();
        }
        //todos los preliminares
        if ($this->autenticated) {
            $sql = "select * from sab_empresas where lng='" . $_SESSION["lang"] . "' and id=" . $_SESSION["sabadell_front"]["id"];
            $this->datos = $db->loadObjectRow($sql);
            $this->params["empresa"] = $this->datos;
            $this->params["nomEmpresa"] = $this->datos->nombre;
        }
        $this->load_html("registro.php", $this->params);
    }

    function productos() {
        $db = $this->dbInstance();
        $this->params["scripts"] = array(
            "plugins.js",
        );
        $this->params["slug"] = "/zonasegura/productos";
        $this->params["nomslug"] = "Productos y Servicios";

        //guardo
        if ($_POST["field25"]) {
            $images = array();
            $descri = array();
            for ($i = 0; $i < 5; $i++) {
                if (is_uploaded_file($_FILES["field26_img"]['tmp_name'][$i])) {
                    $narchivo = mktime() . str_replace(" ", "", basename(strtolower($_FILES['field26_img']['name'][$i])));
                    $ruta0 = PHISICAL_PATH . "/images/recursos/" . strtolower($narchivo);
                    $ruta1 = PHISICAL_PATH . "/images/recursos/grande_" . strtolower($narchivo);
                    move_uploaded_file($_FILES["field26_img"]['tmp_name'][$i], $ruta0);
                    include(PHISICAL_PATH . "/cpanel/fimagenes.php");
                    ajuste_imgmax($ruta0, $ruta1, 800, 600);
                    clipImage($ruta0, $ruta0, 136, 136);
                    $valido = false;
                    $images[] = $narchivo;
                    if (file_exists(PHISICAL_PATH . "/images/recursos/" . $_POST["field26_ant"][$i]) && !is_dir(PHISICAL_PATH . "/images/recursos/" . $_POST["field26_ant"][$i]))
                        unlink(PHISICAL_PATH . "/images/recursos/" . $_POST["field26_ant"][$i]);
                } else {
                    $images[] = $_POST["field26_ant"][$i];
                    $valido = false;
                }
                $descri[] = str_replace("'", "\'", str_replace("\'", "'", $_POST["field26_des"][$i]));
            }
            $arrp = array(
                "proddesc" => implode("##,##", $descri),
                "prodimg" => implode("##,##", $images),
                "productos" => str_replace("'", "\'", str_replace("\'", "'", $_POST["field25"]))
            );
            $sql = "update #_empresas set ";
            foreach ($arrp as $key => $a) {
                $sql.="$key = '$a', ";
            }
            $sql = substr($sql, 0, strlen($sql) - 2);
            $sql.=" where id=" . $_SESSION["sabadell_front"]["id"];
            $db->setQuery($sql);
            $db->query();
        }

        //todos los preliminares
        if ($this->autenticated) {
            $sql = "select * from sab_empresas where id=" . $_SESSION["sabadell_front"]["id"];
            $this->datos = $db->loadObjectRow($sql);
            $this->params["empresa"] = $this->datos;
            $this->params["nomEmpresa"] = $this->datos->nombre;
        }

        $this->load_html("productos_y_servicios.php", $this->params);
    }

    /**
     * productos y promociones
     */
    function promociones() {
        $db = $this->dbInstance();
        $this->params["scripts"] = array(
            "plugins.js",
        );
        $this->params["slug"] = "/zonasegura/promociones";
        $this->params["nomslug"] = "Promociones / Ofertas";

        //todos los preliminares
        if ($this->autenticated) {
            $sql = "select * from sab_empresas where lng='" . $_SESSION["lang"] . "' and id=" . $_SESSION["sabadell_front"]["id"];
            $this->datos = $db->loadObjectRow($sql);
            $this->params["empresa"] = $this->datos;
            $this->params["nomEmpresa"] = $this->datos->nombre;
        }
        $this->params["mensaje"] = "En construcción";
        $this->load_html("mensaje.php", $this->params);
    }

    /**
     * noticias
     */
    function noticias() {
        $db = $this->dbInstance();
        $this->params["scripts"] = array(
            "plugins.js",
        );
        $this->params["slug"] = "/zonasegura/noticias";
        $this->params["nomslug"] = "Noticias";

        //todos los preliminares
        if ($this->autenticated) {
            $sql = "select * from sab_empresas where lng='" . $_SESSION["lang"] . "' and id=" . $_SESSION["sabadell_front"]["id"];
            $this->datos = $db->loadObjectRow($sql);
            $this->params["empresa"] = $this->datos;
            $this->params["nomEmpresa"] = $this->datos->nombre;
            $sql = "select * from sab_noticias where idempresa='" . $_SESSION["sabadell_front"]["id"] . "'";
            $this->params["noticias"] = $this->datos = $db->loadObjectList($sql);
        }
        $this->params["scripts"] = array(
            "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js",
            "plugins.js",
        );
        $this->params["css"] = array(
            "ui-lightness/jquery-ui-1.8.6.custom.css"
        );
        $this->load_html("noticias.php", $this->params);
    }

    /**
     * agrega una noticia
     */
    function addnoticia() {
        global $_SESSION;
        $db = $this->dbInstance();
        $f = explode("/", $_POST["fecha"]);
        $arrp = array(
            "titulo" => $_POST["titulo"],
            "descripcion" => $_POST["descripcion"],
            "fecha" => $f[2] . "-" . $f[1] . "-" . $f[0],
            "idempresa" => $_SESSION["sabadell_front"]["id"]
        );
        echo $db->insert("#_noticias", $arrp);
    }

    /**
     * coge una noticia
     */
    function getnoticia($id) {
        global $_SESSION;
        $db = $this->dbInstance();
        $sql = "select * from sab_noticias where id=" . intval($id) . " and idempresa=" . $_SESSION["sabadell_front"]["id"];
        $r = $db->loadObjectRow($sql);
        echo '<?xml version="1.0" encoding="utf-8" ?>';
        echo '<todo>';
        echo '  <titulo><![CDATA[' . $r->titulo . ']]></titulo>';
        echo '  <fecha><![CDATA[' . $r->fecha . ']]></fecha>';
        echo '  <descripcion><![CDATA[' . $r->descripcion . ']]></descripcion>';
        echo '</todo>';
    }

    function delnoticia($id) {
        global $_SESSION;
        $db = $this->dbInstance();
        $sql = "delete from sab_noticias where id=" . intval($id);
        $db->setQuery($sql);
        $db->query();
    }

}

?>
