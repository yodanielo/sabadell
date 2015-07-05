<?php
$sl=$params["sl"];
?>
<div id="titlecategorias">
    <?= __("Empresas de Sabadell") ?>
</div>
<div id="menucategorias">
    <?php
    if (count($params["categorias"]) > 0)
        foreach ($params["categorias"] as $cat) {
    ?>
            <a href="<?= $this->getURL("/empresas/categorias/" . $cat->id) ?>"><?= $cat->nombre . " (" . number_format($cat->conteo, 0, ",", ".") . ")" ?></a>
    <?php
        }
    ?>
</div>
<div id="titleultempresas">
    <?= __("Empresas de Sabadell") ?>
</div>
<div id="ultempresas">
    <?php
    if (count($params["ultempresas"]) > 0)
        foreach ($params["ultempresas"] as $emp) {
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
    ?>
</div>
