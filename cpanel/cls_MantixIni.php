<?php
include("cls_MantixMenu.php");
$menu =new MantixMenu();
$menu->opciones = array(
        array("titulo"=>"Administradores"   ,"url"=>"usuarios.php"     ,"id"=>"usuarios"),
        array("titulo"=>"Menús"             ,"url"=>"menus.php"        ,"id"=>"usuarios"),
        array("titulo"=>"Footer"            ,"url"=>"footer.php"        ,"id"=>"usuarios"),
        array("titulo"=>"Información"       ,"url"=>"informacion.php"        ,"id"=>"usuarios"),
        array("titulo"=>"Servicios"         ,"url"=>"servicios.php"        ,"id"=>"usuarios"),
        array("titulo"=>"Contacto"          ,"url"=>"contacto.php"        ,"id"=>"usuarios"),
        array("titulo"=>"Categorias"        ,"url"=>"categorias.php"   ,"id"=>"usuarios"),
        array("titulo"=>"Empresas"          ,"url"=>"empresas.php"     ,"id"=>"usuarios"),
);
$img_top="bg-top.gif";
$usuario="";
?>