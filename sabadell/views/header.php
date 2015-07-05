<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $params["sitename"]; ?></title>
        <meta name="Description" content="<?php echo $params["sitedescription"]; ?>" />
        <meta name="Keywords" content="<?php echo $params["keywords"]; ?>" />
        <meta name="author" content="<?php echo $params["author"]; ?>" />
        <meta name="owner" content="<?php echo $params["owner"]; ?>" />
        <meta name="robots" content="index, follow" />
        <meta HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT"/>
        <meta HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE"/>
        <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache"/>
        <?php
        if (count($params["css"]) > 0) {
            foreach ($params["css"] as $key => $sc) {
                if (substr($sc, 0, 7) == "http://")
                    echo '<link rel="stylesheet" type="text/css" href="' . $sc . '" />' . "\n";
                else
                    echo '<link rel="stylesheet" type="text/css" href="' . $params["livesite"] . '/css/' . $sc . '" />' . "\n";
            }
        }
        ?>
        <link rel="stylesheet" type="text/css" href="<?= $params["livesite"] ?>/css/nav.css" />
        <!--[if IE ]>
	<link rel="stylesheet" type="text/css" href="<?= $params["livesite"] ?>/css/ie.css" />
        <![endif]-->
        <!--[if lte IE 7]>
	<link rel="stylesheet" type="text/css" href="<?= $params["livesite"] ?>/css/ie7.css" />
        <![endif]-->
        <?php
        if (count($params["scripts"]) > 0) {
            foreach ($params["scripts"] as $key => $sc) {
                if (substr($sc, 0, 7) == "http://")
                    echo '<script type="text/javascript" src="' . $sc . '"></script>' . "\n";
                else
                    echo '<script type="text/javascript" src="' . $params["livesite"] . '/js/' . $sc . '"></script>' . "\n";
            }
        }
        ?>
        <script type="text/javascript" src="<?= $params["livesite"] ?>/js/generales.js"></script>
    </head>
    <body>
        <div class="pagina">
            <div id="header">
                <a href="<?= $params["livesite"] ?>" id="logo">
                    <img alt="Sabadell" src="<?= $params["livesite"] . "/images/logo-sabadell.png" ?>" />
                </a>
                <?php if (!$params["nomEmpresa"]) {
                ?>
                    <div id="formlogin">
                        <form action="<?= $this->getURL("/zonasegura") ?>" method="post" name="frmlogin" id="frmlogin">
                            <div class="logfila">
                                <label for="usuario"><?= __("Usuario") ?></label>
                                <input class="textbox" type="text" id="usuario" name="usuario" value=""/>
                            </div>
                            <div class="logfila">
                                <label for="password"><?= __("Contraseña") ?></label>
                                <input class="textbox" type="password" id="password" name="password" value=""/>
                            </div>
                            <input class="submit" type="submit" id="logsubmit" value="<?= __("Entrar") ?>"/>
                        </form>
                    </div>
                <?php
                } else {
                ?>
                    <div id="formlogin">
                    <?= $params["nomEmpresa"] ?>
                </div>
                <?php
                }
                ?>
            </div>
            <div id="menuprin" class="barraazul">
                <div id="idiomas"><a id="cat" href="<?= $this->getURL("/idioma/index/cat") ?>">Catalá</a><a id="esp" href="<?= $this->getURL("/idioma/index/esp") ?>">Castellano</a></div>
                <a href="<?= $this->getURL("/menu") ?>"><?= __('Menú') ?></a><a href="<?= $this->getURL("/empresas") ?>"><?= __('Empresas de Sabadell') ?></a><a href="<?= $this->getURL("/informacion") ?>"><?= __('Información') ?></a><a href="<?= $this->getURL("/servicios") ?>"><?= __('Servicios') ?></a><a href="<?= $this->getURL("/contacto") ?>"><?= __('Contacto') ?></a><a href="<?= $this->getURL("/registro") ?>"><?= __('Alta Gratis') ?></a>
            </div>
            <div id="bannerprincipal">
                <?php
                $ban = $params["banner"];
                if ($ban->imgmenu) {
                    $ext = strtolower(substr($ban->imgmenu, strlen($ban->imgmenu) - 3));
                    switch ($ext) {
                        case 'png':
                        case 'gif':
                        case 'jpg':
                            echo '<img src="' . $params["livesite"] . '/images/recursos/' . $ban->imgmenu . '" style="width:885px"/>';
                            break;
                        case 'swf':
                            echo '<script type="text/javascript">runSWF2("' . $params["livesite"] . '/images/recursos/' . $ban->imgmenu . '", "885", "' . $ban->imgalto . '", "9.0.0.0", "transparent");</script>';
                            break;
                    }
                }
                ?>
            </div>
            <div id="dadealta" class="barraazul">
                <?php if (!$params["empresa"]) {
 ?>
                    <a href="<?= $this->getURL("/registro") ?>"><?= __("Da de Alta Tu Empresa") ?></a>
<?php } else { ?>
                    <a href="<?= $this->getURL($params["slug"]) ?>"><?= __($params["nomslug"]) ?></a>
<?php } ?>
            </div>
            <!--FIN DE HEADER-->