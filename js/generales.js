function loadLogin(){
    $(window).resize(function(){
        //creo el background degradado
        w=$(document).width();
        h=$(document).height();
        if($("#fondologin").length==0)
            $(document.body).prepend('<canvas id="fondologin"></canvas>');

        var ctx = document.getElementById('fondologin').getContext('2d');
        var lingrad = ctx.createLinearGradient(0,0,0,100);
        lingrad.addColorStop(0,    '#CFE2FF');
        lingrad.addColorStop(0.25, '#9BB9F0');
        lingrad.addColorStop(0.50, '#6684D1');
        lingrad.addColorStop(0.75, '#3245A2');
        lingrad.addColorStop(1,    '#000066');
        ctx.fillStyle = lingrad;
        ctx.fillRect(0,0,w,h);
        //centro el formulario
        $("#cuadrologin").css("margin-top",($(document).height()-$("#cuadrologin").height())/2-50);
    });
    $(document).ready(function(){
        $("#frmlogin").submit(function(){
            $.ajax({
                async:false,
                url:"autenticar",
                data:"usename=&"+$("#username").val()+"password="+$("#password").val(),
                type:"POST",
                success:function(data){
                    if(data.indexOf("good")){
                        window.location.href="../";
                    }else{
                        
                    }
                }
            });
        });
    });
    $(window).resize();
}