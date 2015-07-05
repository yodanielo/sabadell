<?php

class MantixGrid {
    var $datos;
    var $atributos;
    var $buscador;
    var $botones;
    var $ver_buscador;
    var $js;
    var $orden;

    function MantixGrid() {
        $this->buscador=array();
        $this->columnas=array();

    }
    function __destruct() {
        unset($this->buscador);
        unset($this->columnas);
    }

    function mostrar_buscador() {
        if($this->atributos["ver_buscador"]=="1") {
            $r='<div align="center"><fieldset class="field_buscador"><legend>Buscador</legend>';
            for($a=0; $a<=count($this->buscador)-1;$a++) {
                $r.='<div class="form_fila"><div class="form_label">'.$this->buscador[$a]["label"].'</div><div class="form_ctl">';
                $tipo="text";
                if($this->buscador[$a]["tipo"]!="") $tipo=$this->buscador[$a]["tipo"];
                switch($tipo) {
                    case "text" : $r.='<input class="form_input" type="input" name="bus_'.$this->buscador[$a]["id"].'" id="bus_'.$this->buscador[$a]["id"].'" value="'.$_POST["bus_".$this->buscador[$a]["id"]].'" />';
                        break;
                    case "select":
                        if($this->buscador[$a]["tabla_asoc"]!="") {
                            $ta=new MantixOaD();
                            $ordenar="";
                            if($this->buscador[$a]["ordenar"]!="") $ordenar=" order by ".$this->buscador[$a]["ordenar"];

                            $ta->listaSP("select * from ".$this->buscador[$a]["tabla_asoc"].$ordenar,"","");
                            $ops='<option value=""> - Seleccione - </option>';
                            $campos=explode("+",$this->buscador[$a]["campo_asoc"]);

                            while($ta->no_vacio()) {
                                $opvalue="";
                                for($b=0;$b<count($campos);$b++) {
                                    $coma="";
                                    if($b<(count($campos)-1)) {
                                        $coma=" - ";
                                    }
                                    $opvalue.=$ta->valor($campos[$b]).$coma;
                                }
                                $ops.='<option value="'.$ta->valor("id").'">'.($opvalue).'</option>';
                            }
                            unset($ta);
                        }
                        else {
                            $ops=$this->buscador[$a]["opciones"];
                        }

                        if($_POST['bus_'.$this->buscador[$a]["id"]]!="") $ops=str_replace('value="'.$_POST['bus_'.$this->buscador[$a]["id"]].'"','value="'.$_POST['bus_'.$this->buscador[$a]["id"]].'" selected="selected" ',$ops);
                        $r.= '<select id="bus_'.$this->buscador[$a]["id"].'" name="bus_'.$this->buscador[$a]["id"].'" class="form_select" '.$this->buscador[$a]["extras"].'>'.$ops.'</select>';
                        break;
                    case "fecha":
                        $r.= '<input size="10" id="bus_' .$this->buscador[$a]["id"].'" class="form_date" type="text" READONLY name="bus_'.$this->buscador[$a]["id"].'" value="'.$_POST['bus_'.$this->buscador[$a]["id"]].'" title="DD/MM/YYYY" > <input type="button" class="form_submit" value="ver calendario" onclick="scwShow(scwID(\'bus_'.$this->buscador[$a]["id"].'\'),event)">';
                        break;
                }
                $r.='</div></div><br style="clear:both" />';
            }
            if(isset($this->atributos["sin_buscar"])) {
                $r.='<input type="hidden" name="sinbuscar" value="1">';
            }
            $r.='<br style="clear:both" /><div id="fila_form" align="center"><input class="form_submit" type="button" onclick="grid_buscar()" value="Buscar" />&nbsp;<input class="form_submit" type="button" value="Volver al listado" onClick="location.href=\''.$_SERVER['REQUEST_URI'].'\'" style="margin-left:1px;" /></div></fieldset></div>';
            //$r.='<script type="text/javascript">$(".field_buscador").slideUp(1, function(){});</script>';
        }
        return $r;
    }

