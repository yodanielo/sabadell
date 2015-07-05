<?php

class Cregistro extends application {

    var $params;

    function Cregistro() {
        $params = array();
        $this->_preparativos();
    }

    function aURL($s) {
        $s = str_replace(explode(",", " ,á,é,í,ó,ú,à,è,ì,ò,ù,ñ,%"), explode(",", ",a,e,i,o,u,a,e,i,o,u,n,"), $s);
        $s = strtolower($s);
        return $s;
    }

    function index() {
        $db = $this->dbInstance();
        $this->params["scripts"] = array(
            "http://maps.google.com/maps/api/js?sensor=false",
            "plugins.js",
        );
        //proceso formulario
        if ($_POST["field1"]) {
            $pass = substr(md5($_POST["field1"]), 0, 5);
            $idi = $_SESSION["lang"];
            $sql = "insert into #_empresas(lng,username,userpass,nombre, nombre_sociedad,cif,direccion,cp,provincia,localidad,telefono,fax,email,web,logo,descripcion_$idi,idcategoria,tags,latlong) values(";
            $arsql = array();
            $arsql[] = "'" . $this->aURL($_POST["field1"]) . "'";
            $arsql[] = "'".md5($pass)."'";
            $arsql[] = "'" . $_SESSION["lang"] . "'";
            for ($i = 1; $i <= 16; $i++) {
                $valido = true;
                if ($i == 12) {
                    if (is_uploaded_file($_FILES["field12"]['tmp_name'])) {
                        $narchivo = mktime() . str_replace(" ", "", basename(strtolower($_FILES['field12']['name'])));
                        $ruta0 = PHISICAL_PATH . "/images/recursos/" . strtolower($narchivo);
                        move_uploaded_file($_FILES["field12"]['tmp_name'], $ruta0);
                        include(PHISICAL_PATH . "/cpanel/fimagenes.php");
                        ajuste_imgmax($ruta0, $ruta0, 226, 166);
                        $valido = false;
                        $arsql[] = "'" . $_FILES['field12']['name'] . "'";
                    } else {
                        $arsql[] = "''";
                        $valido = false;
                    }
                }
                if ($valido)
                    $arsql[] = "'" . $_POST["field$i"] . "'";
            }
            $sql.=implode(",", $arsql);
            $sql.=")";
            $db->setQuery($sql);
            $db->query();

            //enviando correo del administrador
            $content = file_get_contents(PHISICAL_PATH."/plantilla.php");
            $content = str_replace("sabalogo", $this->getURL("", false), $content);
            $content = str_replace("musuario", $this->aURL($_POST["field1"]),$content);
            $content = str_replace("mcontrasena", $pass,$content);
            $Mail = $this->loadLib("phpmailer");
            $Mail->From = "info@sabadell.com";
            $Mail->FromName = "Empresas Sabadell";
            $Mail->AddAddress($_POST["field10"]);
            $Mail->AddReplyTo($Mail->From);
            $Mail->Subject="Bienvenido a Sabadell Empresas";
            $Mail->IsHTML(true);
            $Mail->Body=$content;
            $rpt=$Mail->Send();

            if ($db->getErrorMsg())
                die($db->getErrorMsg());
            $this->params["mensaje"] = __("Su empresa fue ingresada con éxito, en breve usted recibirá un correo del administrador con sus datos de acceso.");
            $this->load_html("mensaje.php", $this->params);
        }else {
            //envio la vista
            $this->load_html("registro.php", $this->params);
        }
    }

    /**
     * cargas constantes en toda la navegacion
     */
    function _preparativos() {
        $db = $this->dbInstance();
        //el banner que cambia
        $this->params["banner"] = $db->loadObjectRow("select * from #_menus where id=1");
        //empresas sabadell - directorio de empresas
        $sql = "SELECT a.id, a.nombre_" . $_SESSION["lang"] . " as nombre, count(*) as conteo FROM sab_categorias a inner join sab_empresas b
                on a.id=b.idcategoria  where a.estado=1 group by a.id,a.nombre_" . $_SESSION["lang"] . "";
        $this->params["categorias"] = $db->loadObjectList($sql);
        //texto introduccion
        $sql = "select * from sab_estatico where id=1";
        $this->params["textofooter"] = $db->loadObjectRow($sql);
    }

}

?>
