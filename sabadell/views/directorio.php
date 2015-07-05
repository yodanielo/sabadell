<?php
$sl=$params["sl"];
?>
<div id="titlecategorias">
    Empresas</div>
<div class="letras_empresa">
    <strong><?= __("Directorio de empresas A-Z") ?>&nbsp;&nbsp;</strong>
    <?php
    $arl = array();
    for ($i = 65; $i <= 90; $i++) {
        if(chr($i)==$params["def"])
            $arl[] = '<a class="active_letra" href="' . $this->getURL("/empresas/directorio") . '/' . chr($i) . '">' . chr($i) . "</a>";
        else
            $arl[] = '<a href="' . $this->getURL("/empresas/directorio") . '/' . chr($i) . '">' . chr($i) . "</a>";
    }
    echo implode("&nbsp;|&nbsp;", $arl);
    ?>
</div>
<div id="catsubmenu">
<?php
    if (count($params["submenus"]) > 0) {
        foreach ($params["submenus"] as $sm) {
            if ($params["idcat"] == $sm->id)
                echo '<a class="active_submenu" href="' . $this->getURL("/empresas/categorias/$sm->id") . '">' . $sm->nombre . '</a>';
            else
                echo '<a href="' . $this->getURL("/empresas/categorias/$sm->id") . '">' . $sm->nombre . '</a>';
        }
    }else {
        echo "no hay";
    }
?>
</div>
<div id="ultempresas" class="empresasxcat">
    <?php
    if (count($params["empresas"]) > 0){
        foreach ($params["empresas"] as $emp) {
    ?>
    <a href="<?=$this->getURL("/empresas/detalle/".$emp->id)?>">
        <strong><?=$emp->nombre?></strong><br/>
        <br/>
        <span><?=$sl->limitarLetras(strip_tags($emp->descripcion),250)?></span><br/>
        <br/>
        <span><?=$emp->direccion?><br/><?=__("Telf.")." ".$emp->telefono." | ".$emp->correo?></span>
    </a>
    <?php
        }
    }else{
        echo '<div id="nohayempresas">'.__("No hay empresas para mostrar.").'</div>';
    }
    ?>
</div>