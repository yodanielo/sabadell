<?php
include("cls_MantixError20.php");
include("cls_usuarios.php");
$res="";
if ($_POST["txt_user"]!="") {
    $w_Error= new MantixError();
    $adm_usuario= new Usuarios();
    $adm_usuario->usuario = $_POST["txt_user"];
    $adm_usuario->password =$_POST["txt_pass"];
    $res=$adm_usuario->ingresar();
    if($res=="0") {
        header("location:usuarios.php");
    }
    else {
        //$w_Error->ok($res);
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <title></title>
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/cpanel_complementos.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script src="scripts/cpanel_scripts.js" type="text/javascript"></script>
    <SCRIPT language="JavaScript">
        self.moveTo(0,0);self.resizeTo(screen.availWidth,screen.availHeight);
    </SCRIPT>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <div id="login_center">
        <form name="form1" method="post" action="index.php">
            <div id="cont">
                <div style="height:30px; float:left;" class="login_label">&nbsp;Usuario:&nbsp;</div>
                <div style="width:135px; height:30px; float:left;"><input name="txt_user" type="text" class="login_input"></div>
                <div style="height:30px; float:left;"><span class="login_label"> &nbsp;Contrase&ntilde;a:&nbsp;</span></div>
                <div style="width:135px; height:30px; float:left;"><input name="txt_pass" type="password" class="login_input"></div>
                <div style="width:130px; height:30px; float:left;">&nbsp;<input name="Submit" type="submit" class="login_submit" value="Iniciar Sesi&oacute;n"></div>
            </div>
        </form>
    </div>
<?php if($res=="11") {
    ?>
    <div style="display:none">
        <!--<div class="jqmWindow" id="dlgMensaje" onclick="ocultarbox()">-->
        <div id="dlgMensajea">
            El Usuario o Contrase&ntilde;a no es correcto. Int&eacute;ntelo nuevamente.
            <br/>
            <a href="javascript:$.fancybox.close()">Cerrar</a>
        </div>
    </div>
    <a id="linkalerta" href="#dlgMensajea"></a>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#linkalerta").fancybox({
                overlayOpacity:0.90,
                overlayColor:"#000",
                showCloseButton:false,
                modal:true,
                centerOnScroll:true,
                padding:0
            });
            $("#linkalerta").click();
        });
        /*$('#dlgMensaje').jqm();
        $('#dlgMensaje').jqmShow();
        $('#dlgMensaje').css("cursor","pointer");
        function ocultarbox(){
            $('#dlgMensaje').jqmHide();
        }*/
    </script>
    <?php } ?>
</BODY>
</html>