    function filtrar_buscador() {
        $cad="";
        if(!isset($this->atributos["sin_buscar"])) {
            for($a=0; $a<count($this->buscador);$a++) {
                if($_POST['bus_'.$this->buscador[$a]["id"]]!="") {
                    if($cad!="") {
                        $cad.=" and ";
                    }
                    $tipo="text";
                    if($this->buscador[$a]["tipo"]!="") $tipo=$this->buscador[$a]["tipo"];
                    switch($tipo) {
                        case "text" : $cad.= $this->buscador[$a]["campo"]." like '%".$_POST['bus_'.$this->buscador[$a]["id"]]."%'";
                            break;
                        case "select" : $cad.= $this->buscador[$a]["campo"]."='".$_POST['bus_'.$this->buscador[$a]["id"]]."'";
                            break;
                    }
                }
            }
        }
        return $cad;
    }


    function ver() {
        $p_actual=1;
        if($_POST["pag"]=="" || !isset($_POST["pag"]))
            $_POST["pag"]=1;
        if($_POST["paginacion"]=="" || !isset($_POST["paginacion"]))
            $_POST["paginacion"]=20;
        if ($_POST["pag"] != "" && isset($_POST["pag"]) ) {
            $p_actual = $_POST["pag"];
        } else {
            $p_actual = 1;
        }
        if($p_actual=="undefined" || !isset($p_actual))
            $p_actual=1;
        $this->datos = new MantixOaD();
        $this->datos->tabla=$this->atributos["tabla"];
        $this->atributos["nropag"]=$_POST["paginacion"];
        $this->datos->l_nropag =$this->atributos["nropag"];

        $cad=$this->filtrar_buscador();
        if($this->atributos["ver_buscador"]=="1") {
            if($this->atributos["sql"]!="" and $cad!="") {
                $pwhere = strpos($cad, "where");
                if($pwhere===false) {
                    $this->atributos["sql"].=" where ".$cad;
                }
                else {
                    $this->atributos["sql"].=" and ".$cad;
                }
            }
            if($this->atributos["tabla"]!="" and $cad!="") {
                $pwhere = strpos($filtro2, "and");
                if($pwhere===false) {
                    $filtro2.= $cad;
                }
                else {
                    $filtro2.=" and ".$cad;
                }
            }
            //echo $this->atributos["sql"];
        }
        $ordenar=$this->atributos["ordenar"];
        if($_POST["grid_ordenar"]!="") $ordenar=$_POST["grid_ordenar"];
        $this->datos->lista($this->atributos["sql"], $filtro2,$ordenar,$p_actual);
        if(!$_POST["tipo"]) {
            $r='<form id="form_grid" name="form_grid" method="post">';
            $r.='<input type="hidden" id="accion" name="accion" value="2">';
            $r.='<input type="hidden" id="idobj" name="idobj">';
            $r.='<input type="hidden" id="nropag" name="nropag" value="20">';
            //$r.='<input type="hidden" id="pag" name="pag" value="'.$_POST["pag"].'">';
            $r.='<input type="hidden" id="grid_ordenar" name="grid_ordenar" value="'.$_POST["grid_ordenar"].'">';
            $r.=$this->mostrar_buscador();
        }
        if (!$this->datos->vacio() ) {
            if(!$_POST["tipo"]) {
                $r.='<div id="grilla_principal">';
                $r.='<table class="grillabar" width="98%" align=center border=0 cellpadding=0 cellspacing=1><tr><td>';
                if ($this->atributos["ver_barra"]=="") {
                    //$r.='<tr><td align="left" height="20" colspan=20 >';
                    $r.='<div class="contbar">';
                    if($this->atributos["ver_estado"]=="") {
                        //$r.='<input type="button" value="Activar" class="grid_bar" onclick="grid_toggle_estado()" />&nbsp;<input type="button" value="Desactivar" class="grid_bar" onclick="grid_desactivar_multiple()" />&nbsp;';
                        $r.='<input type="button" value="Cambiar estado" title="Activar / Desactivar Registros" class="grid_bar" onclick="grid_toggle_estado()" style="width:114px;" />';
                    }
                    if($this->atributos["ver_eliminar"]=="") {
                        $r.='<input type="button" value="Eliminar" class="grid_bar" title="Eliminar Registros" style="width:86px;" onclick="grid_eliminar_multiple()" />';
                    }
                    if($this->atributos["ver_exportar"]=="1") {
                        $r.='<input type="button" value="Exportar Filtro" class="grid_bar" onclick="grid_exportar_filtro()" />';
                    }
                    if(count($this->botones)>0)
                        foreach($this->botones as $btn) {
                            //$r.='<input class="grid_bar" href="'.$btn["link"].'" title="'.$btn["label"].'">'.$btn["label"].'</a>&nbsp;';
                            $r.='<input type="button" value="'.$btn["label"].'" class="grid_bar" onclick="window.location.href=\''.$btn["link"].'\'" />&nbsp;';
                        }
                    if($this->atributos["ver_anio"]=="1") {
                        $r.='<div title="Cambiar Año" class="icono_anio"><img src="images/icono-orden.png"/></div>';
                    }
                    if(is_array($this->orden)) {
                        $r.='<div title="Ordenar Registros" class="icono_ordenar"><img src="images/icono-orden.png"/></div>';
                    }
                    if($this->atributos["ver_maximizar"]=="") {
                        $r.='<div title="Maximizar / Minimizar Grid" class="icono_maxmin iconoright"><img src="images/icono-max-min.png"/></div>';
                    }
                    if($this->atributos["ver_columnas"]=="") {
                        $r.='<div title="Mostrar / Ocultar Columnas" class="icono_columnas iconoright"><img src="images/icono-agregar-campos.png"/><div class="listacolumnas"></div></div>';
                    }
                    if($this->atributos["ver_actualizar"]=="") {
                        $r.='<a href="#" title="Actualizar" class="icono_actualizar"><img src="images/icono-actualizar.png"/></a>';
                    }
                    if($this->atributos["ver_buscador"]=="1") {
                        $r.='<div title="Mostrar / Ocultar Buscador" class="icono_buscar iconoright"><img src="images/icono-buscar.png"/></div>';
                    }
                    $r.='</div>';
                    //$r.="</td></tr>";
                }
                $r.='</td></tr></table>';
                $r.='<div id="gridajax">';
            }
            $r.='<table id="grilladatos" width="98%" align=center border=0 cellpadding=0 cellspacing=1>';

            $r.="<tr>";

            if($this->atributos["ver_chk"]=="") {
                $r.="<td width=\"10\" class=\"grid_header\" ><input type=\"hidden\" name=\"chk_true\" value=\"0\"><input type=\"checkbox\" name=\"multi\" value=\"\" onclick=\"marcatodo();\" /></td>";
            }
            if ($this->atributos["ver_modificar"]=="") {
                $r.=" <td width=37 valign=middle class=grid_header align=center>Abrir</td>";
            }
            if ($this->atributos["ver_estado"]=="") {
                $r.="	<td width=37 valign=middle class=grid_header align=center>Estado</td>";
            }
            if ($this->atributos["ver_eliminar"]=="") {
                $r.="	<td width=37  valign=middle class=grid_header align=center>Eliminar</td>";
            }
            if ($this->atributos["ver_nro"]=="") {
                $r.=" <td width=36 height=21 valign=middle align=center class=grid_header>Nro</td>";
            }

            for($a=0;$a<count($this->columnas);$a++) {
                $css_header=($this->columnas[$a]["css_header"]!="")?$this->columnas[$a]["css_header"]:"grid_header";
                $img_asc=(strpos($_POST["grid_ordenar"], $this->columnas[$a]["campo"]." asc")===false)?"images/asc.png":"images/asc_color.png";
                $img_desc=(strpos($_POST["grid_ordenar"], $this->columnas[$a]["campo"]." desc")===false)?"images/desc.png":"images/desc_color.png";

                $r.=' <td width="'.$this->columnas[$a]["ancho"].'" height="34" valign="top" class="'.$css_header.' col'.$this->columnas[$a]["campo"].'" align="left">';
                $r.=' <a name="grid"></a>';
                $r.=' <table border="0" cellspacing="0" height="34" width="100%" align="left"><tr><td valign="middle" align=left>';
                if($img_desc!="images/desc_color.png")
                    $r.=' <a href="#grid" onclick="grid_ordenar_desc(\''.$this->columnas[$a]["campo"].'\')"><img border="0" class="icosordenar orddesc" src="'.$img_desc.'" width="12" height="7"></a>';
                if($img_asc!="images/asc_color.png")
                    $r.=' <a href="#grid" onclick="grid_ordenar_asc(\''.$this->columnas[$a]["campo"].'\')"><img border="0" src="'.$img_asc.'" class="icosordenar ordasc" width="12" height="7"></a>';
                $r.=' </td><td  height="20" align="center" class="'.$css_header.'">'.$this->columnas[$a]["titulo"]."</td></tr></table></td>";

            }
            $r.="</tr>\r\n ";

            $fi=$this->atributos["nropag"]*($p_actual-1);

            $r_col="";
            $g_ver="";

            while ($this->datos->no_vacio()) {
                $fi++;
                $ord=$fi;
                if(is_array($this->orden))
                    $ord=$this->datos->valor($this->orden["ordenar"]);
                if (($fi % 2)==0 ) {
                    $r.="<tr class=\"grid_color1\"  onmouseover=\"this.className='grid_colorover'\" onmouseout=\"this.className='grid_color1'\"  >";
                }
                else {
                    $r.="<tr class=\"grid_color2\" onmouseover=\"this.className='grid_colorover'\"  onmouseout=\"this.className='grid_color2'\" >";
                }
                if($this->atributos["ver_chk"]=="") {
                    $r.='<td align="center"> <input type="checkbox" id="reg'.$fi.'" name="cid[]" value="'.$this->datos->valor("id").'" onclick="esActivo(this.checked);" /> </td>';
                }

                if ($this->atributos["ver_modificar"]=="") {
                    $r.='<td valign=middle align=center><a href="#" onClick="grid_modificar('.$this->datos->valor("id").')"><img border=0 src="images/application_form_edit.png" width="16" height="16"></a></td>';
                }

                if ($this->datos->valor("estado") ==1 ) {
                    $estado="<img border=0 src=\"images/activo.png\">";
                } else {
                    $estado="<img border=0 src=\"images/inactivo.gif\">";
                }

                if ($this->datos->valor("estado") ==0 ) {
                    $aref='<a name="reg'.$this->datos->valor("id").'"></a><a href="#reg'.$this->datos->valor("id").'" onClick="grid_activar_ajax('.$this->datos->valor("id").')"><img border=0 src="images/inactivo.png"></a>';
                }  else {
                    $aref='<a name="reg'.$this->datos->valor("id").'"></a><a href="#reg'.$this->datos->valor("id").'" onClick="grid_desactivar_ajax('.$this->datos->valor("id").')"><img border=0 src="images/activo.png"></a>';
                }

                if ($this->atributos["ver_estado"]=="") {
                    $r.='<td valign="middle" align="center">'.$aref.'</td>';
                }

                if ($this->atributos["ver_eliminar"]=="") {
                    $r.='<td valign="middle" align="center"><a href="#" onClick="grid_eliminar('.$this->datos->valor("id").')"><img border=0 src="images/cross.png"></a></td>';
                }

                if ($this->atributos["ver_nro"]=="") {
                    $r.=" <td height=21 valign=middle align=center class=\"form_centrar itemordenar\">".$ord."</td>";
                }

                for ($a=0; $a<count($this->columnas);$a++) {
                    $css_celda=($this->columnas[$a]["css_celda"]!="")?' class="'.$this->columnas[$a]["css_celda"].'" ':"";
                    $alias=($this->columnas[$a]["alias"]!="")?$this->columnas[$a]["alias"]:$this->columnas[$a]["campo"];

                    $r.=" <td class=\"col".$this->columnas[$a]["campo"]."\" height=21 valign=middle ".(($this->atributos["ver_modificar"]=="")?' onclick="grid_modificar('.$this->datos->valor("id").')" style="cursor:pointer"':"")." ".$css_celda.">&nbsp;".$this->datos->valor($alias)."</td> ";
                }
                /*
  	if ($this->contador_esp>0 ) {
		for ($a=1;$a<=$this->contador_esp;$a++)
		{
			 $r.=" <td valign=middle class=grid_sec align=center>";
		    			 if ( $this->cols_esp[$a]->c_eval!="")
			 {
			 	  if (eval(" return ".$this->cols_esp[$a]->c_eval.";") )
				  { 
				    $url_esp= $this->cols_esp[$a]->url."&idboj=".$this->datos->valor("id");
					if(strstr($url_esp,"javascript:")) { $url_esp.="')"; }
					$r.="<a href=\"".$url_esp."\" class=\"grid_esp\" target=".$this->cols_esp[$a]->ventana." class=\"grid_esp\">".$this->cols_esp[$a]->titurl."</a></td>"; 
				  }
				  else 
				  { 
					$r.=$this->cols_esp[$a]->titurl."</td>";  
				   }
			 }
			 else
			 { 
			   $r.="<a href=\"".$this->cols_esp[$a]->url."&idboj=".$this->datos->valor("id")." \" target=".$this->cols_esp[$a]->ventana." class=\"grid_esp\">".$this->cols_esp[$a]->titurl."</a></td>"; 
			 }
		}
	} 
                */
                $r.="</tr>";
            }

            $t_pag = $this->datos->pagina;
            /*if($p_actual>=$t_pag) {
                $p_actual=$t_pag;
            }*/
            $r.='</table>'."\n";//fin de tabla de datos
            if(!$_POST["tipo"]) {
                $r.='</div>';
                $r.='<table class="grillabar" width="98%" align=center border=0 cellpadding=0 cellspacing=1><tr><td>';
                if ($this->atributos["ver_barra"]=="") {
                    //$r.='<tr><td align="left" height="20" colspan=20 >';
                    $r.='<div class="contbar">';
                    if($this->atributos["ver_estado"]=="") {
                        //$r.='<input type="button" value="Activar" class="grid_bar" onclick="grid_toggle_estado()" />&nbsp;<input type="button" value="Desactivar" class="grid_bar" onclick="grid_desactivar_multiple()" />&nbsp;';
                        $r.='<input type="button" value="Cambiar estado" title="Activar / Desactivar Registros" class="grid_bar" onclick="grid_toggle_estado()" style="width:114px;" />';
                    }
                    if($this->atributos["ver_eliminar"]=="") {
                        $r.='<input type="button" value="Eliminar" class="grid_bar" title="Eliminar Registros" style="width:86px;" onclick="grid_eliminar_multiple()" />';
                    }
                    if($this->atributos["ver_exportar"]=="1") {
                        $r.='<input type="button" value="Exportar Filtro" class="grid_bar" onclick="grid_exportar_filtro()" />';
                    }
                    if(count($this->botones)>0)
                        foreach($this->botones as $btn) {
                            //$r.='<input class="grid_bar" href="'.$btn["link"].'" title="'.$btn["label"].'">'.$btn["label"].'</a>&nbsp;';
                            $r.='<input type="button" value="'.$btn["label"].'" class="grid_bar" onclick="window.location.href=\''.$btn["link"].'\'" />';
                        }
                    if(is_array($this->orden)) {
                        $r.='<div title="Ordenar Registros" class="icono_ordenar"><img src="images/icono-orden.png"/></div>';
                    }
                    if($this->atributos["ver_anio"]=="1") {
                        $r.='<div title="Cambiar Año" class="icono_anio"><img src="images/icono-orden.png"/></div>';
                    }
                    
                    $r.='</div>';
                    //$r.="</td></tr>";
                }
                $r.='</td></tr></table>';
            }
            if(!$_POST["tipo"]) {

                $r.='<table width="98%" align="center" border="0" cellpadding="1" cellspacing="0" id="tabla_paginacion">'."\n";
                $r.="<tr><td height=10 ></td></tr><tr><td colspan=20 class=grid_paginado>";
                if ($t_pag>1 ) {
                    $patras='<span class="grid_nropag" rel="1" onclick="grid_pagina_ajax(this)"> <img class="gridicocentrado" src="images/icono1i-pag-cpanel.gif"/> </span>';
                    if ($p_actual >1  ) {
                        $patras.='<span class="grid_nropag gridpatras" onclick="grid_pagina_ajax(this)" rel="'.($p_actual-1).'"> <img class="gridicocentrado" src="images/icono2i-pag-cpanel.gif"/> </span>';
                    }
                    else {
                        $patras.='<span class="grid_nropag gridpatras" onclick="grid_pagina_ajax(this)" rel="'.($p_actual+1).'" ><img class="gridicocentrado" src="images/icono2i-pag-cpanel.gif"/> </span>';
                    }
                    $r.="".$patras.'P&aacute;gina: <input type="text" value="'.$p_actual.'" name="pag" id="irpag" /> de '.$t_pag;
                    if ($p_actual <$t_pag ) {
                        $r.='<span class="grid_nropag gridpadelante" onclick="grid_pagina_ajax(this)" rel="'.($p_actual+1).'"> <img class="gridicocentrado" src="images/icono2d-pag-cpanel.gif"/></span>';
                        //$r.='<a class="grid_nropag" href="#" onclick="grid_pagina_ajax('.($p_actual+1).')"> <img class="gridicocentrado" src="images/icono2-pag-cpanel.gif"/></a>';
                    }
                    else {
                        $r.='<span class="grid_nropag gridpadelante" onclick="grid_pagina_ajax(this)" rel="'.($p_actual+1).'"> <img class="gridicocentrado" src="images/icono2d-pag-cpanel.gif"/></span>';
                    }
                    $r.='<span class="grid_nropag" rel="'.$t_pag.'" onclick="grid_pagina_ajax(this)"> <img class="gridicocentrado" src="images/icono1d-pag-cpanel.gif"></span>';
                    /*$r.="&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; P&aacute;ginas <img class=\"gridicocentrado\" src=\"images/icono2-pag-cpanel.gif\"/>";
                for ($a=1;$a<=$t_pag;$a++) {
                    if ($a==$p_actual) {
                        $r.="&nbsp;<span class=\"grid_nropag_selected\">".$a."</span>" ;
                    }
                    else {
                        $r.='&nbsp<a class="grid_nropag" href="#" onclick="grid_pagina_ajax('.$a.')">'.$a."</a>";
                    }
                    if(($a %50)==0) $r.="<br>";
                }*/
                    $regdesde=($this->atributos["nropag"]*($p_actual-1)+1);
                    $reghasta=$regdesde+($this->atributos["nropag"]-1);
                    if($reghasta>$this->datos->l_nroreg) {
                        $reghasta=$this->datos->l_nroreg;
                    }
                    $rpp ='<option value="10">10</option>';
                    $rpp.='<option value="15">15</option>';
                    $rpp.='<option value="20" selected>20</option>';
                    $rpp.='<option value="25">25</option>';
                    $rpp.='<option value="30">30</option>';
                    $r.='<div class="divrpp"><select id="rpp" onchange="ir_paginacion()" onselect="ir_paginacion()" name="rpp>'.$rpp.'</select>Registros por página</div>&nbsp;Mostrando del <span id="pdesde">'.$regdesde.'</span> al <span id="phasta">'.$reghasta.'</span> de <span id="pde">'.$this->datos->l_nroreg.'</span> registros.<img id="cargandoregistros" src="images/loading.gif" />';
                }
                $r.="</td></tr>";
                $r.=" </td></tr><input type=\"hidden\" name=\"totalreg\" value=\"".$fi."\" /></table></div>";
                $r.=" </td></tr><input type=\"hidden\" name=\"exportar\" value=\"0\" /></table></div>";
            }
            else {
                $r.='<script type="text/javascript">'."\n";
                if ($p_actual <=$t_pag ) {
                    $r.='    $(".gridpadelante").attr("rel", "'.($p_actual+1).'");'."\n";
                }else {
                    $r.='    $(".gridpadelante").attr("rel", "'.$p_actual.'");'."\n";
                }
                if ($p_actual >1  ) {
                    $r.='    $(".gridpatras").attr("rel", "'.($p_actual-1).'");'."\n";
                }else {
                    $r.='    $(".gridpatras").attr("rel", "'.$p_actual.'");'."\n";
                }
                $r.='    $("#irpag").val('.$p_actual.');'."\n";
                $r.='</script>'."\n";
            }
        }
        else {
            $r.='<br><br><div align="center" class="grid_paginado">No existen registros para mostrar.</div>';
        }
        if(!$_POST["tipo"]) {
            $this->datos->cerrar();

            $r.="</form>";
            $idscolumnas=array();
            $lblcolumnas=array();
            for($a=0;$a<count($this->columnas);$a++) {
                array_push($idscolumnas, $this->columnas[$a]["campo"]);
                array_push($lblcolumnas, $this->columnas[$a]["titulo"]);
            }
            $r.='<script type="text/javascript">';
            $r.='lblcolumnas=new Array("'.implode('","',$lblcolumnas).'");';
            $r.='idscolumnas=new Array("'.implode('","',$idscolumnas).'");';
            //$r.='//rellenando lista de columnas';
            $r.='lstcols=\'\';';
            $r.='for(i=0;i<lblcolumnas.length;i++){';
            //onclick="togglecols(this,\\\'\'+idscolumnas[i]+\'\\\')"
            $r.='    lstcols+=\'<label><input rel="\'+idscolumnas[i]+\'" checked type="checkbox" />&nbsp;\'+lblcolumnas[i]+\'</label>\';';
            $r.='}';
            $r.='$(".listacolumnas").html(lstcols);';
            $r.='</script>';
            return $r.$this->ver_js();
        }
        else {
            return $r;
        }
    }

