<?php
function clipImage($file, $dest, $width, $height) {
    $imSrc  = imagecreatefromjpeg($file);
    $w      = imagesx($imSrc);
    $h      = imagesy($imSrc);
    if($width/$height>$w/$h) {
        $nh = ($h/$w)*$width;
        $nw = $width;
    } else {
        $nw = ($w/$h)*$height;
        $nh = $height;
    }
    $dx = ($width/2)-($nw/2);
    $dy = ($height/2)-($nh/2);
    $imTrg  = imagecreatetruecolor($width, $height);
    imagecopyresized($imTrg, $imSrc, $dx, $dy, 0, 0, $nw, $nh, $w, $h);
    imagedestroy($imSrc);
    imagejpeg($imTrg, $dest, 95);
    imagedestroy($imTrg);
}

function ajuste_imgmax($file, $destino, $width, $height) {
    $imSrc  = imagecreatefromjpeg($file );
    $w      = imagesx($imSrc);
    $h      = imagesy($imSrc);
    if($h>$height) {
        $c=$height/$h;
        $nh=$height;
        $nw=$w*$c;
    }
    else {
        $nh=$height;
        $nw=$width;
    }
    if($w>$width) {
        $c=$width/$w;
        $nw=$width;
        $nh=$h*$c;
    }
    else {
        $nh=$height;
        $nw=$width;
    }
    $dx = ($width/2)-($nw/2);
    $dy = ($height/2)-($nh/2);
    $imTrg  = imageCreateTrueColor($nw, $nh);
    imagecopyresampled($imTrg, $imSrc, 0, 0, 0, 0, $nw, $nh, $w, $h);
    //imagecopyresampled($imTrg, $imSrc, $dx, $dy, 0, 0, $nw, $nh, $w, $h);
    imagedestroy($imSrc);
    imagejpeg($imTrg, $destino , 95);
    imagedestroy($imTrg);
}
?>