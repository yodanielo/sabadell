<?php
$datos = $params["empresa"];
$urlp=$this->getURL("/registro");
if($datos)
    $urlp=$this->getURL("/zonasegura");
?>
<form name="frmregistro" method="post" id="frmregistro" action="<?= $urlp ?>" enctype="multipart/form-data">
    <div id="slug">
        <?php
        if (!$datos) {
            echo '<a href="' . $this->getURL("/") . '">' . __("Empresas Sabadell") . '</a> &gt; <a href="' . $this->getURL("/registro/") . '">' . __("Alta de empresas") . '</a>';
        } else {
            echo '<a href="' . $this->getURL("/") . '">' . __("Empresas Sabadell") . '</a> &gt; <a href="' . $this->getURL("/zonasegura") . '">' . __("Mi empresa") . '</a>';
        }
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
        <div style="width:608px" class="regfila">
            <label><?= __("Nombre Comercial") ?><span>(<?= __("nombre por el que se conoce a tu empresa") ?>)</span>*</label>
            <input type="text" name="field1" id="field1" class="regtextbox required" value="<?= $datos->nombre ?>" rel="<?= __("Nombre Comercial") ?>" />
        </div>
        <div style="width:613px" class="regfila">
            <label><?= __("Nombre de la sociedad o profesional autónomo") ?>*</label>
            <input type="text" name="field2" id="field2" class="regtextbox required" value="<?= $datos->nombre_sociedad ?>" rel="<?= __("Nombre de la sociedad o profesional autónomo") ?>" />
            <span style="clear:both;"><?= __("Tus datos societarios o profesionales no serán visibles para los demás usuarios, tan sólo tu nombre comercial") ?></span>
        </div>
        <div style="width:185px" class="regfila">
            <label><?= __("CIF o NIF") ?>*</label>
            <input type="text" name="field3" id="field3" class="regtextbox required" value="<?= $datos->cif ?>" rel="<?= __("CIF o NIF") ?>" />
        </div>
        <div style="width:638px" class="regfila">
            <label><?= __("Dirección") ?>*</label>
            <input type="text" name="field4" id="field4" class="regtextbox required" value="<?= $datos->direccion ?>" rel="<?= __("Dirección") ?>" />
        </div>
        <div style="width:160px" class="regfila">
            <label><?= __("Código Postal") ?>*</label>
            <input type="text" name="field5" id="field5" class="regtextbox required integer" value="<?= $datos->cp ?>" rel="<?= __("Código Postal") ?>" />
        </div>
        <div style="width:411px" class="regfila">
            <label><?= __("Provincia") ?>*</label>
            <input type="text" name="field6" id="field6" class="regtextbox required" value="<?= $datos->provincia ?>" rel="<?= __("Provincia") ?>" />
        </div>
        <div style="width:387px" class="regfila">
            <label><?= __("Localidad") ?>*</label>
            <input type="text" name="field7" id="field7" class="regtextbox required" value="<?= $datos->localidad ?>" rel="<?= __("Localidad") ?>" />
        </div>
        <div style="width:411px" class="regfila">
            <label><?= __("Teléfono") ?></label>
            <input type="text" name="field8" id="field8" class="regtextbox integer" value="<?= $datos->telefono ?>" rel="<?= __("Teléfono") ?>" />
        </div>
        <div style="width:387px" class="regfila">
            <label><?= __("Fax / Móvil") ?></label>
            <input type="text" name="field9" id="field9" class="regtextbox integer" value="<?= $datos->fax ?>" rel="<?= __("Fax / Móvil") ?>" />
        </div>
        <div style="width:411px" class="regfila">
            <label><?= __("E-mail") ?>*</label>
            <input type="text" name="field10" id="field10" class="regtextbox required email" value="<?= $datos->email ?>" rel="<?= __("E-mail") ?>" />
        </div>
        <div style="width:387px" class="regfila">
            <label><?= __("Página web") ?><span> (<?= __("www.empresa.com") ?>)</span>*</label>
            <input type="text" name="field11" id="field11" class="regtextbox" value="<?= $datos->web ?>" />
        </div>
        <div style="width:411px" class="regfila">
            <label><?= __("Logo de empresa (formato jpg)") ?></label>
            <div id="reglogo" style="background:url(<?=$this->getURL("/images/recursos/",false).$datos->logo?>) center no-repeat">
                <div class="estilologo">
                <input type="file" name="field12" id="field12" class="regtextbox" />
                </div>
            </div>
        </div>
        <input type="hidden" name="field12_ant" value="<?=$datos->logo?>"/>
        <div style="width:387px" class="regfila">
            <label><?= __("Descripción corta de la actividad") ?>*</label>
            <textarea name="field13" class="regtextbox" style="display:none" id="field13" value="<?= $datos->descripcion ?>"></textarea>
            <iframe id="field13_Frame" src="<?= $this->getURL("/fckeditor",false)?>/editor/fckeditor.html?InstanceName=field13" class="regtextbox" height="220" frameborder="0" scrolling="no"></iframe>
        </div>
        <div style="width:411px; clear:both;" class="regfila">
            <label><?= __("Actividad") ?>*</label>
            <select name="field14" id="field14" class="regtextbox required" rel="<?= __("Actividad") ?>">
                <option value=""><?= __("Cualquiera") ?></option>
                <?php
                foreach ($params["categorias"] as $cats) {
                    if ($datos->idcategoria == $cats->id)
                        echo '<option selected value="' . $cats->id . '">' . $cats->nombre . '</option>';
                    else
                        echo '<option value="' . $cats->id . '">' . $cats->nombre . '</option>';
                }
                ?>
            </select>
        </div>
        <div style="width:817px; clear:both;" class="regfila">
            <label><?= __("Palabras clave que describan tu actividad, productos o servicios (separadas por comas)") ?>*</label>
            <input type="text" name="field15" id="field15" class="regtextbox" value="<?= $datos->tags ?>" />
            <span style="clear:both"><?= __("Ej.: Restaurante, menús diarios, comida rápida, platos combinados, paella, ...") ?></span>
        </div>
        <div style="width:804px; margin-top: 20px;" class="regfila">
            <label><?= __("Google Maps") ?></label>
            <div id="regmapscheck"><?= __("Comprueba la ubicación de tu empresa. Puedes cambiarla en el mapa") ?></div>
            <div id="regmaps">

            </div>
            <div id="regmapsdatos">

            </div>
            <div style="display:none">
                <input type="hidden" name="field16" id="field16" value="<?=$datos->latlong?>" />
            </div>
            <script type="text/javascript">
                var latlng;
                var myOptions;
                var map;
                var marker;
                jQuery(document).ready(function(){
                    
                    latlng = new google.maps.LatLng(40.396764,-3.713379);
                    myOptions = {
                        zoom: 8,
                        center: latlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    map = new google.maps.Map(document.getElementById("regmaps"), myOptions);
                    
                    google.maps.event.addListener(map, 'click', function(event) {
                        var position = event.latLng;
                        if(marker)
                            marker.setMap(null);
                        marker = new google.maps.Marker({
                            map: map,
                            position: position
                        });
                        $("#field16").val(position.toString().split("(").join("").split(")").join(""));
                    });
                    <?php
                    if ($datos->latlong) {
                    ?>
                        position = new google.maps.LatLng(<?=$datos->latlong?>);
                        marker = new google.maps.Marker({            
                            map: map,
                            position: position
                        });
                    <?php
                    }
                    ?>
    });

            </script>
        </div>
        <?php
                if (!datos) {
        ?>
                    <div style="width:804px" id="chk17" class="regfila">
                        <input type="checkbox" name="field17" id="field17" class="regcheckbox required" rel="Condiciones Generales" />
                        <span id="f15_texto"><?= __("Acepto las condiciones") ?></span>
                    </div>
        <?php
                }
        ?>
                <div style="width:817px" class="regfila">
                    <input type="submit" id="regsubmit" value="<?= __("Guardar Ficha de empresa") ?>" />
                </div>
            </div>
        </form>
        <script type="text/javascript">
            jQuery("#frmregistro").formValidator(function(a){
                if(a!=""){
                    alert(a);
                }else{
                    if(!$("#field17")[0].checked && $("#field17").length>0){
                        alert("<?= __("Debe aceptar las Condiciones Generales") ?>");
                return false;
            }
        }
    },{eol:"\n"});
</script>