<?php

class MantixForm {
    var $controles;
    var $atributos;
    var $botones;
    var $datos;
    var $js;
    var $jsctl;
    var $jsmul;
    var $divmul;

    function __construct() {
        $this->controles=array();
    }

    function __destruct() {
        unset($this->controles);
    }

    function ver() {
        $total=count($this->controles);
        $btn_nuevo="";
        $pre_sub= "Crear ";
        $idobj="";
        switch($_POST["accion"]) {
            case 3:
            case 8: $accion=1;
                break;
            case 2:
            case 20: $accion=2;
                break;
            default: $accion=1;
        }
        if ($_POST["accion"]==20 || $_POST["accion"]==2) {
            $idobj=$_POST["idobj"];
            $this->datos->get_fila($idobj);
            $pre_sub= "Actualizar ";
            $btn_nuevo='<input type="button" value="Nuevo" class="form_submit" onclick="window.location=\''.basename($_SERVER['REQUEST_URI']).'\'" />';
        }
        elseif($this->atributos["tipo_form"]=="1") {
            $idobj=$this->atributos["id"];
            $this->datos->get_fila($idobj);
            $pre_sub= "Actualizar ";
            $btn_nuevo='';
            $accion=2;
        }
        $accionform=($this->atributos["accionform"]?$this->atributos["accionform"]:$_SERVER["PHP_SELF"]);
        $grupos="\r\n".'<!--labels de los grupos-->';
        $controles='';
        $cadf="\r\n".'<br style="clear:both"><form id="formulario" name="formulario" method="post" action="'.$accionform.'">'."\r\n";
        $cadf.='<input type="hidden" id="pag" name="pag" value="'.$_POST["pag"].'">'."\r\n";
        $cadf.='<input id="idobj" name="idobj" type="hidden" value="'.$idobj.'">'."\r\n";
        $cadf.='<input id="accion" name="accion" type="hidden" value="'.$accion.'">'."\r\n";
        $cadf.='<div  align="center"><fieldset id="form_ctls" style="width:940px">'."\r\n";
        $tit_form=$this->atributos["texto_submit"];
        if($this->atributos["titulo"]!="") $tit_form=$this->atributos["titulo"];
        $cadf.='<legend>'.$tit_form.'</legend>'."\r\n";
        $capa_err="";

        for($a=0;$a<$total;$a++) {
            $css_label="form_label";
            $css_campo="form_campo";
            switch($this->controles[$a]["tipo"]) {
                case 'abre_grupo':
                    $grupos.='<div class="lblgrupo" id="lblgrupo_'.$this->controles[$a]["campo"].'">'.$this->controles[$a]["label"].'</div>';
                    $controles.='<!--'.$this->controles[$a]["campo"].'-->';
                    $controles.='<div class="grupo" id="grupo_'.$this->controles[$a]["campo"].'">';
                    break;
                case 'cierra_grupo':
                    $controles.='</div><!--cierra grupo '.$this->controles[$a]["campo"].'-->';
                    break;
                default:
                    $controles.='<div id="fila_'.$this->controles[$a]["campo"].'" class="form_fila">';
                    if($this->controles[$a]["css_label"]!="") $css_label=$this->controles[$a]["css_label"];
                    $controles.='<div class="'.$css_label.'">'.$this->controles[$a]["label"].'</div>';

                    if($this->controles[$a]["css_campo"]!="") $css_campo=$this->controles[$a]["css_campo"];
                    $controles.='<div class="form_ctl">'.$this->control($this->controles[$a]).'</div>';
                    $controles.='</div><br style="clear:both" />'."\r\n";
                    $capa_err.='<div id="err_'.$this->controles[$a]["campo"].'" class="fila_errores"></div>';
            }
        }
        $cadf.='<div id="labelsgrupos">'.$grupos.'</div>'."\r\n".$controles;
        $capa_err='<div style="display:none;"><div id="capa_errores" style=""><div id="tit_capa_errores"><img src="images/cp-bullet_error.png" style="position:relative; top:3px;" />&nbsp;Alerta!</div><div id="content_capa_errores">'.$capa_err.$this->divmul.'<input id="cerrarslim" value="Cerrar" type="button" onclick="$.fancybox.close();"></div></div></div>';
        if($this->atributos["mostrar_submit"]!="0") {
            $cadf.='<div align="left" class="form_celda form_texto">(*) Los campos son obligatorios<br style="clear:both" />';
        }
        $cadf.='</div><br style="clear:both" />'."\r\n";

        switch($this->atributos["mostrar_submit"]) {
            case "1": if($_POST) {
                    $cadf.='<input name="Submit" type="button" class="form_submit" value="Actualizar '.$this->atributos["texto_submit"].'"  onClick="validar()"><a href="'.$_SERVER["PHP_SELF"].'" class="form_submit" style="margin-left:1px;">Volver al listado</a>';
                } break




                ;
            case "0": $cadf.="";
                break;
            default:
                $cadf.='<input name="Submit" type="button" class="form_submit" value="'.$pre_sub.$this->atributos["texto_submit"].'"  onClick="validar()">';
                if($pre_sub=="Actualizar ") {
                    if($this->atributos["grid_form"])
                        $ruta=$this->atributos["grid_form"];
                    else
                        $ruta=$_SERVER["PHP_SELF"];
                    $cadf.='<input type="button" value="Volver al listado" class="form_submit" onclick="window.location.href=\''.$ruta.'\'" style="margin-left:1px;" />';
                }
        }
        $scb='';
        if(count($this->botones)>0 && ($_POST["accion"]==20 || $_POST["accion"]==2)) {
            $scb='<script type="text/javascript">';
            foreach($this->botones as $btn) {
                $cadf.='<input name="opc'.$btn["nombre"].'" class="form_submit" id="opc'.$btn["nombre"].'" type="button" value="'.$btn["label"].'" style="margin-left:1px;" />';
                $scb.='$("#opc'.$btn["nombre"].'").click(function(){'."\n";
                $scb.="    var f=document.formulario;"."\n";
                $scb.="    f.action ='".$btn["ir"]."';"."\n";
                $scb.='    f.accion.value="'.$btn["accion"].'";'."\n";
                ////$scb.="    f.idobj.value=id;"."\n";
                $scb.="    f.submit();"."\n";
                $scb.="})"."\n";
            }
            $scb.='</script>';
        }
        if(isset($_POST["quiensoy"])) {
            $cadf.='<input name="opcenviar" type="hidden" value="0">
			<input name="Enviar" type="button" class="form_submit" value="Enviar" onClick="validar1()">';
        }
        $cadf.="\r\n";
        if($this->atributos["mostrar_volver"]=="1")  $cadf.='<input type="button" class="form_submit" value="Volver al Listado"  style="margin-left:1px;" onClick="window.location=\''.$this->atributos["url_volver"].'\'">'."\r\n";

        $cadf.='</fieldset></div>'."\r\n".'</form>'."\r\n".'<br style="clear:both" />'."\r\n";

        return $cadf.$scb.$capa_err.$this->ver_js();
    }

