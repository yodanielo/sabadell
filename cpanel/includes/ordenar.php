<?php
class grid_ordenar {
    private $ord;
    private $ord_ant;
    private $datos;
    private $tabla;
    private $campo;
    //el campo predeterminado para ordenar es "orden"
    function __construct($db,$tabla,$campo="orden",$agrupar="") {
        $this->datos=$db;
        $this->tabla=$tabla;
        $this->campo=$campo;
        $this->agrupar=($agrupar!="" && $agrupar?" and ".$agrupar:"");
        $this->ord=$_POST["ord"];
        $this->ord_ant=$_POST["ord_ant"];
    }
    function ordenar_todos() {
        foreach($this->ord as $key=>$o) {
            if($this->ord[$key]!=$this->ord_ant[$key]) {
                $this->ordenar_uno($key);
            }
        }
    }
    private function rellenar_orden() {
        $res=$this->datos->ejecutar("select * from mtf_jugadores");
        $i=1;
        while($r=mysql_fetch_object($res)) {
            $sql="update mtf_jugadores set orden=".$i." where id=".$r->id;
            $this->datos->ejecutar($sql);
            $i++;
        }
    }
    private function ordenar_uno($key) {
        $orden=$this->ord[$key];
        if((int)$orden<=0) {
            $orden=1;
        }
        $d2=$this->datos;
        $campo=$this->campo;
        //obtener el id
        $sql="select id from ".$this->tabla." where ".$campo."=".$this->ord_ant[$key].$this->agrupar;
        //echo $sql;
        $id=$d2->get_simple($sql);
        //eliminar el que tengo
        if((int)$this->ord_ant[$key]>=1) {
            $sql="update ".$this->tabla." set ".$campo."=".$campo."-1 where ".$campo.">=".$this->ord_ant[$key].$this->agrupar;//." and estado=1";
            $d2->ejecutar($sql);
        }
        $sql="select max(".$campo.")+1 as conteo from ".$this->tabla." where ".$campo."<".$orden.$this->agrupar;//." and estado=1";
        $r=$d2->get_simple($sql);
        //die("E");
        $orden=$r;
        if((int)$orden<=0) {
            $orden=1;
        }
        $d2->ejecutar("update ".$this->tabla." set ".$campo."=".$campo."+1 where ".$campo.">=".$orden.$this->agrupar);//." and estado=1");
        $d2->ejecutar("update ".$this->tabla." set ".$campo."=".$orden." where id=".$id.$this->agrupar);
    }
    public function insertar_orden($id) {
        //obtengo el maximo mas 1
        $sql="select if(isnull(max($this->campo)),1,max(orden)+1) from ".$this->tabla." where 1=1".$this->agrupar;
        $r=$this->datos->get_simple($sql);
        /*$sql="select id from ".$this->tabla." order by id desc limit 1";
        $id=$this->datos->get_simple($sql);*/
        $sql="update ".$this->tabla." set ".$this->campo."=".$r." where id=".$id;
        $this->datos->ejecutar($sql);
    }
    public function eliminar_orden($id) {
        $sql="select $this->campo from $this->tabla where id=$id".$this->agrupar;
        $ord=$this->datos->get_simple($sql);
        $sql="update ".$this->tabla." set ".$this->campo."=".$this->campo."-1 where $this->campo>".$ord.$this->agrupar;
        $this->datos->ejecutar($sql);
    }
}
?>