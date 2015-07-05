<?php
$datos = $params["empresa"];
$urlp = $this->getURL("/registro");
if ($datos)
    $urlp = $this->getURL($params["slug"]);
?>
<form name="frmregistro" method="post" id="frmregistro" action="<?= $urlp ?>" enctype="multipart/form-data">
    <div id="slug">
        <?php
        echo '<a href="' . $this->getURL("/") . '">' . __("Empresas Sabadell") . '</a> &gt; <a href="' . $this->getURL($params["slug"]) . '">' . __($params["nomslug"]) . '</a>';
        ?>
    </div>
    <?php if (!$datos) {
    ?>
            <div class="introregistro">
        <?= __("Introducción al registro") ?>
        </div>
    <?php
        } else {
            if (count($params["patros"]) > 0) {
                echo '<div id="patros" class="regpatros">                                ';
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
        }
    ?>
        <div class="barraceleste">
        <?php
        if (!$datos) {
            echo __("Ficha de Empresa");
        } else {
            $cad = '<a class="regceleste" href="' . $this->getURL("/zonasegura") . '">' . __("Mi empresa") . '</a>';
            $cad.='<a class="regceleste" href="' . $this->getURL("/zonasegura/productos") . '">' . __("Productos y Servicios") . '</a>';
            $cad.='<a class="regceleste" href="' . $this->getURL("/zonasegura/promociones") . '">' . __("Promociones / Ofertas") . '</a>';
            $cad.='<a class="regceleste" href="' . $this->getURL("/zonasegura/noticias") . '">' . __("Noticias") . '</a>';
            echo str_replace($params["slug"] . '"', $params["slug"] . '" id="regceleste_active"', $cad);
        }
        ?>
    </div>
    <div class="cuadroform">
        <div style="width:817px" class="regfila">
            <label><?= __("Servicios y Productos") ?></label>
            <textarea name="field25" id="field25" class="regtextbox" style="display:none" rel="<?= __("Servicios y Productos") ?>"><?=$datos->productos?></textarea>
            <iframe id="field13_Frame" src="<?= $this->getURL("/fckeditor",false)?>/editor/fckeditor.html?InstanceName=field25" class="regtextbox" height="228" frameborder="0" scrolling="no"></iframe>
        </div>
        <div style="width:817px" class="regfila">
            <label><?= __("Imágenes") ?></label>
            <div id="regimagenes">
                <?php
                $regimages = explode("##,##", $datos->prodimg);
                $regdescs = explode("##,##", $datos->proddesc);
                $img = "";
                for ($i = 0; $i < 5; $i++) {
                    if ($regimages[$i]){
                        $img.='
                        <div class="regimg '.($i==0?"regimgselected":"").'">
                            <img src="' . $this->getURL("/images/recursos/" . $regimages[$i],false) . '"/>
                            <div class="estilofile">
                            <input type="file"   name="field26_img['.$i.']" class="field26" />
                            </div>
                            <input type="hidden" name="field26_ant['.$i.']" class="field26_ant" value="'.$regimages[$i].'" />
                            <input type="hidden" name="field26_des['.$i.']" class="field26_des" value="'.$regdescs[$i].'" />
                        </div>';
                    }
                    else{
                        $img.='
                        <div class="regimg">
                            <div class="regimgvacia"></div>
                            <div class="estilofile">
                            <input type="file"   name="field26_img['.$i.']" class="field26" />
                            </div>
                            <input type="hidden" name="field26_ant['.$i.']" class="field26_ant" value="'.$regimages[$i].'" />
                            <input type="hidden" name="field26_des['.$i.']" class="field26_des" value="'.$regdescs[$i].'" />
                        </div>';
                    }
                }
                echo $img;
                ?>
            </div>
        </div>
        <div style="width:617px" class="regfila">
            <label><?= __("Descripción de la Imágen") ?></label>
            <input type="textbox" name="field27" id="field27" class="regtextbox"/>
        </div>
        <div style="width:817px" class="regfila">
            <input type="submit" id="regsubmit" value="<?= __("Guardar Ficha de empresa") ?>" />
        </div>
    </div>
</form>
<script type="text/javascript">
    $(".regimg").click(function(){
        $(".regimgselected").removeClass("regimgselected");
        $(this).addClass("regimgselected");
        $("#field27").val($(this).find(".field26_des").val());
    });
    $("#field27").keyup(function(){
        $(".regimgselected .field26_des").val($(this).val());
    })
</script>