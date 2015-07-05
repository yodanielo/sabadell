<?php
$query = "";
if (!is_numeric($params["idcat"])) {
    $query = $params["idcat"];
}
?>
<!--INICIO DE FOOTER-->
<?php if (trim($params["textofooter"]->contenido) != "") {
 ?>
    <div id="textofooter"><?= $params["textofooter"]->contenido ?></div>
<?php } ?>
<div id="buscar_empresas">
    <form action="<?= $this->getURL("/empresas/buscar") ?>" method="get" name="frmbusqueda" id="frmbusqueda">
        <input type="text" name="query" value="<?= $query ?>" id="busempresas" />
        <label><?= __("Busca empresas, productos o servicios") ?></label>
    </form>
</div>
<div class="letras_empresa">
    <strong><?= __("Directorio de empresas A-Z") ?>&nbsp;&nbsp;</strong>
    <?php
    $arl = array();
    for ($i = 65; $i <= 90; $i++) {
        $arl[] = '<a href="' . $this->getURL("/empresas/directorio") . '/' . chr($i) . '">' . chr($i) . "</a>";
    }
    echo implode("&nbsp;|&nbsp;", $arl);
    ?>
</div>
<div id="directoriodeemresas_footer">
    <div id="diem_top"><label>Directorio de empresas</label></div>
    <div id="diem_center">
        <?php
        $diem = array();
        if (count($params["categorias"]) > 0) {
            foreach ($params["categorias"] as $cat) {
                $diem[] = '<a href="' . $this->getURL("/empresas/categorias/" . $cat->id) . '">' . $cat->nombre . ' (' . number_format($cat->conteo, 0, ",", ".") . ')</a>';
            }
            echo implode("&nbsp;&nbsp;|&nbsp;&nbsp;", $diem);
        }
        ?>
    </div>
    <div id="diem_bottom"></div>
</div>
<div id="creditos">&copy;Copyright Guiasabadell.com - <?= date("Y") ?> | <?= __("Condiciones de uso - Política de privacidad") ?> | <?= __("Diseño web") ?> | <?= __("Contacto") ?> | info@guiasabadell.com</div>
</div>
</body>
</html>