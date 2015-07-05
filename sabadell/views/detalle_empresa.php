<?php
$emp = $params["empresa"];
$not = $params["noticias"];
$lb = $params["lib2"];
?>
<div id="slug">
    <a href="<?= $this->getURL("/empresas") ?>"><?= __("Empresas de Sabadell") ?></a> &gt; <a href="<?= $this->getURL("/empresas/categorias/" . $params["idcat"]) ?>"><?= $params["uno"] ?></a>
</div>
<?php
if (count($params["patros"]) > 0) {
    echo '<div id="patros" class="regpatros" style="border: 1px solid #D3EAF8!important">                                ';
    foreach ($params["patros"] as $p) {
?>
        <div class="patroitem">
            <a href="<?= $this->getURL("/empresas/detalle/$p->id") ?>" class="patrologo">
                <img src="<?= $this->getURL("/images/recursos/$p->logo", false) ?>" />
            </a>
            <a href="<?= $this->getURL("/empresas/detalle/$p->id") ?>" class="patrodet">
                <span class="patrotitle"><?= $p->nombre ?></span><br/>
                <p>
            <?= $params["lib2"]->limitarLetras(strip_tags($p->descripcion), 150) ?>
        </p>
        <p>
            <?= $p->direccion ?><br/>
            <?= ($p->telefono == "" ? "" : _("Telf.") . $p->telefono . " ") . ($p->fax == "" ? "" : _("Fax.") . $p->fax . " ") ?> <br/>
            <?= ($p->correo == "" ? "" : _("e-mail:") . $p->correo . " ") ?>
        </p>
    </a>
    <a href="<?= $this->getURL("/empresas/detalle/$p->id") ?>" class="patroinfo"><?= __("+información") ?></a>
</div>

<?php
        }
        echo '</div>';
    }
?>
    <div class="barraceleste barradetalle">
    <?= $emp->nombre ?>
</div>
<div class="cuadroform">
    <div class="dettitulo"><?= __("Empresa") ?></div>
    <div class="textodet">
        <?= $emp->descripcion ?>
    </div>
    <div class="dettitulo"><?= __("Servicios y Productos") ?></div>
    <div class="textodet">
        <?= $emp->productos ?>
    </div>
    <div class="detimages">
        <?php
        $descs = explode("##,##", $emp->proddesc);
        $images = explode("##,##", $emp->prodimg);
        for ($i = 0; $i < 5; $i++) {
            if ($images[$i]) {
                echo '<a class="pafancy" title="'.$descs[$i].'" href="' . $this->getURL("/images/recursos/grande_" . $images[$i], false) . '">';
                echo '<img src="' . $this->getURL("/images/recursos/" . $images[$i], false) . '" />';
                echo '</a>';
            }
        }
        ?>
    </div>
    <div class="dettitulo">
        <?= __("Noticias") ?>
    </div>
    <div class="cfnoticias">
        <?php
        if (count($not) > 0) {
            foreach ($not as $n) {
        ?>
                <a href="<?= $this->getURL("/noticias/" . $n->id) ?>"><span class="titlnot"><?= $n->fecha . " " . $n->titulo ?></span><br/><?= $lb->limitarLetras($n->descripcion, 250) ?></a>
        <?php
            }
        }
        ?>
    </div>
    <div class="dettitulo">
        <?= __("Contacto") ?>
    </div>
    <div id="regmaps">

    </div>
    <div id="regmapsdatos">
        <strong><?=__("Dirección")?></strong><br/>
        <br/>
        <?=$emp->direccion?><br/>
        <?=__("Telf. ").$emp->telefono." ".__("Fax").".".$emp->fax?><br/>
        <br/>
        <strong><?=__("E-mail")?></strong><br/>
        <br/>
        <?=__("e-mail").': <a href="mailto:'.$emp->email.'">'.$emp->email."</a>"?><br/>
        <br/>
        <strong><?=__("Web")?></strong><br/>
        <br/>
        <?=$emp->web?>
    </div>
</div>
<script type="text/javascript">
    var latlng;
    var myOptions;
    var map;
    var marker;
    function addMarker(ll,txt){
        ll1=ll.split(",");
        var myLatlng = new google.maps.LatLng(ll1[0],ll1[1]);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title:txt
        });
    }
    jQuery(document).ready(function(){
        latlng = new google.maps.LatLng(40.396764,-3.713379);
        myOptions = {
            zoom: 8,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("regmaps"), myOptions);
        addMarker('<?=$emp->latlong?>', "")
        $(".pafancy").fancybox({
            overlayOpacity:0.8,
            overlayColor:"#000"
        });
    });
</script>