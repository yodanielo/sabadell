<?php
$datos = $params["empresa"];
$urlp = $this->getURL("/registro");
if ($datos)
    $urlp = $this->getURL("/zonasegura");
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
            <label><?= __("Listado de Noticias") ?></label>
            <div id="listnoticias" class="flexcroll">
                <div id="listnoticias1">
                    <?php
                    if ($params["noticias"]) {
                        foreach ($params["noticias"] as $n) {
                            echo '<a href="#' . $n->id . '">' . $n->titulo . '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div id="botoneranoticias">
                <a id="editar" href="#"><?= __("Editar") ?></a>
                <a id="anadir" href="#" class="selected"><?= __("Añadir") ?></a>
                <a id="eliminar" href="#"><?= __("Eliminar") ?></a>
            </div>
            <div style="width:817px" class="regfila">
                <label><?= __("Título") ?></label>
                <input type="textbox" name="field35" id="field35" class="regtextbox required" rel="<?= __("Título") ?>" />
            </div>
            <div style="width:240px" class="regfila">
                <label><?= __("Fecha") ?></label>
                <input type="textbox" name="field36" id="field36" class="regtextbox required" rel="<?= __("Fecha") ?>" />
            </div>
            <div style="width:817px; clear:both;" class="regfila">
                <label><?= __("Descripción de la Noticia") ?></label>
                <textarea name="field37" id="field37" class="regtextbox" style="height:175px; display:none"></textarea>
                <iframe id="field37_Frame" src="<?= $this->getURL("/fckeditor",false)?>/editor/fckeditor.html?InstanceName=field37" class="regtextbox" height="175" frameborder="0" scrolling="no"></iframe>
            </div>
        </div>

        <div style="width:817px" class="regfila">
            <input type="submit" id="regsubmit" value="<?= __("Guardar Noticia") ?>" />
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#field36").datepicker({
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre']
        });
        jQuery("#frmregistro").formValidator(function(a){
            if(a!=""){
                alert(a);
            }else{
                title=($("#field35").val());
                data="titulo="+escape($("#field35").val())+"&fecha="+escape($("#field36").val())+"&descripcion="+escape($("#field37").val())+""
                if($("#anadir").hasClass("selected")>0){
                    $.ajax({
                        type:"POST",
                        url:'<?= $this->getURL("/zonasegura/addnoticia") ?>',
                        "data":data,
                        success:function(data){
                            alert(data);
                            $("#listnoticias1").prepend('<a href="#'+data+'">'+title+'</a>');
                            $("#listnoticias1 a:first").click(seleccionar);
                        }
                    });
                }
                if($("#editar").hasClass("selected")>0){
                    id=$(".selectednew").attr("href").split("#").join("");
                    $.ajax({
                        type:"POST",
                        url:'<?= $this->getURL("/zonasegura/editnoticia/") ?>'+id,
                        "data":data,
                        success:function(data){
                            $(".selectednew").html($("#field35").val())
                        }
                    });
                }
                $("#field35").val("");
                $("#field36").val("");
                $("#field37").val("");
                $("#botoneranoticias .selected").removeClass("selected");
                $("#anadir").addClass("selected");
                return false;
            }
        },{eol:"\n"});
        $("#anadir").click(function(){
            $("#botoneranoticias .selected").removeClass("selected");
            $(this).addClass("selected");
            $("#field35").val("");
            $("#field36").val("");
            $("#field37").val("");
            return false;
        });
        $("#eliminar").click(function(){
            if($(".selectednew").length>0){
                id=$(".selectednew").attr("href").split("#").join("");
                $.ajax({
                    type:"POST",
                    url: '<?= $this->getURL("/zonasegura/delnoticia/" + id) ?>',
                    success:function(data){
                        alert(data);
                        $(".selectednew").remove();
                    }
                });
            }
            return false;
        });
        seleccionar=function(){
            $("#botoneranoticias .selected").removeClass("selected");
            $("#editar").addClass("selected");
            $("#listnoticias .selectednew").removeClass("selectednew");
            $(this).addClass("selectednew");
            id=$(this).attr("href").split("#").join("");
            $.ajax({
                type: "GET",
                url: '<?= $this->getURL("/zonasegura/getnoticia/") ?>'+id,
                sync:true,
                cache: false,
                dataType: ($.browser.msie) ? "text" : "xml",
                success: function(data) {
                    var xml;
                    if ( $.browser.msie ) {
                        xml = new ActiveXObject("Microsoft.XMLDOM");
                        xml.async = false;
                        xml.loadXML(data);
                    } else {
                        xml = data;
                    }
                    $("#field35").val($(xml).find("titulo").text());
                    $("#field36").val($(xml).find("fecha").text());
                    $("#field37").val($(xml).find("descripcion").text());
                }
            });
            return false;
        }
        $("#listnoticias a").click(seleccionar);
    })
</script>