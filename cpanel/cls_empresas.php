<?php
include("cls_MantixBase20.php");

class Registro extends MantixBase {
    function __construct() {
        $this->ini_datos("sab_empresas","id");
    }
    function get_idioma(){
        $cad='';
        $cad.='<option value="esp">Español</option>';
        $cad.='<option value="cat">Catalán</option>';
        return $cad;
    }
    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos=array("texto_submit"=>"Registro");
        $m_Form->datos=$this->datos;
        $m_Form->controles=array(
            array("label"=>"Nombre Comercial:","campo"=>"nombre"),
            array("label"=>"Nombre de la Sociedad:","campo"=>"nombre_sociedad"),
            array("label"=>"Categoría:","campo"=>"idcategoria","tipo"=>"select","tabla_asoc"=>"sab_categorias","campo_asoc"=>"nombre_esp","id_asoc"=>"id"),
            array("label"=>"CIF / NIF:","campo"=>"cif"),
            array("label"=>"Código Postal:","campo"=>"cp"),
            array("label"=>"Provincia:","campo"=>"provincia"),
            array("label"=>"Localidad:","campo"=>"localidad"),

            array("tipo"=>"abre_grupo","campo"=>"sep_des","label"=>"Castellano"),
                array("label"=>"Descripción (Español):","campo"=>"descripcion_esp","tipo"=>"fck"),
            array("tipo"=>"cierra_grupo"),

            array("tipo"=>"abre_grupo","campo"=>"sep_dca","label"=>"Catalán"),
                array("label"=>"Descripción (Catalán):","campo"=>"descripcion_cat","tipo"=>"fck"),
            array("tipo"=>"cierra_grupo"),

            array("label"=>"Dirección:","campo"=>"direccion"),
            array("label"=>"Teléfono:","campo"=>"telefono"),
            array("label"=>"Fax:","campo"=>"fax"),
            array("label"=>"Correo:","campo"=>"email"),
            array("label"=>"Página web:","campo"=>"web"),
            array("label"=>"Palabras Clave:","campo"=>"tags"),
            array("label"=>"Idioma:","campo"=>"lng","opciones"=>$this->get_idioma()),
            array("label"=>"Latitud y Longitud:","campo"=>"latlong"),
            array("label"=>"Logo:","campo"=>"logo","tipo"=>"archivogg",
                "extensiones"=>"*.jpg",
                "tooltip"=>"Formatos permitidos: jpg<br/>Tamaño Ideal: 226 x 166 px",
                "descripcion"=>"Imágenes JPG",
                ),
            array("label"=>"Es empresa:","campo"=>"esempresa","tipo"=>"select","opciones"=>$this->get_decision()),
            array("label"=>"Es patrocinador:","campo"=>"espatrocinador","tipo"=>"select","opciones"=>$this->get_decision()),

        );
        $res = $m_Form->ver();
        return  $res;
    }
    function lista() {
        $r = new MantixGrid();
        $sql="select sab_empresas.*,sab_categorias.nombre_esp as cat from sab_empresas inner join sab_categorias on sab_empresas.idcategoria=sab_categorias.id";
        $r->atributos=array("sql"=>$sql,"nropag"=>"20","ordenar"=>"sab_categorias.nombre_esp","ver_buscador"=>"1");
        $r->buscador=array(
            array("label"=>"Categoría","tipo"=>"select","tabla_asoc"=>"sab_categorias","campo_asoc"=>"nombre_esp","id"=>"idcategoria","campo"=>"idcategoria"),
            array("label"=>"Nombre Comercial","tipo"=>"text","id"=>"nombre","campo"=>"nombre")
        );
        $r->columnas=array(
                array("titulo"=>"Nombre","campo"=>"nombre",),
                array("titulo"=>"Categoría","campo"=>"cat",),
        );
        return $r->ver();
    }
}
?>