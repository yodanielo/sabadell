<div id="slug">
    <?php
    if (is_numeric($params["idcat"])) {
    ?>
        <a href="<?= $this->getURL("/empresas") ?>"><?= __("Empresas de Sabadell") ?></a> &gt; <a href="<?= $this->getURL("/empresas/" . $params["idcat"]) ?>"><?= $params["uno"] ?></a>
    <?php
    } else {
    ?>
        <a href="<?= $this->getURL("/empresas") ?>"><?= __("Empresas de Sabadell") ?></a> &gt; <a href="<?= $this->getURL("/empresas/buscar?query=" . $params["idcat"]) ?>"><?= $params["idcat"] ?></a>
<?php
    }
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
<?php
    if (count($params["patros"]) > 0) {
        echo '<div id="patros">                                ';
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
    <div id="ultempresas" class="empresasxcat">
<?php
    $sl = $params["lib2"];
    if (count($params["empresascuerpo"]) > 0)
        foreach ($params["empresascuerpo"] as $emp) {
?>
            <a href="<?= $this->getURL("/empresas/detalle/" . $emp->id) ?>">
                <strong><?= $emp->nombre ?></strong><br/>
                <br/>
                <span><?= $sl->limitarLetras(strip_tags($emp->descripcion), 250) ?></span><br/>
                <br/>
                <span><?= $emp->direccion ?><br/><?= __("Telf.") . " " . $emp->telefono . " | " . $emp->correo ?></span>
            </a>
<?php
        }
?>
</div>
<?php if ($params["numpaginas"] > 1) {
?>
        <div id="paginacion">
<?php
        $pags = array();
        for ($i = 1; $i <= $params["numpaginas"]; $i++) {
            if ($i == $params["pagactual"])
                $pags[] = '<a class="pag_active" href="' . $this->getURL("/empresas/categorias/" . $params["idcat"] . "/" . $i) . '">' . $i . '</a>';
            else
                $pags[] = '<a href="' . $this->getURL("/empresas/categorias/" . $params["idcat"] . "/" . $i) . '">' . $i . '</a>';
        }
        echo implode(" | ", $pags);
?>
    </div>
<?php } ?>
<div id="titlegmaps">
<?= __("Ubicación en Google Maps") ?>
    </div>
    <div id="googlemaps">

    </div>
    <script type="text/javascript">
        var latlng;
        var myOptions;
        var map;
        function addMarker(ll,txt,id){
            ll1=ll.split(",");
            var myLatlng = new google.maps.LatLng(ll1[0],ll1[1]);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title:txt
            });
            google.maps.event.addListener(marker, 'click', function() {
                contentString="";
                contentString+='<div class="infomap"><strong>'+txt+'</strong><br/>';
                contentString+='<a href="<?= $this->getURL("/empresas/detalle/") ?>'+id+'"><?= __("+información") ?></a></div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            infowindow.open(map,marker);
        });
    }
    jQuery(document).ready(function(){
        latlng = new google.maps.LatLng(40.396764,-3.713379);
        myOptions = {
            zoom: 8,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("googlemaps"), myOptions);
<?php
    if (count($params["googlemaps"]) > 0) {
        foreach ($params["googlemaps"] as $gm) {
            echo 'addMarker("' . $gm->latlong . '", "' . $gm->nombre . '", "' . $gm->id . '");' . "\n";
        }
    }
?>
        
            });
</script>