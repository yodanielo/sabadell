<div class="introregistro" style="margin-top: 20px; text-align: center">
    <?=$params["mensaje"]?>
</div>
<script type="text/javascript">
    function redirigir(){
        window.location.href='<?=$this->getURL("")?>';
    }
    setTimeout("redirigir()", 5*1000);
</script>