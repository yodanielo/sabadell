<?php

class Lpaginacion {
/**
 * obtinene una consulta paginada
 * @param Database $db el objeto dabase para hacer la ocnsulta
 * @param <type> $sql la sentencia que se va a paginar
 * @param <type> $numResults el numero de resultado por pagina
 * @param <type> $pagActual se ingresa la pagina actual que se desea ver y regresa la apgina actual correcta
 * @param <type> $numPags regresa el numero de paginas
 * @param <type> $totalRes regresa el numero de resultados totales
 * @return <type> retorna lo resultados de la paginacion
 */
    function doPagination(Database $db, $sql, $numResults, &$pagActual, &$numPags, &$totalRes=null) {
        //saco el numero de resultados total
        $totalRes = count($db->loadObjectList($sql));
        $numPags = ceil($totalRes / $numResults);
        if ($pagActual >= $numPags)
            $pagActual = $numPags;
        $lmin = ($pagActual - 1) * $numResults;
        $lmin=($lmin<0?0:$lmin);
        $lmax = $numResults;
        //saco los resultados de la paginacion
        $res= $db->loadObjectList($sql . " limit " . $lmin . "," . $lmax);
        echo $db->getErrorMsg();
        return $res;
    }

}

?>