    function get_opciones($tabla,$campo,$ordenars) {
        $ta=new MantixOaD();
        $ordenar="";
        if($ordenars!="") $ordenar=" order by ".$ordenars;
        $ta->listaSP("select * from ".$tabla.$ordenar,"","");
        $ops='<option value=""> - Seleccione - </option>';
        $campos=explode("+",$campo);

        while($ta->no_vacio()) {
            $opvalue="";
            for($a=0;$a<count($campos);$a++) {
                $coma="";
                if($a<(count($campos)-1)) {
                    $coma=" - ";
                }
                $opvalue.=$ta->valor($campos[$a]).$coma;
            }
            $ops.='<option value="'.$ta->valor("id").'">'.$opvalue.'</option>';
        }
        unset($ta);

        return $ops;
    }

    function get_opciones_id($tabla,$campo,$ordenars,$ids,$id_asoc='0') {
        $ta=new MantixOaD();
        $ordenar="";
        if($ordenars!="") $ordenar=" order by ".$ordenars;
        if($ids!="" || 1==1) {
            $ta->listaSP("select * from ".$tabla.$ordenar,"","");
            $campos=explode("+",$campo);

            while($fila=$ta->no_vacio()) {
                $opvalue="";
                for($a=0;$a<count($campos);$a++) {
                    $coma="";
                    if($a<(count($campos)-1)) {
                        $coma=" - ";
                    }
                    $opvalue.=$ta->valor($campos[$a]).$coma;
                }
                $value=$fila[$id_asoc];
                //echo $id_asoc."a,".$ids."<br />";
                if($value==$ids) {
                    $selected=" selected ";
                }
                else
                    $selected="";
                $ops.='<option value="'.utf8_decode($value).'"'.$selected.'>'.$opvalue.'</option>';
            }
            unset($ta);
        }
        return $ops;
    }
    function do_transfers($tabla,$campo,$id_asoc,$values) {
        $vals=array();
        if($values!="")
            $vals=explode(",", $values);
        $lista=array();
        $ta=new MantixOaD();
        $res=$ta->ejecutar("select $id_asoc, $campo from $tabla where formato like '240 x 306'");
        while($r=mysql_fetch_assoc($res)) {
            if(count($vals)>0) {
                if(!in_array($r[$id_asoc], $vals)) {
                    $lista[0].='<label class="trans_li2 trans_li2_r"><img src="../tumber.php?w=140&h=140&src=../images/recursos/'.$r[$campo].'"/><input type="checkbox" value="'.$r[$id_asoc].'" /></label>';
                }
            }
            else {
                $lista[0].='<label class="trans_li2 trans_li2_r"><img src="../tumber.php?w=140&h=140&src=../images/recursos/'.$r[$campo].'"/><input type="checkbox" value="'.$r[$id_asoc].'" /></label>';
            }
        }
        foreach($vals as $val) {
            $res=$ta->ejecutar("select $id_asoc, $campo from $tabla");
            while($r=mysql_fetch_assoc($res)) {
                if($val==$r[$id_asoc]) {
                    $lista[1].='<label class="trans_li2 trans_li2_r"><img src="../images/recursos/'.$r[$campo].'"/><input type="checkbox" value="'.$r[$id_asoc].'" /></label>';
                }
            }
        }
        return $lista;
    }
    function control($ctl) {
        $cad="";
        $ast="";
        if($ctl["obligatorio"]=="1") {
            $ast="&nbsp;*";
        }

        $valor=$ctl["valor"];
        if($valor!="NULL" && $valor=="" && $_POST["accion"]!=1) $valor=$this->datos->valor($ctl["campo"]);
        if($valor=="NULL") $valor="";

        $css_campo="form_input";
        if($ctl["css_campo"]!="") $css_campo=$ctl["css_campo"];

        $tipo="text";
        if($ctl["tipo"]!="") {
            $tipo=$ctl["tipo"];
        }

        $max_car=150;
        if($ctl["max_car"]!="") $max_car=$ctl["max_car"];

        switch ($tipo) {
            case "text": $cad='<input id="'.$ctl["campo"].'" name="'.$ctl["campo"].'" type="'.$tipo.'" class="'.$css_campo.'" maxlength="' .$max_car.'" '.$ctl["extras"].' value="'.$valor.'"><input type="hidden"  id="'.$ctl["campo"].'_ant" name="'.$ctl["campo"].'_ant" value="'.$valor.'">'.$ast;
                break;
            case "listadoble":
                $cad='<div class="listadoble" id="'.$ctl["campo"].'">';
                $cad.='<div class="listaizq"><div class="contenedorlista"></div></div>';
                $cad.='<div class="controles"><a class="ld_izq"></a><a class="ld_der"></a></div>';
                $cad.='<div class="listader"><div class="contenedorlista"></div></div>';
                $cad.='</div>';
                break;
            case "transferencia":
                $lis="";
                $listas=$this->do_transfers($ctl["tabla_asoc"],$ctl["campo_asoc"],$ctl["id_asoc"],$valor);
                $cad.='<div class="trans_l transl_1" id="trans_l_'.$ctl["campo"].'"><div class="sombra_trans" id="sombra_trans_'.$ctl["campo"].'">'.$listas[0].'</div></div>'."\n";
                $cad.='<div class="trans_ctl">'."\n";
                $cad.='    <a onclick="trans_btn_r(\''.$ctl["campo"].'\')" class="trans_btn"><img src="images/flecha-fotografias_der.gif"/></a>'."\n";
                $cad.='    <a onclick="trans_btn_l(\''.$ctl["campo"].'\')" class="trans_btn"><img src="images/flecha-fotografias_izq.gif"/></a>'."\n";
                $cad.='</div>'."\n";
                $cad.='<div class="trans_l trans_l_2" id="trans_r_'.$ctl["campo"].'">'.$listas[1].'</div>'."\n";
                $cad.='<input type="hidden" name="'.$ctl["campo"].'" id="'.$ctl["campo"].'" value="'.$valor.'"/>';
                $cad.='<input type="hidden" name="'.$ctl["campo"].'_ant" value="'.$valor.'"/>';
                $cad.='<script type="text/javascript">script_transferencia("'.$ctl["campo"].'");</script>'."\n";
                break;
            case "archivogg":
                $cad.='
                    <input type="text" value="'.$valor.'" name="'.$ctl["campo"].'" id="'.$ctl["campo"].'" class="form_input" readonly class="'.$css_campo.'" '.$ctl["extras"].'/>
                    <input type="hidden" value="'.$valor.'" name="ant_'.$ctl["campo"].'" id="ant_'.$ctl["campo"].'"/>
                    <a class="uploadsubirarchivo" id="udfsubir_'.$ctl["campo"].'" title="'.$ctl["tooltip"].'">
                        <input type="text" value="'.$valor.'" name="udf_'.$ctl["campo"].'" id="udf_'.$ctl["campo"].'" class="form_input" readonly class="'.$css_campo.'" '.$ctl["extras"].'/>
                    </a>
                    <a href="" class="uploadborrar" id="udfborrar_'.$ctl["campo"].'">Eliminar</a>
                    <script type="text/javascript">hacerupload("'.$ctl["campo"].'","'.$ctl["extensiones"].'","'.$ctl["descripcion"].'")</script>
                ';
                //                    <div class="uploadborrar" id="udfborrar_'.$ctl["campo"].'"><img src="images/btn-borrar.gif"/></div>

                break;
            case "password": $cad='<input id="'.$ctl["campo"].'" name="'.$ctl["campo"].'" type="'.$tipo.'" class="'.$css_campo.'" maxlength="'.$max_car.'" '.$ctl["extras"].' value="'.$valor.'"><input type="hidden" id="'.$ctl["campo"].'_ant"  name="'.$ctl["campo"].'_ant" value="'.$valor."\">".$ast;
                break;

            case "area": $cad='<textarea id="'.$ctl["campo"].'" name="'.$ctl["campo"].'" class="form_area"  '.$ctl["extras"].' >'.$valor.'</textarea>'.$ast;
                break;

            case "checkbox": $cchk="";
                $ant_v=0;
                if ($valor!="") {
                    if ($valor==1) {
                        $cchk=" checked ";
                        $ant_v=1;
                    }
                }

                $cad= '<input name="'.$ctl["campo"].'" type="checkbox" class="form_chk" '.$ctl["extras"].$cchk.'" value="1"><input type="hidden" name="'.$ctl["campo"].'_ant" value="'.$valor.'" />';
                break;
            case "fecha":
                $cad= '<input size="10" id="' .$ctl["campo"].'" class="form_date" type="text" name="'.$ctl["campo"].'" title="DD/MM/YYYY"  value="'.$valor.'"/>'.$ast.'<input type="hidden" name="'.$ctl["campo"].'_ant value="'.$valor.'">'."\n";
                $cad.='<script type="text/javascript">$(document).ready(function(){$("#'.$ctl["campo"].'").datepicker(configdatetime);});</script>';
                break;
            case "fck":
                $cad='<div><textarea id="'.$ctl["campo"].'" name="'.$ctl["campo"].'" style="display:none">'.$valor.'</textarea><iframe id="'.$ctl["campo"].'___Frame" src="../fckeditor/editor/fckeditor.html?InstanceName='.$ctl["campo"].'" width="734" height="400" frameborder="0" scrolling="no"></iframe></div><br>';
                break;
            case "fck1":
                $cad='<div><input type=hidden id="'.$ctl["campo"].'" name="'.$ctl["campo"].'" value="'. $valor.'" style="display:none" /><iframe id="'.$ctl["campo"].'___Frame" src="../fckeditor/editor/fckeditor.html?InstanceName='.$ctl["campo"].'" width="583" height="400" frameborder="0" scrolling="no"></iframe></div><br>';
                break;
            case "archivo":
                $cad='<input name="'.$ctl["campo"].'" value="'.$valor.'" type="text" READONLY class="'.$css_campo." ".$ctl["extras"].'" >&nbsp;&nbsp;<input class="form_upload" type="button" onClick="window.open(\'files_up_'.$ctl["campo"].'.php\',\'window\', \'height=170,width=500,resizable=1\');return false;" value="Subir Archivo..." />&nbsp;&nbsp<input type="button"  value="Borrar" onclick="document.formulario.'.$ctl["campo"].'.value=\'\';" class="form_up_borrar" width="100"><input type="hidden" name="'.$ctl["campo"].'_ant" value="'.$valor.'">'.$ast;
                $this->jsctl.= " function poner_".$ctl["campo"]."(foto){ document.formulario.".$ctl["campo"].".value = foto; } ";
                break;

            case "select":
                if($ctl["tabla_asoc"]!="") {
                    $ops=$this->get_opciones_id($ctl["tabla_asoc"],$ctl["campo_asoc"],$ctl["ordenar"],$valor,$ctl["id_asoc"]);
                }
                else {
                    $ops=$ctl["opciones"];
                }

                if($valor!="") $ops=str_replace('value="'.$valor.'"','value="'.$valor.'" selected="selected" ',$ops);

                $cad= '<select id="'.$ctl["campo"].'" name="'.$ctl["campo"].'" class="form_select" '.$ctl["extras1"].'>'.$ops.'</select><input type=hidden name="'.$ctl["campo"].'_ant" value="'.$valor.'">'.$ast;
                break;
            case "galeria_tabla":
                $cad=''."\n";
                $imgs="";
                if($_POST["idobj"]!="") {
                    $sql="select * from ".$ctl["tabla"]." where idgaleria=".$_POST["idobj"]." order by id asc";
                    $xdb=new MantixOaD();
                    $resimgs=$xdb->ejecutar($sql);
                    while($rimg=mysql_fetch_object($resimgs)) {
                        $img=$rimg->galimage;
                        $comentario=$rimg->descripcion;
                        $imgs.='<div class="galitem galitem_'.$ctl["campo"].'"><div class="imgmini_'.$ctl["campo"].' aggimgmini" style="display:none; background:#fff url(../tumber.php?w=64&h=64&src=../images/recursos/'.$img.') right top"><img src="images/marco-galeria.png"/></div><a></a><span>'.$img.'</span>'."\n";
                        $imgs.='<input type="hidden" class="'.$ctl["campo"].'_img" name="'.$ctl["campo"].'_img[]" value="'.$img.'" />';
                        $imgs.='<input type="hidden" class="'.$ctl["campo"].'_comentario" name="'.$ctl["campo"].'_comentario[]" value="'.$comentario.'" />';
                        $imgs.='</div>';
                    }
                }
                /*if(strlen(trim($valor))>0)
                    $imgs=explode(",",$valor);*/
                $cad.='<div id="galeria_'.$ctl["campo"].'" class="galeria">'."\n";
                $cad.='<div class="supgolcont"></div>';
                $cad.='<div class="galcont flexcroll" id="galcont_'.$ctl["campo"].'"><div class="galajuste">'."\n";
                $cad.=$imgs;
                $cad.='</div><div style="clear:both;position:relative;"></div></div>'."\n";
                $cad.='<div class="infgolcont"></div>';
                $cad.='<div id="burbuja'.$ctl["campo"].'" class="burbuja">Haga click sobre un registro para modificarlo, suba una imagen utilizando el botón "Subir Archivo..." y al finalizar la carga el registro seleccionado será reemplazado con la nueva imagen.</div>';
                $cad.='<div class="galbar" id="galbar_'.$ctl["campo"].'">'."\n";
                $cad.='<div class="pl1_controles">';
                $cad.='    <a class="galsubir" id="galsubir_'.$ctl["campo"].'" title="'.$ctl["tooltip"].'"><input type="hidden" id="udf_'.$ctl["campo"].'"/></a>'."\n";
                $cad.='    <a class="pl1_btn" title="Ver en modo lista" id="'.$ctl["campo"].'_vlista"><img src="images/ico-listado-0.gif"></a>'."\n";
                $cad.='    <a class="pl1_btn" title="Ver en modo galería" id="'.$ctl["campo"].'_vgal"><img src="images/ico-listado-imagen-0.gif"></a>'."\n";
                $cad.='</div>';
//                $cad.='<a class="galvlista" id="galvlista_'.$ctl["campo"].'"><img src="images/galvlista.gif"/></a>'."\n";
//                $cad.='<a class="galvimages" id="galvimages_'.$ctl["campo"].'"><img src="images/galvimages.gif"/></a>'."\n";
                $cad.='</div>'."\n";
                $cad.='<script type="text/javascript">'."\n";
                $cad.='$(document).ready(function(){$("#galeria_'.$ctl["campo"].'").galeria_tabla("'.$ctl["extensiones"].'","'.$ctl["descripcion"].'")});'."\n";
                $cad.='</script>'."\n";
                //$cad.='<input type="hidden" id="'.$ctl["campo"].'" name="'.$ctl["campo"].'" value="'.$valor.'"/>';
                $cad.='</div>'."\n";
                break;
        }


        if ($ctl["obligatorio"]=="1") {
            $this->js.=$this->generar_js($ctl["label"],$ctl["campo"],$ctl["validacion"]);
        }
        $this->js.=$js_esp;
        return $cad;
    }


