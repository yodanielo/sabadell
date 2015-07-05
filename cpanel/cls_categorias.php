<?php
include("cls_MantixBase20.php");

class Registro extends MantixBase {
    function __construct() {
        $this->ini_datos("sab_categorias","id");
    }
    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos=array("texto_submit"=>"Registro");
        $m_Form->datos=$this->datos;
        $m_Form->controles=array(
            array("label"=>"Nombre (Español):","campo"=>"nombre_esp"),
            array("label"=>"Nombre (Catalán):","campo"=>"nombre_cat"),
        );
        $res = $m_Form->ver();
        return  $res;
    }
    function lista() {
        $r = new MantixGrid();
        $sql="select * from sab_categorias";
        $r->atributos=array("sql"=>$sql,"nropag"=>"20","ordenar"=>"id");
        $r->columnas=array(
                array("titulo"=>"Nombre (Español)","campo"=>"nombre_esp"),
                array("titulo"=>"Nombre (Catalán)","campo"=>"nombre_cat"),
        );
        return $r->ver();
    }
}
?>