    function ver_js() {
        $url=($this->atributos["url"]!="")?$this->atributos["url"]:$_SERVER['PHP_SELF'];
        $url_form=($this->atributos["url_form"]!="")?$this->atributos["url_form"]:$url;

        $r= " <script>";
        $r.= " function armar_ordenar(cad, campo, dire){";
        $r.= " var ind, pos,slista;";
        $r.= " var spos=-1;";
        $r.= " var lista=cad.split(',');";
        $r.= " var valor=campo+dire;";
        $r.= " for(ind=0; ind<lista.length; ind++)";
        $r.= "    {";
        $r.= "     if (lista[ind] == valor)";
        $r.= "      break;";
        $r.= "     }";
        $r.= " pos = (ind < lista.length)? ind : -1;";
        $r.= " if(pos!=-1) { lista.splice(pos,1); }";
        $r.= " else { ";
        $r.= " for(ind=0; ind<lista.length; ind++)";
        $r.= "   {";
        $r.= "     slista=lista[ind];";
        $r.= "     ncampo=slista.split(' ');";
        $r.= "     if (ncampo[0]==campo) {";
        $r.= "      spos=ind;";
        $r.= "      break;";
        $r.= "     }";
        $r.= "   }";
        $r.= " if(spos!=-1) { lista.splice(spos,1); }";
        $r.= " lista.push(valor); }";
        $r.= " if(lista[0]=='') { lista.splice(0,1); }";
        $r.= " return lista.join(',');";
        $r.= " } ";
        $r.= " function grid_buscar() { ";
        $r.= "  	var f=document.form_grid; ";
        $r.="	    f.accion.value='';";
        $r.="	    f.action ='".$url."';";
        $r.="		f.submit();";
        $r.="	} ";
        $r.= " function grid_ordenar_asc(campo) { ";
        $r.= "  	var f=document.form_grid; ";
        $r.="	    f.action ='".$url."#grid';";
        $r.="	    f.accion.value='';";
        $r.="	    f.grid_ordenar.value=armar_ordenar(f.grid_ordenar.value,campo,' asc');";
        $r.="		f.submit();";
        $r.="	} ";
        $r.= " function grid_ordenar_desc(campo) { ";
        $r.= "  	var f=document.form_grid; ";
        $r.="	    f.accion.value='';";
        $r.="	    f.action ='".$url."#grid';";
        $r.="	    f.accion.value='';";
        $r.="	    f.grid_ordenar.value=armar_ordenar(f.grid_ordenar.value,campo,' desc');";
        $r.="		f.submit();";
        $r.="	} ";

        $r.=" function grid_pagina(nro) { ";
        $r.= "  	var f=document.form_grid; ";
        $r.="	    f.action ='".$url."#grid';";
        $r.="	    f.pag.value=nro;";
        $r.="	    f.accion.value='';";
        $r.="		f.submit();";
        $r.="	} ";
        $r.= " function grid_modificar(id) { ";
        $r.= "  	var f=document.form_grid; ";
        $r.="	    f.action ='".$url_form."';";
        $r.="	    f.accion.value=20;";
        $r.="	    f.idobj.value=id;";
        $r.="		f.submit();";
        $r.="	} ";
        $r.= " function grid_activar(id) { ";
        $r.= "  	var f=document.form_grid; ";
        $r.="	    f.action ='".$url."#reg'+id;";
        $r.="	    f.accion.value=9;";
        $r.="	    f.idobj.value=id;";
        $r.="		f.submit();";
        $r.="	} ";
        $r.= " function grid_desactivar(id) { ";
        $r.= "  	var f=document.form_grid; ";
        $r.="	    f.action ='".$url."#reg'+id;";
        $r.="	    f.accion.value=10;";
        $r.="	    f.idobj.value=id;";
        $r.="		f.submit();";
        $r.="	} ";
        $r.="	function esActivo(isitchecked){" ."\n";
        $r.="		if (isitchecked == true){"."\n";
        $r.="			document.form_grid.chk_true.value++;" ."\n";
        $r.= "		}"."\n";
        $r.= "		else {" ."\n";
        $r.= "			document.form_grid.chk_true.value--;" ."\n";
        $r.= "		}" ."\n";
        $r.= "	}"."\n";
        $r.="	function grid_eliminar(id) "."\n";
        $r.="	{ "."\n";
        $r.= "    var f=document.form_grid; ";
        $r.="	  resp=window.confirm(\"¿Desea Continuar con la Eliminación del Registro?\");"."\n";
        $r.="	  if (resp)" ."\n";
        $r.="	  {"."\n";
        $r.="	    f.action ='".$url."';";
        $r.="	    f.accion.value=8;";
        $r.="	    f.idobj.value=id;";
        $r.="		f.submit();";
        $r.="	   }"."\n";
        $r.="	  return resp;"."\n";
        $r.="	}"."\n";

        
        $r.= "	function grid_eliminar_multiple() {" ."\n";
        $r.= "	var f=document.form_grid;"."\n";
        $r.= "     if(f.chk_true.value==0){"."\n";
        $r.= "      alert('Debe seleccionar al menos un registro.');"."\n";
        $r.= "      return; "."\n";
        $r.= "     }"."\n";
        $r.= '	var resp=window.confirm("¿Desea Continuar con la Eliminación del Registro?");'."\n";
        $r.= "	 if (resp)"."\n";
        $r.= "	  {" ."\n";
        $r.="	    f.action ='".$url."';";
        $r.= "		f.accion.value=3;"."\n";
        $r.= "		f.submit();";
        $r.= "	   }"."\n";
        $r.= "	 }"."\n";
        $r.= "function grid_toggle_estado(){"."\n";
        $r.= "    var f=document.form_grid;"."\n";
        $r.= "     if(f.chk_true.value==0){"."\n";
        $r.= "         alert('Debe seleccionar al menos un registro.');"."\n";
        $r.= "         return;"."\n";
        $r.= "     }"."\n";
        $r.= "    f.action ='".$url."';";
        $r.= "     f.accion.value=12;"."\n";
        $r.= "     f.submit();"."\n";
        $r.= "}"."\n";
        $r.= "	function grid_activar_multiple() {" ."\n";
        $r.= "    var f=document.form_grid;"."\n";
        $r.= "     if(f.chk_true.value==0){"."\n";
        $r.= "      alert('Debe seleccionar al menos un registro.');"."\n";
        $r.= "      return; "."\n";
        $r.= "     }"."\n";
        $r.="	    f.action ='".$url."';";
        $r.="  		f.accion.value = 4; ";
        $r.="  		f.submit(); }"."\n";
        $r.= "	function grid_desactivar_multiple() {"."\n";
        $r.= "      var f=document.form_grid;"."\n";
        $r.= "     if(f.chk_true.value==0){"."\n";
        $r.= "      alert('Debe seleccionar al menos un registro.');"."\n";
        $r.= "      return; "."\n";
        $r.= "     }"."\n";
        $r.="	    f.action ='".$url."';";
        $r.="  		f.accion.value = 5;";
        $r.="  		f.submit(); }"."\n";
        $r.="	function grid_exportar_filtro(){"."\n";
        $r.= "    var f=document.form_grid;"."\n";
        $r.="		f.exportar.value='1';"."\n";
        $r.="		f.submit();"."\n";
        $r.="	}"."\n";
        $r.= " </script>";
        return $r;

    }

    function verifica_sel($id) {
        $cad=explode(",",$this->descheck);
        for($a=0;$a<count($cad);$a++) {
            if($idboj==$cad[$a]) return " ";
        }
        return " checked=\"checked\" " ;
    }

}
?>