    function generar_js($label1,$campo,$valida) {
        $label=str_replace(":","",$label1);
        $jscad.="if ( document.getElementById('".$campo."')) { if ( document.getElementById('".$campo."').value =='' ) {" ."\n";
        $jscad.="document.getElementById('err_".$campo."').innerHTML=\"<li><strong>·</strong>&nbsp;Debe introducir un valor en el campo: <span class=labelerrorcampo>".$label."</span></li>\";"."\n";
        $jscad.="$('#".$campo."').addClass('form_fila_err');"."\n";
        $jscad.="quitarerror('#".$campo."');"."\n";
        $jscad.="res_valida=false; "."\n";
        $jscad.="} "."\n";
        $jscad.="else { document.getElementById('err_".$campo."').innerHTML=\"\";"."\n";
        switch ($valida) {
            case 1:  $jscad.="if (!isAlphabetic( f.".$campo.".value) ) { document.getElementById('err_".$campo."').innerHTML=\"<li><strong>·</strong>&nbsp; El valor del campo <span class=labelerrorcampo>".$label."</span> debe ser �nicamente letras</li>\";document.getElementById('fila_".$campo."').className='form_fila_err'; return	}"."\n";
                break;
            case 2:  $jscad.="if (!isNumber( f.".$campo.".value) ) { document.getElementById('err_".$campo."').innerHTML=\"<li><strong>·</strong>&nbsp;El valor del campo: <span class=labelerrorcampo>".$label."</span> debe ser num�rico.</li>\"; document.getElementById('fila_".$campo."').className='form_fila_err';res_valida=false;	}" ."\n";
                break;
            case 3:  $jscad.="if (!isAlphanumeric( f.".$campo.".value) ) { document.getElementById('err_".$campo."').innerHTML=\"<li><strong>·</strong>&nbsp;El valor del campo <span class=labelerrorcampo>".$label."</span> debe ser letras y n�meros</li>\"); document.getElementById('fila_".$campo."').className='form_fila_err'; res_valida=false;	}"."\n";
                break;
            case 4:  $jscad.="if (f.".$campo.".value!='')  { rexp=/(^\d{1,2}):(\d{1,2})/;  hr = rexp.exec(f.".$campo.".value);   if (hr!=null){	if ((hr[1]>24) || (hr[2]>=60)) {  document.getElementById('err_".$campo."').innerHTML=\"<li><strong>·</strong>&nbsp;Hora Inv�lida en campo: <span class=labelerrorcampo>".$label."</span></li>\"; document.getElementById('fila_".$campo."').className='form_fila_err';	res_valida=false;} }  else { document.getElementById('err_".$campo."').innerHTML=\"<li>Formato de Hora Inv�lido:  <strong>".$label." <strong></li>\";document.getElementById('fila_".$campo."').className='form_fila_err';res_valida=false; } }";
                break;
            case 5:  $jscad.="if (!isEmail( f.".$campo.".value) ) { document.getElementById('err_".$campo."').innerHTML=\"<li><strong>·</strong>&nbsp;Formato inv�lido de e-mail en:  <strong>".$label."<strong></li>\";document.getElementById('fila_".$campo."').className='form_fila_err'; res_valida=false;	}"."\n";
                break;
        }
        $jscad.="} } "."\n";
        return $jscad;
    }
    function ver_js() {
        $r.="<SCRIPT language=javascript>	" ."\n";
        $r.="function validar() { window.scrollTo(0,0);" ."\n";
        $r.="var f = document.formulario; var res_valida=true;" ."\n";
        $r.=$this->js ;
        $r.='if(res_valida)  { f.submit(); } else {  $("#linkalerta").click();  }'."\n" ;
        $r.="}" ."\n";
        $r.=$this->jsctl."\n";
        $r.=$this->jsmul;
        $r.= " function poner_multiple(nom,archivo){ document.getElementById(nom).value = archivo; } ";

        $r.="function validar1() { window.scrollTo(0,0);" ."\n";
        $r.="var f = document.formulario; var res_valida=true;" ."\n";
        $r.=$this->js ;
        $r.="if(res_valida)  { f.opcenviar.value='1';f.submit(); } else {  Dialogs.alert($('capa_errores').innerHTML);  }"."\n" ;
        $r.="}" ."\n";
        $r.=$this->jsctl."\n";
        $r.=$this->jsmul;
        $r.= " function poner_multiple(nom,archivo){ document.getElementById(nom).value = archivo; } ";


        $r.="	</script>" ."\n";

        return  $r;
    }

}
?>