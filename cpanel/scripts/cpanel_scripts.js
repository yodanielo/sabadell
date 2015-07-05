/**
 *galeria tabla
 */
$.fn.galeria_tabla=function(extensiones,descripcion) {
    vista="lista"
    campo=$(this).attr("id").split("galeria_").join("");

    agregar_vlista=function(a){
        cad='';
        if(!$(".galitem").hasClass("activo")){
            cad+='<div class="galitem galitem_'+campo+'"><div class="imgmini_'+campo+' aggimgmini" style="display:none; background:#fff url(../tumber.php?w=64&h=64&src=../images/recursos/'+a+') right top"><img src="images/marco-galeria.png"/></div><a></a><span>'+a+'</span>';
            cad+='    <input type="hidden" class="'+campo+'_img" name="'+campo+'_img[]" value="'+a+'" />';
            cad+='    <input type="hidden" class="'+campo+'_comentario" name="'+campo+'_comentario[]" value="" />';
            cad+='</div>';
            $("#galcont_"+campo+" .galajuste").append(cad);
            agregar($(".galitem:last"));
        }else{
            $(".activo ."+campo+"_img").val(a);
            $(".activo .imgmini_"+campo).css("background","#fff url(../tumber.php?w=64&h=64&src=../images/recursos/"+a+") right top");
            $(".activo span").html(a+'<img src="images/ico-imagen.png"/>');
            $(".activo").removeClass("activo");
            agregar($(".activo"));
        }
    }
    agregar_vgal=function(a){
        cad='';
        if(!$(".galitem").hasClass("activo")){
            cad+='<div class="galitem galitem_'+campo+'"><div class="imgmini_'+campo+' aggimgmini" style="display:block; background: #fff url(../tumber.php?w=64&h=64&src=../images/recursos/'+a+') right top"><img src="images/marco-galeria.png"/></div><a></a><span>'+a+'</span>';
            cad+='    <input type="hidden" class="'+campo+'_img" name="'+campo+'_img[]" value="'+a+'" />';
            cad+='    <input type="hidden" class="'+campo+'_comentario" name="'+campo+'_comentario[]" value="" />';
            cad+='</div>';
            $("#galcont_"+campo+" .galajuste").append(cad);
            agregar($(".galitem:last"));
        }else{
            $(".activo ."+campo+"_img").val(a);
            $(".activo .imgmini_"+campo).css("background","#fff url(../tumber.php?w=64&h=64&src=../images/recursos/"+a+") right top");
            $(".activo span").html(a+'<img src="images/ico-imagen.png"/>');
            $(".activo").removeClass("activo");
            agregar($(".activo"));
        }
    }
    agregar=function(a){
        hacer_init(a);
    }
    hacer_init=function(item){
        s="";
        $("#galcont_"+campo+" span").each(function(){
            s+=","+$(this).text();
        });
        $("#"+campo).val(s.substr(1,s.length-1));
        $(".galitem a").click(function(){
            if(!$(this).parent().hasClass("activo")){
                $(this).parent().remove();
                fleXenv.updateScrollBars()
                //hacer_init();
            }
        });
        var galitem_click=function(){
            if($(this).hasClass("activo")){
                //quitar seleccion
                $(".galitem").removeClass("activo")
            }else{
                //poner seleccion
                $(".galitem").removeClass("activo")
                $(this).addClass("activo");
            }
        };
        if(item!=null){
            //$(item).unbind("click", galitem_click);
            $(item).click(galitem_click);
        }else{
            $(".galitem").click(galitem_click);
        }
        //$(".galitem").click(galitem_click);
        $(".galitem span").each(function(){
            ext=$(this).text().substr(-3, 3);
            $(this).find("img").remove();
            if(ext=="jpg"){
                $(this).append('<img src="images/ico-imagen.png" />');
            }else{
                $(this).append('<img src="images/ico-video.png" />');
            }
        });
        if(vista=="lista"){
            $("#"+campo+"_vlista").click();
        }else{
            $("#"+campo+"_vgal").click();
        }
        fleXenv.updateScrollBars()
        if(vista=="lista")
            $(".galajuste").css("margin-left",5)
        else
            $(".galajuste").css("margin-left",0)
    }
    $("#"+campo+"_vlista").click(function(){
        $(".galitem_"+campo+" .aggimgmini").hide();
        $(".galitem_"+campo+" a").show();
        $(".galitem_"+campo+" span").show();
        $(".galitem_"+campo).width(470);
        $(".galitem_"+campo).height(15);
        $(".galitem_"+campo).removeClass("gimg");
        vista="lista"
        $(".galajuste").css("background","");
        fleXenv.updateScrollBars()
        if(vista=="lista")
            $(".galajuste").css("margin-left",5)
        else
            $(".galajuste").css("margin-left",0)
    });
    $("#"+campo+"_vgal").click(function(){
        $(".galitem_"+campo+" .aggimgmini").show();
        $(".galitem_"+campo+" a").hide();
        $(".galitem_"+campo+" span").hide();
        $(".galitem_"+campo).width(69);
        $(".galitem_"+campo).height(69);
        $(".galitem_"+campo).addClass("gimg");
        vista="gal"
        $(".galajuste").css("background","url(images/fondo-matriz.gif)");
        fleXenv.updateScrollBars()
        if(vista=="lista")
            $(".galajuste").css("margin-left",5)
        else
            $(".galajuste").css("margin-left",0)
    });
    $("#udf_"+campo).uploadify({
        'uploader'    :    'uploadify/uploadify.swf',
        'script'      :    'upload_'+campo+'.php',
        'folder'      :    '',
        'buttonImg'   :    'images/subir-archivo.gif',
        'auto'        :    true,
        'fileExt'     :    extensiones,
        'fileDesc'    :    descripcion,
        'width'       :    107,
        'height'      :    22,
        'multi'       :    true,
        'simUploadLimit':  2,
        'cancelImg'   :    'images/cerrar-precarga.png',
        'onComplete'  :    function(a,b,c,d,e){
            if(vista=="lista")
                agregar_vlista(d);
            else
                agregar_vgal(d);
        }
    });
    $(document).ready(function(){
        $(".galsubir").tooltip({effect: 'slide'});
        //$(".pl1_btn").tooltip({effect: 'slide'});
    });
    hacer_init();
};
/**
 * jQuery.ScrollTo - Easy element scrolling using jQuery.
 * Copyright (c) 2008 Ariel Flesler - aflesler(at)gmail(dot)com
 * Licensed under GPL license (http://www.opensource.org/licenses/gpl-license.php).
 * Date: 2/8/2008
 * @author Ariel Flesler
 * @version 1.3.2
 */
(function($){var o=$.scrollTo=function(a,b,c){o.window().scrollTo(a,b,c)};o.defaults={axis:'y',duration:1};o.window=function(){return $($.browser.safari?'body':'html')};$.fn.scrollTo=function(l,m,n){if(typeof m=='object'){n=m;m=0}n=$.extend({},o.defaults,n);m=m||n.speed||n.duration;n.queue=n.queue&&n.axis.length>1;if(n.queue)m/=2;n.offset=j(n.offset);n.over=j(n.over);return this.each(function(){var a=this,b=$(a),t=l,c,d={},w=b.is('html,body');switch(typeof t){case'number':case'string':if(/^([+-]=)?\d+(px)?$/.test(t)){t=j(t);break}t=$(t,this);case'object':if(t.is||t.style)c=(t=$(t)).offset()}$.each(n.axis.split(''),function(i,f){var P=f=='x'?'Left':'Top',p=P.toLowerCase(),k='scroll'+P,e=a[k],D=f=='x'?'Width':'Height';if(c){d[k]=c[p]+(w?0:e-b.offset()[p]);if(n.margin){d[k]-=parseInt(t.css('margin'+P))||0;d[k]-=parseInt(t.css('border'+P+'Width'))||0}d[k]+=n.offset[p]||0;if(n.over[p])d[k]+=t[D.toLowerCase()]()*n.over[p]}else d[k]=t[p];if(/^\d+$/.test(d[k]))d[k]=d[k]<=0?0:Math.min(d[k],h(D));if(!i&&n.queue){if(e!=d[k])g(n.onAfterFirst);delete d[k]}});g(n.onAfter);function g(a){b.animate(d,m,n.easing,a&&function(){a.call(this,l)})};function h(D){var b=w?$.browser.opera?document.body:document.documentElement:a;return b['scroll'+D]-b['client'+D]}})};function j(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);

/**
 * jQuery.LocalScroll - Animated scrolling navigation, using anchors.
 * Copyright (c) 2007-2008 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 6/3/2008
 * @author Ariel Flesler
 * @version 1.2.6
 **/
(function($){var g=location.href.replace(/#.*/,''),h=$.localScroll=function(a){$('body').localScroll(a)};h.defaults={duration:1e3,axis:'y',event:'click',stop:1};h.hash=function(a){a=$.extend({},h.defaults,a);a.hash=0;if(location.hash)setTimeout(function(){i(0,location,a)},0)};$.fn.localScroll=function(b){b=$.extend({},h.defaults,b);return(b.persistent||b.lazy)?this.bind(b.event,function(e){var a=$([e.target,e.target.parentNode]).filter(c)[0];a&&i(e,a,b)}):this.find('a,area').filter(c).bind(b.event,function(e){i(e,this,b)}).end().end();function c(){var a=this;return!!a.href&&!!a.hash&&a.href.replace(a.hash,'')==g&&(!b.filter||$(a).is(b.filter))}};function i(e,a,b){var c=a.hash.slice(1),d=document.getElementById(c)||document.getElementsByName(c)[0],f;if(d){e&&e.preventDefault();f=$(b.target||$.scrollTo.window());if(b.lock&&f.is(':animated')||b.onBefore&&b.onBefore.call(a,e,d,f)===!1)return;if(b.stop)f.queue('fx',[]).stop();f.scrollTo(d,b).trigger('notify.serialScroll',[d]);if(b.hash)f.queue(function(){location=a.hash;$(this).dequeue()})}}})(jQuery);

/*
 * FancyBox - jQuery Plugin
 * Simple and fancy lightbox alternative
 *
 * Examples and documentation at: http://fancybox.net
 *
 * Copyright (c) 2008 - 2010 Janis Skarnelis
 *
 * Version: 1.3.1 (05/03/2010)
 * Requires: jQuery v1.3+
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
(function(b){var m,u,x,g,D,i,z,A,B,p=0,e={},q=[],n=0,c={},j=[],E=null,s=new Image,G=/\.(jpg|gif|png|bmp|jpeg)(.*)?$/i,S=/[^\.]\.(swf)\s*$/i,H,I=1,k,l,h=false,y=b.extend(b("<div/>")[0],{prop:0}),v=0,O=!b.support.opacity&&!window.XMLHttpRequest,J=function(){u.hide();s.onerror=s.onload=null;E&&E.abort();m.empty()},P=function(){b.fancybox('<p id="fancybox_error">The requested content cannot be loaded.<br />Please try again later.</p>',{scrolling:"no",padding:20,transitionIn:"none",transitionOut:"none"})},
K=function(){return[b(window).width(),b(window).height(),b(document).scrollLeft(),b(document).scrollTop()]},T=function(){var a=K(),d={},f=c.margin,o=c.autoScale,t=(20+f)*2,w=(20+f)*2,r=c.padding*2;if(c.width.toString().indexOf("%")>-1){d.width=a[0]*parseFloat(c.width)/100-40;o=false}else d.width=c.width+r;if(c.height.toString().indexOf("%")>-1){d.height=a[1]*parseFloat(c.height)/100-40;o=false}else d.height=c.height+r;if(o&&(d.width>a[0]-t||d.height>a[1]-w))if(e.type=="image"||e.type=="swf"){t+=r;
w+=r;o=Math.min(Math.min(a[0]-t,c.width)/c.width,Math.min(a[1]-w,c.height)/c.height);d.width=Math.round(o*(d.width-r))+r;d.height=Math.round(o*(d.height-r))+r}else{d.width=Math.min(d.width,a[0]-t);d.height=Math.min(d.height,a[1]-w)}d.top=a[3]+(a[1]-(d.height+40))*0.5;d.left=a[2]+(a[0]-(d.width+40))*0.5;if(c.autoScale===false){d.top=Math.max(a[3]+f,d.top);d.left=Math.max(a[2]+f,d.left)}return d},U=function(a){if(a&&a.length)switch(c.titlePosition){case "inside":return a;case "over":return'<span id="fancybox-title-over">'+
a+"</span>";default:return'<span id="fancybox-title-wrap"><span id="fancybox-title-left"></span><span id="fancybox-title-main">'+a+'</span><span id="fancybox-title-right"></span></span>'}return false},V=function(){var a=c.title,d=l.width-c.padding*2,f="fancybox-title-"+c.titlePosition;b("#fancybox-title").remove();v=0;if(c.titleShow!==false){a=b.isFunction(c.titleFormat)?c.titleFormat(a,j,n,c):U(a);if(!(!a||a==="")){b('<div id="fancybox-title" class="'+f+'" />').css({width:d,paddingLeft:c.padding,
paddingRight:c.padding}).html(a).appendTo("body");switch(c.titlePosition){case "inside":v=b("#fancybox-title").outerHeight(true)-c.padding;l.height+=v;break;case "over":b("#fancybox-title").css("bottom",c.padding);break;default:b("#fancybox-title").css("bottom",b("#fancybox-title").outerHeight(true)*-1);break}b("#fancybox-title").appendTo(D).hide()}}},W=function(){b(document).unbind("keydown.fb").bind("keydown.fb",function(a){if(a.keyCode==27&&c.enableEscapeButton){a.preventDefault();b.fancybox.close()}else if(a.keyCode==
37){a.preventDefault();b.fancybox.prev()}else if(a.keyCode==39){a.preventDefault();b.fancybox.next()}});if(b.fn.mousewheel){g.unbind("mousewheel.fb");j.length>1&&g.bind("mousewheel.fb",function(a,d){a.preventDefault();h||d===0||(d>0?b.fancybox.prev():b.fancybox.next())})}if(c.showNavArrows){if(c.cyclic&&j.length>1||n!==0)A.show();if(c.cyclic&&j.length>1||n!=j.length-1)B.show()}},X=function(){var a,d;if(j.length-1>n){a=j[n+1].href;if(typeof a!=="undefined"&&a.match(G)){d=new Image;d.src=a}}if(n>0){a=
j[n-1].href;if(typeof a!=="undefined"&&a.match(G)){d=new Image;d.src=a}}},L=function(){i.css("overflow",c.scrolling=="auto"?c.type=="image"||c.type=="iframe"||c.type=="swf"?"hidden":"auto":c.scrolling=="yes"?"auto":"visible");if(!b.support.opacity){i.get(0).style.removeAttribute("filter");g.get(0).style.removeAttribute("filter")}b("#fancybox-title").show();c.hideOnContentClick&&i.one("click",b.fancybox.close);c.hideOnOverlayClick&&x.one("click",b.fancybox.close);c.showCloseButton&&z.show();W();b(window).bind("resize.fb",
b.fancybox.center);c.centerOnScroll?b(window).bind("scroll.fb",b.fancybox.center):b(window).unbind("scroll.fb");b.isFunction(c.onComplete)&&c.onComplete(j,n,c);h=false;X()},M=function(a){var d=Math.round(k.width+(l.width-k.width)*a),f=Math.round(k.height+(l.height-k.height)*a),o=Math.round(k.top+(l.top-k.top)*a),t=Math.round(k.left+(l.left-k.left)*a);g.css({width:d+"px",height:f+"px",top:o+"px",left:t+"px"});d=Math.max(d-c.padding*2,0);f=Math.max(f-(c.padding*2+v*a),0);i.css({width:d+"px",height:f+
"px"});if(typeof l.opacity!=="undefined")g.css("opacity",a<0.5?0.5:a)},Y=function(a){var d=a.offset();d.top+=parseFloat(a.css("paddingTop"))||0;d.left+=parseFloat(a.css("paddingLeft"))||0;d.top+=parseFloat(a.css("border-top-width"))||0;d.left+=parseFloat(a.css("border-left-width"))||0;d.width=a.width();d.height=a.height();return d},Q=function(){var a=e.orig?b(e.orig):false,d={};if(a&&a.length){a=Y(a);d={width:a.width+c.padding*2,height:a.height+c.padding*2,top:a.top-c.padding-20,left:a.left-c.padding-
20}}else{a=K();d={width:1,height:1,top:a[3]+a[1]*0.5,left:a[2]+a[0]*0.5}}return d},N=function(){u.hide();if(g.is(":visible")&&b.isFunction(c.onCleanup))if(c.onCleanup(j,n,c)===false){b.event.trigger("fancybox-cancel");h=false;return}j=q;n=p;c=e;i.get(0).scrollTop=0;i.get(0).scrollLeft=0;if(c.overlayShow){O&&b("select:not(#fancybox-tmp select)").filter(function(){return this.style.visibility!=="hidden"}).css({visibility:"hidden"}).one("fancybox-cleanup",function(){this.style.visibility="inherit"});
x.css({"background-color":c.overlayColor,opacity:c.overlayOpacity}).unbind().show()}l=T();V();if(g.is(":visible")){b(z.add(A).add(B)).hide();var a=g.position(),d;k={top:a.top,left:a.left,width:g.width(),height:g.height()};d=k.width==l.width&&k.height==l.height;i.fadeOut(c.changeFade,function(){var f=function(){i.html(m.contents()).fadeIn(c.changeFade,L)};b.event.trigger("fancybox-change");i.empty().css("overflow","hidden");if(d){i.css({top:c.padding,left:c.padding,width:Math.max(l.width-c.padding*
2,1),height:Math.max(l.height-c.padding*2-v,1)});f()}else{i.css({top:c.padding,left:c.padding,width:Math.max(k.width-c.padding*2,1),height:Math.max(k.height-c.padding*2,1)});y.prop=0;b(y).animate({prop:1},{duration:c.changeSpeed,easing:c.easingChange,step:M,complete:f})}})}else{g.css("opacity",1);if(c.transitionIn=="elastic"){k=Q();i.css({top:c.padding,left:c.padding,width:Math.max(k.width-c.padding*2,1),height:Math.max(k.height-c.padding*2,1)}).html(m.contents());g.css(k).show();if(c.opacity)l.opacity=
0;y.prop=0;b(y).animate({prop:1},{duration:c.speedIn,easing:c.easingIn,step:M,complete:L})}else{i.css({top:c.padding,left:c.padding,width:Math.max(l.width-c.padding*2,1),height:Math.max(l.height-c.padding*2-v,1)}).html(m.contents());g.css(l).fadeIn(c.transitionIn=="none"?0:c.speedIn,L)}}},F=function(){m.width(e.width);m.height(e.height);if(e.width=="auto")e.width=m.width();if(e.height=="auto")e.height=m.height();N()},Z=function(){h=true;e.width=s.width;e.height=s.height;b("<img />").attr({id:"fancybox-img",
src:s.src,alt:e.title}).appendTo(m);N()},C=function(){J();var a=q[p],d,f,o,t,w;e=b.extend({},b.fn.fancybox.defaults,typeof b(a).data("fancybox")=="undefined"?e:b(a).data("fancybox"));o=a.title||b(a).title||e.title||"";if(a.nodeName&&!e.orig)e.orig=b(a).children("img:first").length?b(a).children("img:first"):b(a);if(o===""&&e.orig)o=e.orig.attr("alt");d=a.nodeName&&/^(?:javascript|#)/i.test(a.href)?e.href||null:e.href||a.href||null;if(e.type){f=e.type;if(!d)d=e.content}else if(e.content)f="html";else if(d)if(d.match(G))f=
"image";else if(d.match(S))f="swf";else if(b(a).hasClass("iframe"))f="iframe";else if(d.match(/#/)){a=d.substr(d.indexOf("#"));f=b(a).length>0?"inline":"ajax"}else f="ajax";else f="inline";e.type=f;e.href=d;e.title=o;if(e.autoDimensions&&e.type!=="iframe"&&e.type!=="swf"){e.width="auto";e.height="auto"}if(e.modal){e.overlayShow=true;e.hideOnOverlayClick=false;e.hideOnContentClick=false;e.enableEscapeButton=false;e.showCloseButton=false}if(b.isFunction(e.onStart))if(e.onStart(q,p,e)===false){h=false;
return}m.css("padding",20+e.padding+e.margin);b(".fancybox-inline-tmp").unbind("fancybox-cancel").bind("fancybox-change",function(){b(this).replaceWith(i.children())});switch(f){case "html":m.html(e.content);F();break;case "inline":b('<div class="fancybox-inline-tmp" />').hide().insertBefore(b(a)).bind("fancybox-cleanup",function(){b(this).replaceWith(i.children())}).bind("fancybox-cancel",function(){b(this).replaceWith(m.children())});b(a).appendTo(m);F();break;case "image":h=false;b.fancybox.showActivity();
s=new Image;s.onerror=function(){P()};s.onload=function(){s.onerror=null;s.onload=null;Z()};s.src=d;break;case "swf":t='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+e.width+'" height="'+e.height+'"><param name="movie" value="'+d+'"></param>';w="";b.each(e.swf,function(r,R){t+='<param name="'+r+'" value="'+R+'"></param>';w+=" "+r+'="'+R+'"'});t+='<embed src="'+d+'" type="application/x-shockwave-flash" width="'+e.width+'" height="'+e.height+'"'+w+"></embed></object>";m.html(t);
F();break;case "ajax":a=d.split("#",2);f=e.ajax.data||{};if(a.length>1){d=a[0];if(typeof f=="string")f+="&selector="+a[1];else f.selector=a[1]}h=false;b.fancybox.showActivity();E=b.ajax(b.extend(e.ajax,{url:d,data:f,error:P,success:function(r){if(E.status==200){m.html(r);F()}}}));break;case "iframe":b('<iframe id="fancybox-frame" name="fancybox-frame'+(new Date).getTime()+'" frameborder="0" hspace="0" scrolling="'+e.scrolling+'" src="'+e.href+'"></iframe>').appendTo(m);N();break}},$=function(){if(u.is(":visible")){b("div",
u).css("top",I*-40+"px");I=(I+1)%12}else clearInterval(H)},aa=function(){if(!b("#fancybox-wrap").length){b("body").append(m=b('<div id="fancybox-tmp"></div>'),u=b('<div id="fancybox-loading"><div></div></div>'),x=b('<div id="fancybox-overlay"></div>'),g=b('<div id="fancybox-wrap"></div>'));if(!b.support.opacity){g.addClass("fancybox-ie");u.addClass("fancybox-ie")}D=b('<div id="fancybox-outer"></div>').append('<div class="fancy-bg" id="fancy-bg-n"></div><div class="fancy-bg" id="fancy-bg-ne"></div><div class="fancy-bg" id="fancy-bg-e"></div><div class="fancy-bg" id="fancy-bg-se"></div><div class="fancy-bg" id="fancy-bg-s"></div><div class="fancy-bg" id="fancy-bg-sw"></div><div class="fancy-bg" id="fancy-bg-w"></div><div class="fancy-bg" id="fancy-bg-nw"></div>').appendTo(g);
D.append(i=b('<div id="fancybox-inner"></div>'),z=b('<a id="fancybox-close"></a>'),A=b('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),B=b('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>'));z.click(b.fancybox.close);u.click(b.fancybox.cancel);A.click(function(a){a.preventDefault();b.fancybox.prev()});B.click(function(a){a.preventDefault();b.fancybox.next()});if(O){x.get(0).style.setExpression("height",
"document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px'");u.get(0).style.setExpression("top","(-20 + (document.documentElement.clientHeight ? document.documentElement.clientHeight/2 : document.body.clientHeight/2 ) + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop )) + 'px'");D.prepend('<iframe id="fancybox-hide-sel-frame" src="javascript:\'\';" scrolling="no" frameborder="0" ></iframe>')}}};
b.fn.fancybox=function(a){b(this).data("fancybox",b.extend({},a,b.metadata?b(this).metadata():{})).unbind("click.fb").bind("click.fb",function(d){d.preventDefault();if(!h){h=true;b(this).blur();q=[];p=0;d=b(this).attr("rel")||"";if(!d||d==""||d==="nofollow")q.push(this);else{q=b("a[rel="+d+"], area[rel="+d+"]");p=q.index(this)}C();return false}});return this};b.fancybox=function(a,d){if(!h){h=true;d=typeof d!=="undefined"?d:{};q=[];p=d.index||0;if(b.isArray(a)){for(var f=0,o=a.length;f<o;f++)if(typeof a[f]==
"object")b(a[f]).data("fancybox",b.extend({},d,a[f]));else a[f]=b({}).data("fancybox",b.extend({content:a[f]},d));q=jQuery.merge(q,a)}else{if(typeof a=="object")b(a).data("fancybox",b.extend({},d,a));else a=b({}).data("fancybox",b.extend({content:a},d));q.push(a)}if(p>q.length||p<0)p=0;C()}};b.fancybox.showActivity=function(){clearInterval(H);u.show();H=setInterval($,66)};b.fancybox.hideActivity=function(){u.hide()};b.fancybox.next=function(){return b.fancybox.pos(n+1)};b.fancybox.prev=function(){return b.fancybox.pos(n-
1)};b.fancybox.pos=function(a){if(!h){a=parseInt(a,10);if(a>-1&&j.length>a){p=a;C()}if(c.cyclic&&j.length>1&&a<0){p=j.length-1;C()}if(c.cyclic&&j.length>1&&a>=j.length){p=0;C()}}};b.fancybox.cancel=function(){if(!h){h=true;b.event.trigger("fancybox-cancel");J();e&&b.isFunction(e.onCancel)&&e.onCancel(q,p,e);h=false}};b.fancybox.close=function(){function a(){x.fadeOut("fast");g.hide();b.event.trigger("fancybox-cleanup");i.empty();b.isFunction(c.onClosed)&&c.onClosed(j,n,c);j=e=[];n=p=0;c=e={};h=false}
if(!(h||g.is(":hidden"))){h=true;if(c&&b.isFunction(c.onCleanup))if(c.onCleanup(j,n,c)===false){h=false;return}J();b(z.add(A).add(B)).hide();b("#fancybox-title").remove();g.add(i).add(x).unbind();b(window).unbind("resize.fb scroll.fb");b(document).unbind("keydown.fb");i.css("overflow","hidden");if(c.transitionOut=="elastic"){k=Q();var d=g.position();l={top:d.top,left:d.left,width:g.width(),height:g.height()};if(c.opacity)l.opacity=1;y.prop=1;b(y).animate({prop:0},{duration:c.speedOut,easing:c.easingOut,
step:M,complete:a})}else g.fadeOut(c.transitionOut=="none"?0:c.speedOut,a)}};b.fancybox.resize=function(){var a,d;if(!(h||g.is(":hidden"))){h=true;a=i.wrapInner("<div style='overflow:auto'></div>").children();d=a.height();g.css({height:d+c.padding*2+v});i.css({height:d});a.replaceWith(a.children());b.fancybox.center()}};b.fancybox.center=function(){h=true;var a=K(),d=c.margin,f={};f.top=a[3]+(a[1]-(g.height()-v+40))*0.5;f.left=a[2]+(a[0]-(g.width()+40))*0.5;f.top=Math.max(a[3]+d,f.top);f.left=Math.max(a[2]+
d,f.left);g.css(f);h=false};b.fn.fancybox.defaults={padding:10,margin:20,opacity:false,modal:false,cyclic:false,scrolling:"auto",width:560,height:340,autoScale:true,autoDimensions:true,centerOnScroll:false,ajax:{},swf:{wmode:"transparent"},hideOnOverlayClick:true,hideOnContentClick:false,overlayShow:true,overlayOpacity:0.3,overlayColor:"#666",titleShow:true,titlePosition:"outside",titleFormat:null,transitionIn:"fade",transitionOut:"fade",speedIn:300,speedOut:300,changeSpeed:300,changeFade:"fast",
easingIn:"swing",easingOut:"swing",showCloseButton:true,showNavArrows:true,enableEscapeButton:true,onStart:null,onCancel:null,onComplete:null,onCleanup:null,onClosed:null};b(document).ready(function(){aa()})})(jQuery);
/*
* SWFObject v2.2 <http://code.google.com/p/swfobject/>
* is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
*/
var swfobject=function(){var D="undefined",r="object",S="Shockwave Flash",W="ShockwaveFlash.ShockwaveFlash",q="application/x-shockwave-flash",R="SWFObjectExprInst",x="onreadystatechange",O=window,j=document,t=navigator,T=false,U=[h],o=[],N=[],I=[],l,Q,E,B,J=false,a=false,n,G,m=true,M=function(){var aa=typeof j.getElementById!=D&&typeof j.getElementsByTagName!=D&&typeof j.createElement!=D,ah=t.userAgent.toLowerCase(),Y=t.platform.toLowerCase(),ae=Y?/win/.test(Y):/win/.test(ah),ac=Y?/mac/.test(Y):/mac/.test(ah),af=/webkit/.test(ah)?parseFloat(ah.replace(/^.*webkit\/(\d+(\.\d+)?).*$/,"$1")):false,X=!+"\v1",ag=[0,0,0],ab=null;if(typeof t.plugins!=D&&typeof t.plugins[S]==r){ab=t.plugins[S].description;if(ab&&!(typeof t.mimeTypes!=D&&t.mimeTypes[q]&&!t.mimeTypes[q].enabledPlugin)){T=true;X=false;ab=ab.replace(/^.*\s+(\S+\s+\S+$)/,"$1");ag[0]=parseInt(ab.replace(/^(.*)\..*$/,"$1"),10);ag[1]=parseInt(ab.replace(/^.*\.(.*)\s.*$/,"$1"),10);ag[2]=/[a-zA-Z]/.test(ab)?parseInt(ab.replace(/^.*[a-zA-Z]+(.*)$/,"$1"),10):0}}else{if(typeof O.ActiveXObject!=D){try{var ad=new ActiveXObject(W);if(ad){ab=ad.GetVariable("$version");if(ab){X=true;ab=ab.split(" ")[1].split(",");ag=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}}catch(Z){}}}return{w3:aa,pv:ag,wk:af,ie:X,win:ae,mac:ac}}(),k=function(){if(!M.w3){return}if((typeof j.readyState!=D&&j.readyState=="complete")||(typeof j.readyState==D&&(j.getElementsByTagName("body")[0]||j.body))){f()}if(!J){if(typeof j.addEventListener!=D){j.addEventListener("DOMContentLoaded",f,false)}if(M.ie&&M.win){j.attachEvent(x,function(){if(j.readyState=="complete"){j.detachEvent(x,arguments.callee);f()}});if(O==top){(function(){if(J){return}try{j.documentElement.doScroll("left")}catch(X){setTimeout(arguments.callee,0);return}f()})()}}if(M.wk){(function(){if(J){return}if(!/loaded|complete/.test(j.readyState)){setTimeout(arguments.callee,0);return}f()})()}s(f)}}();function f(){if(J){return}try{var Z=j.getElementsByTagName("body")[0].appendChild(C("span"));Z.parentNode.removeChild(Z)}catch(aa){return}J=true;var X=U.length;for(var Y=0;Y<X;Y++){U[Y]()}}function K(X){if(J){X()}else{U[U.length]=X}}function s(Y){if(typeof O.addEventListener!=D){O.addEventListener("load",Y,false)}else{if(typeof j.addEventListener!=D){j.addEventListener("load",Y,false)}else{if(typeof O.attachEvent!=D){i(O,"onload",Y)}else{if(typeof O.onload=="function"){var X=O.onload;O.onload=function(){X();Y()}}else{O.onload=Y}}}}}function h(){if(T){V()}else{H()}}function V(){var X=j.getElementsByTagName("body")[0];var aa=C(r);aa.setAttribute("type",q);var Z=X.appendChild(aa);if(Z){var Y=0;(function(){if(typeof Z.GetVariable!=D){var ab=Z.GetVariable("$version");if(ab){ab=ab.split(" ")[1].split(",");M.pv=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}else{if(Y<10){Y++;setTimeout(arguments.callee,10);return}}X.removeChild(aa);Z=null;H()})()}else{H()}}function H(){var ag=o.length;if(ag>0){for(var af=0;af<ag;af++){var Y=o[af].id;var ab=o[af].callbackFn;var aa={success:false,id:Y};if(M.pv[0]>0){var ae=c(Y);if(ae){if(F(o[af].swfVersion)&&!(M.wk&&M.wk<312)){w(Y,true);if(ab){aa.success=true;aa.ref=z(Y);ab(aa)}}else{if(o[af].expressInstall&&A()){var ai={};ai.data=o[af].expressInstall;ai.width=ae.getAttribute("width")||"0";ai.height=ae.getAttribute("height")||"0";if(ae.getAttribute("class")){ai.styleclass=ae.getAttribute("class")}if(ae.getAttribute("align")){ai.align=ae.getAttribute("align")}var ah={};var X=ae.getElementsByTagName("param");var ac=X.length;for(var ad=0;ad<ac;ad++){if(X[ad].getAttribute("name").toLowerCase()!="movie"){ah[X[ad].getAttribute("name")]=X[ad].getAttribute("value")}}P(ai,ah,Y,ab)}else{p(ae);if(ab){ab(aa)}}}}}else{w(Y,true);if(ab){var Z=z(Y);if(Z&&typeof Z.SetVariable!=D){aa.success=true;aa.ref=Z}ab(aa)}}}}}function z(aa){var X=null;var Y=c(aa);if(Y&&Y.nodeName=="OBJECT"){if(typeof Y.SetVariable!=D){X=Y}else{var Z=Y.getElementsByTagName(r)[0];if(Z){X=Z}}}return X}function A(){return !a&&F("6.0.65")&&(M.win||M.mac)&&!(M.wk&&M.wk<312)}function P(aa,ab,X,Z){a=true;E=Z||null;B={success:false,id:X};var ae=c(X);if(ae){if(ae.nodeName=="OBJECT"){l=g(ae);Q=null}else{l=ae;Q=X}aa.id=R;if(typeof aa.width==D||(!/%$/.test(aa.width)&&parseInt(aa.width,10)<310)){aa.width="310"}if(typeof aa.height==D||(!/%$/.test(aa.height)&&parseInt(aa.height,10)<137)){aa.height="137"}j.title=j.title.slice(0,47)+" - Flash Player Installation";var ad=M.ie&&M.win?"ActiveX":"PlugIn",ac="MMredirectURL="+O.location.toString().replace(/&/g,"%26")+"&MMplayerType="+ad+"&MMdoctitle="+j.title;if(typeof ab.flashvars!=D){ab.flashvars+="&"+ac}else{ab.flashvars=ac}if(M.ie&&M.win&&ae.readyState!=4){var Y=C("div");X+="SWFObjectNew";Y.setAttribute("id",X);ae.parentNode.insertBefore(Y,ae);ae.style.display="none";(function(){if(ae.readyState==4){ae.parentNode.removeChild(ae)}else{setTimeout(arguments.callee,10)}})()}u(aa,ab,X)}}function p(Y){if(M.ie&&M.win&&Y.readyState!=4){var X=C("div");Y.parentNode.insertBefore(X,Y);X.parentNode.replaceChild(g(Y),X);Y.style.display="none";(function(){if(Y.readyState==4){Y.parentNode.removeChild(Y)}else{setTimeout(arguments.callee,10)}})()}else{Y.parentNode.replaceChild(g(Y),Y)}}function g(ab){var aa=C("div");if(M.win&&M.ie){aa.innerHTML=ab.innerHTML}else{var Y=ab.getElementsByTagName(r)[0];if(Y){var ad=Y.childNodes;if(ad){var X=ad.length;for(var Z=0;Z<X;Z++){if(!(ad[Z].nodeType==1&&ad[Z].nodeName=="PARAM")&&!(ad[Z].nodeType==8)){aa.appendChild(ad[Z].cloneNode(true))}}}}}return aa}function u(ai,ag,Y){var X,aa=c(Y);if(M.wk&&M.wk<312){return X}if(aa){if(typeof ai.id==D){ai.id=Y}if(M.ie&&M.win){var ah="";for(var ae in ai){if(ai[ae]!=Object.prototype[ae]){if(ae.toLowerCase()=="data"){ag.movie=ai[ae]}else{if(ae.toLowerCase()=="styleclass"){ah+=' class="'+ai[ae]+'"'}else{if(ae.toLowerCase()!="classid"){ah+=" "+ae+'="'+ai[ae]+'"'}}}}}var af="";for(var ad in ag){if(ag[ad]!=Object.prototype[ad]){af+='<param name="'+ad+'" value="'+ag[ad]+'" />'}}aa.outerHTML='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"'+ah+">"+af+"</object>";N[N.length]=ai.id;X=c(ai.id)}else{var Z=C(r);Z.setAttribute("type",q);for(var ac in ai){if(ai[ac]!=Object.prototype[ac]){if(ac.toLowerCase()=="styleclass"){Z.setAttribute("class",ai[ac])}else{if(ac.toLowerCase()!="classid"){Z.setAttribute(ac,ai[ac])}}}}for(var ab in ag){if(ag[ab]!=Object.prototype[ab]&&ab.toLowerCase()!="movie"){e(Z,ab,ag[ab])}}aa.parentNode.replaceChild(Z,aa);X=Z}}return X}function e(Z,X,Y){var aa=C("param");aa.setAttribute("name",X);aa.setAttribute("value",Y);Z.appendChild(aa)}function y(Y){var X=c(Y);if(X&&X.nodeName=="OBJECT"){if(M.ie&&M.win){X.style.display="none";(function(){if(X.readyState==4){b(Y)}else{setTimeout(arguments.callee,10)}})()}else{X.parentNode.removeChild(X)}}}function b(Z){var Y=c(Z);if(Y){for(var X in Y){if(typeof Y[X]=="function"){Y[X]=null}}Y.parentNode.removeChild(Y)}}function c(Z){var X=null;try{X=j.getElementById(Z)}catch(Y){}return X}function C(X){return j.createElement(X)}function i(Z,X,Y){Z.attachEvent(X,Y);I[I.length]=[Z,X,Y]}function F(Z){var Y=M.pv,X=Z.split(".");X[0]=parseInt(X[0],10);X[1]=parseInt(X[1],10)||0;X[2]=parseInt(X[2],10)||0;return(Y[0]>X[0]||(Y[0]==X[0]&&Y[1]>X[1])||(Y[0]==X[0]&&Y[1]==X[1]&&Y[2]>=X[2]))?true:false}function v(ac,Y,ad,ab){if(M.ie&&M.mac){return}var aa=j.getElementsByTagName("head")[0];if(!aa){return}var X=(ad&&typeof ad=="string")?ad:"screen";if(ab){n=null;G=null}if(!n||G!=X){var Z=C("style");Z.setAttribute("type","text/css");Z.setAttribute("media",X);n=aa.appendChild(Z);if(M.ie&&M.win&&typeof j.styleSheets!=D&&j.styleSheets.length>0){n=j.styleSheets[j.styleSheets.length-1]}G=X}if(M.ie&&M.win){if(n&&typeof n.addRule==r){n.addRule(ac,Y)}}else{if(n&&typeof j.createTextNode!=D){n.appendChild(j.createTextNode(ac+" {"+Y+"}"))}}}function w(Z,X){if(!m){return}var Y=X?"visible":"hidden";if(J&&c(Z)){c(Z).style.visibility=Y}else{v("#"+Z,"visibility:"+Y)}}function L(Y){var Z=/[\\\"<>\.;]/;var X=Z.exec(Y)!=null;return X&&typeof encodeURIComponent!=D?encodeURIComponent(Y):Y}var d=function(){if(M.ie&&M.win){window.attachEvent("onunload",function(){var ac=I.length;for(var ab=0;ab<ac;ab++){I[ab][0].detachEvent(I[ab][1],I[ab][2])}var Z=N.length;for(var aa=0;aa<Z;aa++){y(N[aa])}for(var Y in M){M[Y]=null}M=null;for(var X in swfobject){swfobject[X]=null}swfobject=null})}}();return{registerObject:function(ab,X,aa,Z){if(M.w3&&ab&&X){var Y={};Y.id=ab;Y.swfVersion=X;Y.expressInstall=aa;Y.callbackFn=Z;o[o.length]=Y;w(ab,false)}else{if(Z){Z({success:false,id:ab})}}},getObjectById:function(X){if(M.w3){return z(X)}},embedSWF:function(ab,ah,ae,ag,Y,aa,Z,ad,af,ac){var X={success:false,id:ah};if(M.w3&&!(M.wk&&M.wk<312)&&ab&&ah&&ae&&ag&&Y){w(ah,false);K(function(){ae+="";ag+="";var aj={};if(af&&typeof af===r){for(var al in af){aj[al]=af[al]}}aj.data=ab;aj.width=ae;aj.height=ag;var am={};if(ad&&typeof ad===r){for(var ak in ad){am[ak]=ad[ak]}}if(Z&&typeof Z===r){for(var ai in Z){if(typeof am.flashvars!=D){am.flashvars+="&"+ai+"="+Z[ai]}else{am.flashvars=ai+"="+Z[ai]}}}if(F(Y)){var an=u(aj,am,ah);if(aj.id==ah){w(ah,true)}X.success=true;X.ref=an}else{if(aa&&A()){aj.data=aa;P(aj,am,ah,ac);return}else{w(ah,true)}}if(ac){ac(X)}})}else{if(ac){ac(X)}}},switchOffAutoHideShow:function(){m=false},ua:M,getFlashPlayerVersion:function(){return{major:M.pv[0],minor:M.pv[1],release:M.pv[2]}},hasFlashPlayerVersion:F,createSWF:function(Z,Y,X){if(M.w3){return u(Z,Y,X)}else{return undefined}},showExpressInstall:function(Z,aa,X,Y){if(M.w3&&A()){P(Z,aa,X,Y)}},removeSWF:function(X){if(M.w3){y(X)}},createCSS:function(aa,Z,Y,X){if(M.w3){v(aa,Z,Y,X)}},addDomLoadEvent:K,addLoadEvent:s,getQueryParamValue:function(aa){var Z=j.location.search||j.location.hash;if(Z){if(/\?/.test(Z)){Z=Z.split("?")[1]}if(aa==null){return L(Z)}var Y=Z.split("&");for(var X=0;X<Y.length;X++){if(Y[X].substring(0,Y[X].indexOf("="))==aa){return L(Y[X].substring((Y[X].indexOf("=")+1)))}}}return""},expressInstallCallback:function(){if(a){var X=c(R);if(X&&l){X.parentNode.replaceChild(l,X);if(Q){w(Q,true);if(M.ie&&M.win){l.style.display="block"}}if(E){E(B)}}a=false}}}}();
/*
Uploadify v2.1.0
Release Date: August 24, 2009
*/

if(jQuery)(
    function(jQuery){
        jQuery.extend(jQuery.fn,{
            uploadify:function(options) {
                jQuery(this).each(function(){
                    settings = jQuery.extend({
                        id             : jQuery(this).attr('id'), // The ID of the object being Uploadified
                        uploader       : 'uploadify.swf', // The path to the uploadify swf file
                        script         : 'uploadify.php', // The path to the uploadify backend upload script
                        expressInstall : null, // The path to the express install swf file
                        folder         : '', // The path to the upload folder
                        height         : 30, // The height of the flash button
                        width          : 110, // The width of the flash button
                        cancelImg      : 'cancel.png', // The path to the cancel image for the default file queue item container
                        wmode          : 'opaque', // The wmode of the flash file
                        scriptAccess   : 'sameDomain', // Set to "always" to allow script access across domains
                        fileDataName   : 'Filedata', // The name of the file collection object in the backend upload script
                        method         : 'POST', // The method for sending variables to the backend upload script
                        queueSizeLimit : 999, // The maximum size of the file queue
                        simUploadLimit : 1, // The number of simultaneous uploads allowed
                        queueID        : false, // The optional ID of the queue container
                        displayData    : 'percentage', // Set to "speed" to show the upload speed in the default queue item
                        onInit         : function() {}, // Function to run when uploadify is initialized
                        onSelect       : function() {}, // Function to run when a file is selected
                        onQueueFull    : function() {}, // Function to run when the queue reaches capacity
                        onCheck        : function() {}, // Function to run when script checks for duplicate files on the server
                        onCancel       : function() {}, // Function to run when an item is cleared from the queue
                        onError        : function() {}, // Function to run when an upload item returns an error
                        onProgress     : function() {}, // Function to run each time the upload progress is updated
                        onComplete     : function() {}, // Function to run when an upload is completed
                        onAllComplete  : function() {}  // Functino to run when all uploads are completed
                    }, options);
                    var pagePath = location.pathname;
                    pagePath = pagePath.split('/');
                    pagePath.pop();
                    pagePath = pagePath.join('/') + '/';
                    var data = {};
                    data.uploadifyID = settings.id;
                    data.pagepath = pagePath;
                    if (settings.buttonImg) data.buttonImg = escape(settings.buttonImg);
                    if (settings.buttonText) data.buttonText = escape(settings.buttonText);
                    if (settings.rollover) data.rollover = true;
                    data.script = settings.script;
                    data.folder = escape(settings.folder);
                    if (settings.scriptData) {
                        var scriptDataString = '';
                        for (var name in settings.scriptData) {
                            scriptDataString += '&' + name + '=' + settings.scriptData[name];
                        }
                        data.scriptData = escape(scriptDataString.substr(1));
                    }
                    data.width          = settings.width;
                    data.height         = settings.height;
                    data.wmode          = settings.wmode;
                    data.method         = settings.method;
                    data.queueSizeLimit = settings.queueSizeLimit;
                    data.simUploadLimit = settings.simUploadLimit;
                    if (settings.hideButton)   data.hideButton   = true;
                    if (settings.fileDesc)     data.fileDesc     = settings.fileDesc;
                    if (settings.fileExt)      data.fileExt      = settings.fileExt;
                    if (settings.multi)        data.multi        = true;
                    if (settings.auto)         data.auto         = true;
                    if (settings.sizeLimit)    data.sizeLimit    = settings.sizeLimit;
                    if (settings.checkScript)  data.checkScript  = settings.checkScript;
                    if (settings.fileDataName) data.fileDataName = settings.fileDataName;
                    if (settings.queueID)      data.queueID      = settings.queueID;
                    if (settings.onInit() !== false) {
                        jQuery(this).css('display','none');
                        jQuery(this).after('<div id="' + jQuery(this).attr('id') + 'Uploader"></div>');
                        swfobject.embedSWF(settings.uploader, settings.id + 'Uploader', settings.width, settings.height, '9.0.24', settings.expressInstall, data, {
                            'quality':'high',
                            'wmode':settings.wmode,
                            'allowScriptAccess':settings.scriptAccess
                            });
                        if (settings.queueID == false) {
                            jQuery("#" + jQuery(this).attr('id') + "Uploader").after('<div id="' + jQuery(this).attr('id') + 'Queue" class="uploadifyQueue"></div>');
                        }
                    }
                    if (typeof(settings.onOpen) == 'function') {
                        jQuery(this).bind("uploadifyOpen", settings.onOpen);
                    }
                    jQuery(this).bind("uploadifySelect", {
                        'action': settings.onSelect,
                        'queueID': settings.queueID
                        }, function(event, ID, fileObj) {
                        if (event.data.action(event, ID, fileObj) !== false) {
                            var byteSize = Math.round(fileObj.size / 1024 * 100) * .01;
                            var suffix = 'KB';
                            if (byteSize > 1000) {
                                byteSize = Math.round(byteSize *.001 * 100) * .01;
                                suffix = 'MB';
                            }
                            var sizeParts = byteSize.toString().split('.');
                            if (sizeParts.length > 1) {
                                byteSize = sizeParts[0] + '.' + sizeParts[1].substr(0,2);
                            } else {
                                byteSize = sizeParts[0];
                            }
                            if (fileObj.name.length > 20) {
                                fileName = fileObj.name.substr(0,20) + '...';
                            } else {
                                fileName = fileObj.name;
                            }
                            queue = '#' + jQuery(this).attr('id') + 'Queue';
                            if (event.data.queueID) {
                                queue = '#' + event.data.queueID;
                            }
                            jQuery(queue).append('<div id="' + jQuery(this).attr('id') + ID + '" class="uploadifyQueueItem">\
								<div class="uploadifyProgress">\
									<div id="' + jQuery(this).attr('id') + ID + 'ProgressBar" class="uploadifyProgressBar"><!--Progress Bar--></div>\
								</div>\
								<div class="cancel">\
									<a href="javascript:jQuery(\'#' + jQuery(this).attr('id') + '\').uploadifyCancel(\'' + ID + '\')"><img src="' + settings.cancelImg + '" border="0" /></a>\
								</div>\
								<span class="fileName">' + fileName + ' (' + byteSize + suffix + ')</span><span class="percentage"></span>\
							</div>');
                        }
                    });
                    if (typeof(settings.onSelectOnce) == 'function') {
                        jQuery(this).bind("uploadifySelectOnce", settings.onSelectOnce);
                    }
                    jQuery(this).bind("uploadifyQueueFull", {
                        'action': settings.onQueueFull
                        }, function(event, queueSizeLimit) {
                        if (event.data.action(event, queueSizeLimit) !== false) {
                            alert('The queue is full.  The max size is ' + queueSizeLimit + '.');
                        }
                    });
                    jQuery(this).bind("uploadifyCheckExist", {
                        'action': settings.onCheck
                        }, function(event, checkScript, fileQueueObj, folder, single) {
                        var postData = new Object();
                        postData = fileQueueObj;
                        postData.folder = pagePath + folder;
                        if (single) {
                            for (var ID in fileQueueObj) {
                                var singleFileID = ID;
                            }
                        }
                        jQuery.post(checkScript, postData, function(data) {
                            for(var key in data) {
                                if (event.data.action(event, checkScript, fileQueueObj, folder, single) !== false) {
                                    var replaceFile = confirm("Do you want to replace the file " + data[key] + "?");
                                    if (!replaceFile) {
                                        document.getElementById(jQuery(event.target).attr('id') + 'Uploader').cancelFileUpload(key, true,true);
                                    }
                                }
                            }
                            if (single) {
                                document.getElementById(jQuery(event.target).attr('id') + 'Uploader').startFileUpload(singleFileID, true);
                            } else {
                                document.getElementById(jQuery(event.target).attr('id') + 'Uploader').startFileUpload(null, true);
                            }
                        }, "json");
                    });
                    jQuery(this).bind("uploadifyCancel", {
                        'action': settings.onCancel
                        }, function(event, ID, fileObj, data, clearFast) {
                        if (event.data.action(event, ID, fileObj, data, clearFast) !== false) {
                            var fadeSpeed = (clearFast == true) ? 0 : 250;
                            jQuery("#" + jQuery(this).attr('id') + ID).fadeOut(fadeSpeed, function() {
                                jQuery(this).remove()
                            });
                        }
                    });
                    if (typeof(settings.onClearQueue) == 'function') {
                        jQuery(this).bind("uploadifyClearQueue", settings.onClearQueue);
                    }
                    var errorArray = [];
                    jQuery(this).bind("uploadifyError", {
                        'action': settings.onError
                        }, function(event, ID, fileObj, errorObj) {
                        if (event.data.action(event, ID, fileObj, errorObj) !== false) {
                            var fileArray = new Array(ID, fileObj, errorObj);
                            errorArray.push(fileArray);
                            jQuery("#" + jQuery(this).attr('id') + ID + " .percentage").text(" - " + errorObj.type + " Error");
                            jQuery("#" + jQuery(this).attr('id') + ID).addClass('uploadifyError');
                        }
                    });
                    jQuery(this).bind("uploadifyProgress", {
                        'action': settings.onProgress,
                        'toDisplay': settings.displayData
                        }, function(event, ID, fileObj, data) {
                        if (event.data.action(event, ID, fileObj, data) !== false) {
                            jQuery("#" + jQuery(this).attr('id') + ID + "ProgressBar").css('width', data.percentage + '%');
                            if (event.data.toDisplay == 'percentage') displayData = ' - ' + data.percentage + '%';
                            if (event.data.toDisplay == 'speed') displayData = ' - ' + data.speed + 'KB/s';
                            if (event.data.toDisplay == null) displayData = ' ';
                            jQuery("#" + jQuery(this).attr('id') + ID + " .percentage").text(displayData);
                        }
                    });
                    jQuery(this).bind("uploadifyComplete", {
                        'action': settings.onComplete
                        }, function(event, ID, fileObj, response, data) {
                        if (event.data.action(event, ID, fileObj, unescape(response), data) !== false) {
                            jQuery("#" + jQuery(this).attr('id') + ID + " .percentage").text(' - Completed');
                            jQuery("#" + jQuery(this).attr('id') + ID).fadeOut(250, function() {
                                jQuery(this).remove()
                                });
                        }
                    });
                    if (typeof(settings.onAllComplete) == 'function') {
                        jQuery(this).bind("uploadifyAllComplete", {
                            'action': settings.onAllComplete
                            }, function(event, uploadObj) {
                            if (event.data.action(event, uploadObj) !== false) {
                                errorArray = [];
                            }
                        });
                    }
                });
            },
            uploadifySettings:function(settingName, settingValue, resetObject) {
                var returnValue = false;
                jQuery(this).each(function() {
                    if (settingName == 'scriptData' && settingValue != null) {
                        if (resetObject) {
                            var scriptData = settingValue;
                        } else {
                            var scriptData = jQuery.extend(settings.scriptData, settingValue);
                        }
                        var scriptDataString = '';
                        for (var name in scriptData) {
                            scriptDataString += '&' + name + '=' + escape(scriptData[name]);
                        }
                        settingValue = scriptDataString.substr(1);
                    }
                    returnValue = document.getElementById(jQuery(this).attr('id') + 'Uploader').updateSettings(settingName, settingValue);
                });
                if (settingValue == null) {
                    if (settingName == 'scriptData') {
                        var returnSplit = unescape(returnValue).split('&');
                        var returnObj   = new Object();
                        for (var i = 0; i < returnSplit.length; i++) {
                            var iSplit = returnSplit[i].split('=');
                            returnObj[iSplit[0]] = iSplit[1];
                        }
                        returnValue = returnObj;
                    }
                    return returnValue;
                }
            },
            uploadifyUpload:function(ID) {
                jQuery(this).each(function() {
                    document.getElementById(jQuery(this).attr('id') + 'Uploader').startFileUpload(ID, false);
                });
            },
            uploadifyCancel:function(ID) {
                jQuery(this).each(function() {
                    document.getElementById(jQuery(this).attr('id') + 'Uploader').cancelFileUpload(ID, true, false);
                });
            },
            uploadifyClearQueue:function() {
                jQuery(this).each(function() {
                    document.getElementById(jQuery(this).attr('id') + 'Uploader').clearFileUploadQueue(false);
                });
            }
        })
    })(jQuery);
/*
 * jQuery Tools 1.2.3 - The missing UI library for the Web
 *
 * [tooltip, tooltip.slide, tooltip.dynamic]
 *
 * NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.
 *
 * http://flowplayer.org/tools/
 *
 * File generated: Tue Jul 27 11:24:46 GMT 2010
 */
(function(f){function p(a,b,c){var h=c.relative?a.position().top:a.offset().top,e=c.relative?a.position().left:a.offset().left,i=c.position[0];h-=b.outerHeight()-c.offset[0];e+=a.outerWidth()+c.offset[1];var j=b.outerHeight()+a.outerHeight();if(i=="center")h+=j/2;if(i=="bottom")h+=j;i=c.position[1];a=b.outerWidth()+a.outerWidth();if(i=="center")e-=a/2;if(i=="left")e-=a;return{top:h,left:e}}function t(a,b){var c=this,h=a.add(c),e,i=0,j=0,m=a.attr("title"),q=n[b.effect],k,r=a.is(":input"),u=r&&a.is(":checkbox, :radio, select, :button, :submit"),
s=a.attr("type"),l=b.events[s]||b.events[r?u?"widget":"input":"def"];if(!q)throw'Nonexistent effect "'+b.effect+'"';l=l.split(/,\s*/);if(l.length!=2)throw"Tooltip: bad events configuration for "+s;a.bind(l[0],function(d){clearTimeout(i);if(b.predelay)j=setTimeout(function(){c.show(d)},b.predelay);else c.show(d)}).bind(l[1],function(d){clearTimeout(j);if(b.delay)i=setTimeout(function(){c.hide(d)},b.delay);else c.hide(d)});if(m&&b.cancelDefault){a.removeAttr("title");a.data("title",m)}f.extend(c,{show:function(d){if(!e){if(m)e=
f(b.layout).addClass(b.tipClass).appendTo(document.body).hide().append(m);else if(b.tip)e=f(b.tip).eq(0);else{e=a.next();e.length||(e=a.parent().next())}if(!e.length)throw"Cannot find tooltip for "+a;}if(c.isShown())return c;e.stop(true,true);var g=p(a,e,b);d=d||f.Event();d.type="onBeforeShow";h.trigger(d,[g]);if(d.isDefaultPrevented())return c;g=p(a,e,b);e.css({position:"absolute",top:g.top,left:g.left});k=true;q[0].call(c,function(){d.type="onShow";k="full";h.trigger(d)});g=b.events.tooltip.split(/,\s*/);
e.bind(g[0],function(){clearTimeout(i);clearTimeout(j)});g[1]&&!a.is("input:not(:checkbox, :radio), textarea")&&e.bind(g[1],function(o){o.relatedTarget!=a[0]&&a.trigger(l[1].split(" ")[0])});return c},hide:function(d){if(!e||!c.isShown())return c;d=d||f.Event();d.type="onBeforeHide";h.trigger(d);if(!d.isDefaultPrevented()){k=false;n[b.effect][1].call(c,function(){d.type="onHide";k=false;h.trigger(d)});return c}},isShown:function(d){return d?k=="full":k},getConf:function(){return b},getTip:function(){return e},
getTrigger:function(){return a}});f.each("onHide,onBeforeShow,onShow,onBeforeHide".split(","),function(d,g){f.isFunction(b[g])&&f(c).bind(g,b[g]);c[g]=function(o){f(c).bind(g,o);return c}})}f.tools=f.tools||{version:"1.2.3"};f.tools.tooltip={conf:{effect:"toggle",fadeOutSpeed:"fast",predelay:0,delay:30,opacity:1,tip:0,position:["top","center"],offset:[0,0],relative:false,cancelDefault:true,events:{def:"mouseenter,mouseleave",input:"focus,blur",widget:"focus mouseenter,blur mouseleave",tooltip:"mouseenter,mouseleave"},
layout:"<div/>",tipClass:"tooltip"},addEffect:function(a,b,c){n[a]=[b,c]}};var n={toggle:[function(a){var b=this.getConf(),c=this.getTip();b=b.opacity;b<1&&c.css({opacity:b});c.show();a.call()},function(a){this.getTip().hide();a.call()}],fade:[function(a){var b=this.getConf();this.getTip().fadeTo(b.fadeInSpeed,b.opacity,a)},function(a){this.getTip().fadeOut(this.getConf().fadeOutSpeed,a)}]};f.fn.tooltip=function(a){var b=this.data("tooltip");if(b)return b;a=f.extend(true,{},f.tools.tooltip.conf,a);
if(typeof a.position=="string")a.position=a.position.split(/,?\s/);this.each(function(){b=new t(f(this),a);f(this).data("tooltip",b)});return a.api?b:this}})(jQuery);
(function(d){var i=d.tools.tooltip;d.extend(i.conf,{direction:"up",bounce:false,slideOffset:10,slideInSpeed:200,slideOutSpeed:200,slideFade:!d.browser.msie});var e={up:["-","top"],down:["+","top"],left:["-","left"],right:["+","left"]};i.addEffect("slide",function(g){var a=this.getConf(),f=this.getTip(),b=a.slideFade?{opacity:a.opacity}:{},c=e[a.direction]||e.up;b[c[1]]=c[0]+"="+a.slideOffset;a.slideFade&&f.css({opacity:0});f.show().animate(b,a.slideInSpeed,g)},function(g){var a=this.getConf(),f=a.slideOffset,
b=a.slideFade?{opacity:0}:{},c=e[a.direction]||e.up,h=""+c[0];if(a.bounce)h=h=="+"?"-":"+";b[c[1]]=h+"="+f;this.getTip().animate(b,a.slideOutSpeed,function(){d(this).hide();g.call()})})})(jQuery);
(function(g){function j(a){var c=g(window),d=c.width()+c.scrollLeft(),h=c.height()+c.scrollTop();return[a.offset().top<=c.scrollTop(),d<=a.offset().left+a.width(),h<=a.offset().top+a.height(),c.scrollLeft()>=a.offset().left]}function k(a){for(var c=a.length;c--;)if(a[c])return false;return true}var i=g.tools.tooltip;i.dynamic={conf:{classNames:"top right bottom left"}};g.fn.dynamic=function(a){if(typeof a=="number")a={speed:a};a=g.extend({},i.dynamic.conf,a);var c=a.classNames.split(/\s/),d;this.each(function(){var h=
g(this).tooltip().onBeforeShow(function(e,f){e=this.getTip();var b=this.getConf();d||(d=[b.position[0],b.position[1],b.offset[0],b.offset[1],g.extend({},b)]);g.extend(b,d[4]);b.position=[d[0],d[1]];b.offset=[d[2],d[3]];e.css({visibility:"hidden",position:"absolute",top:f.top,left:f.left}).show();f=j(e);if(!k(f)){if(f[2]){g.extend(b,a.top);b.position[0]="top";e.addClass(c[0])}if(f[3]){g.extend(b,a.right);b.position[1]="right";e.addClass(c[1])}if(f[0]){g.extend(b,a.bottom);b.position[0]="bottom";e.addClass(c[2])}if(f[1]){g.extend(b,
a.left);b.position[1]="left";e.addClass(c[3])}if(f[0]||f[2])b.offset[0]*=-1;if(f[1]||f[3])b.offset[1]*=-1}e.css({visibility:"visible"}).hide()});h.onBeforeShow(function(){var e=this.getConf();this.getTip();setTimeout(function(){e.position=[d[0],d[1]];e.offset=[d[2],d[3]]},0)});h.onHide(function(){var e=this.getTip();e.removeClass(a.classNames)});ret=h});return a.api?ret:this}})(jQuery);
// MSDropDown - jquery.dd.js
// author: Marghoob Suleman - Search me on google
// Date: 12th Aug, 2009
// Version: 2.3 {date: 12 June 2010}
// Revision: 28
// web: www.giftlelo.com | www.marghoobsuleman.com
/*
// msDropDown is free jQuery Plugin: you can redistribute it and/or modify
// it under the terms of the either the MIT License or the Gnu General Public License (GPL) Version 2
*/
;
(function($) {
    var msOldDiv = "";
    var dd = function(element, options)
    {
        var sElement = element;
        var $this =  this; //parent this
        var options = $.extend({
            height:120,
            visibleRows:7,
            rowHeight:23,
            showIcon:true,
            zIndex:1000,
            mainCSS:'dd',
            useSprite:true,
            onInit:'',
            style:''
        }, options);
        this.ddProp = new Object();//storing propeties;
        var selectedValue = "";
        var actionSettings ={};
        actionSettings.insideWindow = true;
        actionSettings.keyboardAction = false;
        actionSettings.currentKey = null;
        var ddList = false;
        var config = {
            postElementHolder:'_msddHolder',
            postID:'_msdd',
            postTitleID:'_title',
            postTitleTextID:'_titletext',
            postChildID:'_child',
            postAID:'_msa',
            postOPTAID:'_msopta',
            postInputID:'_msinput',
            postArrowID:'_arrow',
            postInputhidden:'_inp'
        };
        var styles = {
            dd:options.mainCSS,
            ddTitle:'ddTitle',
            arrow:'arrow',
            ddChild:'ddChild',
            ddTitleText:'ddTitleText',
            disabled:.30,
            ddOutOfVision:'ddOutOfVision'
        };
        var attributes = {
            actions:"focus,blur,change,click,dblclick,mousedown,mouseup,mouseover,mousemove,mouseout,keypress,keydown,keyup",
            prop:"size,multiple,disabled,tabindex"
        };
        this.onActions = new Object();
        var elementid = $(sElement).attr("id");
        var inlineCSS = $(sElement).attr("style");
        options.style += (inlineCSS==undefined) ? "" : inlineCSS;
        var allOptions = $(sElement).children();
        ddList = ($(sElement).attr("size")>0 || $(sElement).attr("multiple")==true) ? true : false;
        if(ddList) {
            options.visibleRows = $(sElement).attr("size");
        };
        var a_array = {};//stores id, html & value etc

        var getPostID = function (id) {
            return elementid+config[id];
        };
        var getOptionsProperties = function (option) {
            var currentOption = option;
            var styles = $(currentOption).attr("style");
            return styles;
        };
        var matchIndex = function (index) {
            var selectedIndex = $("#"+elementid+" option:selected");
            if(selectedIndex.length>1) {
                for(var i=0;i<selectedIndex.length;i++) {
                    if(index == selectedIndex[i].index) {
                        return true;
                    };
                };
            }else if(selectedIndex.length==1) {
                if(selectedIndex[0].index==index) {
                    return true;
                };
            };
            return false;
        };
        var createA = function(currentOptOption, current, currentopt, tp) {
            var aTag = "";
            //var aidfix = getPostID("postAID");
            var aidoptfix = (tp=="opt") ? getPostID("postOPTAID") : getPostID("postAID");
            var aid = (tp=="opt") ? aidoptfix+"_"+(current)+"_"+(currentopt) : aidoptfix+"_"+(current);
            var arrow = "";
            var clsName = "";
            if(options.useSprite!=false) {
                clsName = ' '+options.useSprite+' '+currentOptOption.className;
            } else {
                arrow = $(currentOptOption).attr("title");
                arrow = (arrow.length==0) ? "" : '<img src="'+arrow+'" align="absmiddle" /> ';
            };
            //console.debug("clsName "+clsName);
            var sText = $(currentOptOption).text();
            var sValue = $(currentOptOption).val();
            var sEnabledClass = ($(currentOptOption).attr("disabled")==true) ? "disabled" : "enabled";
            a_array[aid] = {
                html:arrow + sText,
                value:sValue,
                text:sText,
                index:currentOptOption.index,
                id:aid
            };
            var innerStyle = getOptionsProperties(currentOptOption);
            if(matchIndex(currentOptOption.index)==true) {
                aTag += '<a href="javascript:void(0);" class="selected '+sEnabledClass+clsName+'"';
            } else {
                aTag += '<a  href="javascript:void(0);" class="'+sEnabledClass+clsName+'"';
            };
            if(innerStyle!==false && innerStyle!==undefined) {
                aTag +=  " style='"+innerStyle+"'";
            };
            aTag +=  ' id="'+aid+'">';
            aTag += arrow + '<span class="'+styles.ddTitleText+'">' +sText+'</span></a>';
            return aTag;
        };
        var createATags = function () {
            var childnodes = allOptions;
            if(childnodes.length==0) return "";
            var aTag = "";
            var aidfix = getPostID("postAID");
            var aidoptfix = getPostID("postOPTAID");
            childnodes.each(function(current){
                var currentOption = childnodes[current];
                //OPTGROUP
                if(currentOption.nodeName == "OPTGROUP") {
                    aTag += "<div class='opta'>";
                    aTag += "<span style='font-weight:bold;font-style:italic; clear:both;'>"+$(currentOption).attr("label")+"</span>";
                    var optChild = $(currentOption).children();
                    optChild.each(function(currentopt){
                        var currentOptOption = optChild[currentopt];
                        aTag += createA(currentOptOption, current, currentopt, "opt");
                    });
                    aTag += "</div>";

                } else {
                    aTag += createA(currentOption, current, "", "");
                };
            });
            return aTag;
        };
        var createChildDiv = function () {
            var id = getPostID("postID");
            var childid = getPostID("postChildID");
            var sStyle = options.style;
            sDiv = "";
            sDiv += '<div id="'+childid+'" class="'+styles.ddChild+'"';
            if(!ddList) {
                sDiv += (sStyle!="") ? ' style="'+sStyle+'"' : '';
            } else {
                sDiv += (sStyle!="") ? ' style="border-top:1px solid #c3c3c3;display:block;position:relative;'+sStyle+'"' : '';
            }
            sDiv += '>';
            return sDiv;
        };

        var createTitleDiv = function () {
            var titleid = getPostID("postTitleID");
            var arrowid = getPostID("postArrowID");
            var titletextid = getPostID("postTitleTextID");
            var inputhidden = getPostID("postInputhidden");
            var sText = "";
            var arrow = "";
            if(document.getElementById(elementid).options.length>0) {
                sText = $("#"+elementid+" option:selected").text();
                arrow = $("#"+elementid+" option:selected").attr("title");
            };
            //console.debug("sObj	 "+sObj.length);
            arrow = (arrow.length==0 || arrow==undefined || options.showIcon==false || options.useSprite!=false) ? "" : '<img src="'+arrow+'" align="absmiddle" /> ';
            var sDiv = '<div id="'+titleid+'" class="'+styles.ddTitle+'"';
            sDiv += '>';
            sDiv += '<span id="'+arrowid+'" class="'+styles.arrow+'"></span><span class="'+styles.ddTitleText+'" id="'+titletextid+'">'+arrow + '<span class="'+styles.ddTitleText+'">'+sText+'</span></span></div>';
            return sDiv;
        };
        var applyEventsOnA = function() {
            var childid = getPostID("postChildID");
            $("#"+childid+ " a.enabled").bind("click", function(event) {
                event.preventDefault();
                manageSelection(this);
                if(!ddList) {
                    $("#"+childid).unbind("mouseover");
                    setInsideWindow(false);
                    var sText = (options.showIcon==false) ? $(this).text() : $(this).html();
                    //alert("sText "+sText);
                    setTitleText(sText);
                    //$this.data("dd").close();
                    $this.close();
                };
                setValue();
            //actionSettings.oldIndex = a_array[$($this).attr("id")].index;
            });
        };
        var createDropDown = function () {
            var changeInsertionPoint = false;
            var id = getPostID("postID");
            var titleid = getPostID("postTitleID");
            var titletextid = getPostID("postTitleTextID");
            var childid = getPostID("postChildID");
            var arrowid = getPostID("postArrowID");
            var iWidth = $("#"+elementid).width();
            iWidth = iWidth+2;//it always give -2 width; i dont know why
            var sStyle = options.style;
            if($("#"+id).length>0) {
                $("#"+id).remove();
                changeInsertionPoint = true;
            };
            var sDiv = '<div id="'+id+'" class="'+styles.dd+'"';
            sDiv += (sStyle!="") ? ' style="'+sStyle+'"' : '';
            sDiv += '>';
            //create title bar
            sDiv += createTitleDiv();
            //create child
            sDiv += createChildDiv();
            sDiv += createATags();
            sDiv += "</div>";
            sDiv += "</div>";
            if(changeInsertionPoint==true) {
                var sid =getPostID("postElementHolder");
                $("#"+sid).after(sDiv);
            } else {
                $("#"+elementid).after(sDiv);
            };
            if(ddList) {
                var titleid = getPostID("postTitleID");
                $("#"+titleid).hide();
            };

            $("#"+id).css("width", iWidth+"px");
            $("#"+childid).css("width", (iWidth-2)+"px");
            if(allOptions.length>options.visibleRows) {
                var margin = parseInt($("#"+childid+" a:first").css("padding-bottom")) + parseInt($("#"+childid+" a:first").css("padding-top"));
                var iHeight = ((options.rowHeight)*options.visibleRows) - margin;
                $("#"+childid).css("height", iHeight+"px");
            } else if(ddList) {
                var iHeight = $("#"+elementid).height();
                $("#"+childid).css("height", iHeight+"px");
            };
            //set out of vision
            if(changeInsertionPoint==false) {
                setOutOfVision();
                addRefreshMethods(elementid);
            };
            if($("#"+elementid).attr("disabled")==true) {
                $("#"+id).css("opacity", styles.disabled);
            };
            applyEvents();
            //add events
            //arrow hightlight
            $("#"+titleid).bind("mouseover", function(event) {
                hightlightArrow(1);
            });
            $("#"+titleid).bind("mouseout", function(event) {
                hightlightArrow(0);
            });
            //open close events
            applyEventsOnA();
            $("#"+childid+ " a.disabled").css("opacity", styles.disabled);
            if(ddList) {
                $("#"+childid).bind("mouseover", function(event) {
                    if(!actionSettings.keyboardAction) {
                        actionSettings.keyboardAction = true;
                        $(document).bind("keydown", function(event) {
                            var keyCode = event.keyCode;
                            actionSettings.currentKey = keyCode;
                            if(keyCode==39 || keyCode==40) {
                                //move to next
                                event.preventDefault();
                                event.stopPropagation();
                                next();
                                setValue();
                            };
                            if(keyCode==37 || keyCode==38) {
                                event.preventDefault();
                                event.stopPropagation();
                                //move to previous
                                previous();
                                setValue();
                            };
                        });

                    }
                });
        };
        $("#"+childid).bind("mouseout", function(event) {
            setInsideWindow(false);
            $(document).unbind("keydown");
            actionSettings.keyboardAction = false;
            actionSettings.currentKey=null;
        });
        $("#"+titleid).bind("click", function(event) {
            setInsideWindow(false);
            if($("#"+childid+":visible").length==1) {
                $("#"+childid).unbind("mouseover");
            } else {
                $("#"+childid).bind("mouseover", function(event) {
                    setInsideWindow(true);
                });
                //alert("open "+elementid + $this);
                //$this.data("dd").openMe();
                $this.open();
            };
        });
        $("#"+titleid).bind("mouseout", function(evt) {
            setInsideWindow(false);
        });
        if(options.showIcon && options.useSprite!=false) {
            setTitleImageSprite();
        };
    };
    var getByIndex = function (index) {
        for(var i in a_array) {
            if(a_array[i].index==index) {
                return a_array[i];
            };
        };
        return -1;
    };
    var manageSelection = function (obj) {
        var childid = getPostID("postChildID");
        if(!ddList) {
            $("#"+childid+ " a.selected").removeClass("selected");
        };
        var selectedA = $("#"+childid + " a.selected").attr("id");
        if(selectedA!=undefined) {
            var oldIndex = (actionSettings.oldIndex==undefined || actionSettings.oldIndex==null) ? a_array[selectedA].index : actionSettings.oldIndex;
        };
        if(obj && !ddList) {
            $(obj).addClass("selected");
        };
        if(ddList) {
            var keyCode = actionSettings.currentKey;
            if($("#"+elementid).attr("multiple")==true) {
                if(keyCode == 17) {
                    //control
                    actionSettings.oldIndex = a_array[$(obj).attr("id")].index;
                    $(obj).toggleClass("selected");
                //multiple
                } else if(keyCode==16) {
                    $("#"+childid+ " a.selected").removeClass("selected");
                    $(obj).addClass("selected");
                    //shift
                    var currentSelected = $(obj).attr("id");
                    var currentIndex = a_array[currentSelected].index;
                    for(var i=Math.min(oldIndex, currentIndex);i<=Math.max(oldIndex, currentIndex);i++) {
                        $("#"+getByIndex(i).id).addClass("selected");
                    }
                } else {
                    $("#"+childid+ " a.selected").removeClass("selected");
                    $(obj).addClass("selected");
                    actionSettings.oldIndex = a_array[$(obj).attr("id")].index;
                };
            } else {
                $("#"+childid+ " a.selected").removeClass("selected");
                $(obj).addClass("selected");
                actionSettings.oldIndex = a_array[$(obj).attr("id")].index;
            };
        //isSingle
        };
    };
    var addRefreshMethods = function (id) {
        //deprecated
        var objid = id;
        document.getElementById(objid).refresh = function(e) {
            $("#"+objid).msDropDown(options);
        };
    };
    var setInsideWindow = function (val) {
        actionSettings.insideWindow = val;
    };
    var getInsideWindow = function () {
        return actionSettings.insideWindow;
    };
    var applyEvents = function () {
        var mainid = getPostID("postID");
        var actions_array = attributes.actions.split(",");
        for(var iCount=0;iCount<actions_array.length;iCount++) {
            var action = actions_array[iCount];
            //var actionFound = $("#"+elementid).attr(action);
            var actionFound = has_handler(action);//$("#"+elementid).attr(action);
            //console.debug(elementid +" action " + action , "actionFound "+actionFound);
            if(actionFound==true) {
                switch(action) {
                    case "focus":
                        $("#"+mainid).bind("mouseenter", function(event) {
                            document.getElementById(elementid).focus();
                        //$("#"+elementid).focus();
                        });
                        break;
                    case "click":
                        $("#"+mainid).bind("click", function(event) {
                            //document.getElementById(elementid).onclick();
                            $("#"+elementid).trigger("click");
                        });
                        break;
                    case "dblclick":
                        $("#"+mainid).bind("dblclick", function(event) {
                            //document.getElementById(elementid).ondblclick();
                            $("#"+elementid).trigger("dblclick");
                        });
                        break;
                    case "mousedown":
                        $("#"+mainid).bind("mousedown", function(event) {
                            //document.getElementById(elementid).onmousedown();
                            $("#"+elementid).trigger("mousedown");
                        });
                        break;
                    case "mouseup":
                        //has in close mthod
                        $("#"+mainid).bind("mouseup", function(event) {
                            //document.getElementById(elementid).onmouseup();
                            $("#"+elementid).trigger("mouseup");
                        //setValue();
                        });
                        break;
                    case "mouseover":
                        $("#"+mainid).bind("mouseover", function(event) {
                            //document.getElementById(elementid).onmouseover();
                            $("#"+elementid).trigger("mouseover");
                        });
                        break;
                    case "mousemove":
                        $("#"+mainid).bind("mousemove", function(event) {
                            //document.getElementById(elementid).onmousemove();
                            $("#"+elementid).trigger("mousemove");
                        });
                        break;
                    case "mouseout":
                        $("#"+mainid).bind("mouseout", function(event) {
                            //document.getElementById(elementid).onmouseout();
                            $("#"+elementid).trigger("mouseout");
                        });
                        break;
                };
            };
        };

    };
    var setOutOfVision = function () {
        var sId = getPostID("postElementHolder");
        $("#"+elementid).after("<div class='"+styles.ddOutOfVision+"' style='height:0px;overflow:hidden;position:absolute;' id='"+sId+"'></div>");
        $("#"+elementid).appendTo($("#"+sId));
    };
    var setTitleText = function (sText) {
        var titletextid = getPostID("postTitleTextID");
        $("#"+titletextid).html(sText);
    };
    var next = function () {
        var titletextid = getPostID("postTitleTextID");
        var childid = getPostID("postChildID");
        var allAs = $("#"+childid + " a.enabled");
        for(var current=0;current<allAs.length;current++) {
            var currentA = allAs[current];
            var id = $(currentA).attr("id");
            if($(currentA).hasClass("selected") && current<allAs.length-1) {
                $("#"+childid + " a.selected").removeClass("selected");
                $(allAs[current+1]).addClass("selected");
                //manageSelection(allAs[current+1]);
                var selectedA = $("#"+childid + " a.selected").attr("id");
                if(!ddList) {
                    var sText = (options.showIcon==false) ? a_array[selectedA].text : a_array[selectedA].html;
                    setTitleText(sText);
                };
                if(parseInt(($("#"+selectedA).position().top+$("#"+selectedA).height()))>=parseInt($("#"+childid).height())) {
                    $("#"+childid).scrollTop(($("#"+childid).scrollTop())+$("#"+selectedA).height()+$("#"+selectedA).height());
                };
                break;
            };
        };
    };
    var previous = function () {
        var titletextid = getPostID("postTitleTextID");
        var childid = getPostID("postChildID");
        var allAs = $("#"+childid + " a.enabled");
        for(var current=0;current<allAs.length;current++) {
            var currentA = allAs[current];
            var id = $(currentA).attr("id");
            if($(currentA).hasClass("selected") && current!=0) {
                $("#"+childid + " a.selected").removeClass("selected");
                $(allAs[current-1]).addClass("selected");
                //manageSelection(allAs[current-1]);
                var selectedA = $("#"+childid + " a.selected").attr("id");
                if(!ddList) {
                    var sText = (options.showIcon==false) ? a_array[selectedA].text : a_array[selectedA].html;
                    setTitleText(sText);
                };
                if(parseInt(($("#"+selectedA).position().top+$("#"+selectedA).height())) <=0) {
                    $("#"+childid).scrollTop(($("#"+childid).scrollTop()-$("#"+childid).height())-$("#"+selectedA).height());
                };
                break;
            };
        };
    };
    var setTitleImageSprite = function() {
        if(options.useSprite!=false) {
            var titletextid = getPostID("postTitleTextID");
            var sClassName = document.getElementById(elementid).options[document.getElementById(elementid).selectedIndex].className;
            if(sClassName.length>0) {
                var childid = getPostID("postChildID");
                var id = $("#"+childid + " a."+sClassName).attr("id");
                var backgroundImg = $("#"+id).css("background-image");
                var backgroundPosition = $("#"+id).css("background-position");
                var paddingLeft = $("#"+id).css("padding-left");
                if(backgroundImg!=undefined) {
                    $("#"+titletextid).find("."+styles.ddTitleText).attr('style', "background:"+backgroundImg);
                };
                if(backgroundPosition!=undefined) {
                    $("#"+titletextid).find("."+styles.ddTitleText).css('background-position', backgroundPosition);
                };
                if(paddingLeft!=undefined) {
                    $("#"+titletextid).find("."+styles.ddTitleText).css('padding-left', paddingLeft);
                };
                $("#"+titletextid).find("."+styles.ddTitleText).css('background-repeat', 'no-repeat');
                $("#"+titletextid).find("."+styles.ddTitleText).css('padding-bottom', '2px');
            };
        };
    };
    var setValue = function () {
        //alert("setValue "+elementid);
        var childid = getPostID("postChildID");
        var allSelected = $("#"+childid + " a.selected");
        if(allSelected.length==1) {
            var sText = $("#"+childid + " a.selected").text();
            var selectedA = $("#"+childid + " a.selected").attr("id");
            if(selectedA!=undefined) {
                var sValue = a_array[selectedA].value;
                document.getElementById(elementid).selectedIndex = a_array[selectedA].index;
            };
            //set image on title if using sprite
            if(options.showIcon && options.useSprite!=false)
                setTitleImageSprite();
        } else if(allSelected.length>1) {
            var alls = $("#"+elementid +" > option:selected").removeAttr("selected");
            for(var i=0;i<allSelected.length;i++) {
                var selectedA = $(allSelected[i]).attr("id");
                var index = a_array[selectedA].index;
                document.getElementById(elementid).options[index].selected = "selected";
            };
        };
        //alert(document.getElementById(elementid).selectedIndex);
        var sIndex = document.getElementById(elementid).selectedIndex;
        $this.ddProp["selectedIndex"]= sIndex;
    //alert("selectedIndex "+ $this.ddProp["selectedIndex"] + " sIndex "+sIndex);
    };
    var has_handler = function (name) {
        // True if a handler has been added in the html.
        if ($("#"+elementid).attr("on" + name) != undefined) {
            return true;
        };
        // True if a handler has been added using jQuery.
        var evs = $("#"+elementid).data("events");
        if (evs && evs[name]) {
            return true;
        };
        return false;
    };
    var checkMethodAndApply = function () {
        var childid = getPostID("postChildID");
        if(has_handler('change')==true) {
            //alert(1);
            var currentSelectedValue = a_array[$("#"+childid +" a.selected").attr("id")].text;
            if(selectedValue!=currentSelectedValue){
                $("#"+elementid).trigger("change");
            };
        };
        if(has_handler('mouseup')==true) {
            $("#"+elementid).trigger("mouseup");
        };
        if(has_handler('blur')==true) {
            $(document).bind("mouseup", function(evt) {
                $("#"+elementid).focus();
                $("#"+elementid)[0].blur();
                setValue();
                $(document).unbind("mouseup");
            });
        };
    };
    var hightlightArrow = function(ison) {
        var arrowid = getPostID("postArrowID");
        if(ison==1)
            $("#"+arrowid).css({
                backgroundPosition:'0 100%'
            });
        else
            $("#"+arrowid).css({
                backgroundPosition:'0 0'
            });
    };
    var setOriginalProperties = function() {
        //properties = {};
        //alert($this.data("dd"));
        for(var i in document.getElementById(elementid)) {
            if(typeof(document.getElementById(elementid)[i])!='function' && document.getElementById(elementid)[i]!==undefined && document.getElementById(elementid)[i]!==null) {
                $this.set(i, document.getElementById(elementid)[i], true);//true = setting local properties
            };
        };
    };
    var setValueByIndex = function(prop, val) {
        if(getByIndex(val) != -1) {
            document.getElementById(elementid)[prop] = val;
            var childid = getPostID("postChildID");
            $("#"+childid+ " a.selected").removeClass("selected");
            $("#"+getByIndex(val).id).addClass("selected");
            var sText = getByIndex(document.getElementById(elementid).selectedIndex).html;
            setTitleText(sText);
        };
    };
    var addRemoveFromIndex = function(i, action) {
        if(action=='d') {
            for(var key in a_array) {
                if(a_array[key].index == i) {
                    delete a_array[key];
                    break;
                };
            };
        };
        //update index
        var count = 0;
        for(var key in a_array) {
            a_array[key].index = count;
            count++;
        };
    };
    /************* public methods *********************/
    this.open = function() {
        if(($this.get("disabled", true) == true) || ($this.get("options", true).length==0)) return;
        var childid = getPostID("postChildID");
        if(msOldDiv!="" && childid!=msOldDiv) {
            $("#"+msOldDiv).fadeOut(430);
            $("#"+msOldDiv).css({
                zIndex:'0'
            });
        };
        if($("#"+childid).css("display")=="none") {
            //selectedValue = a_array[$("#"+childid +" a.selected").attr("id")].text;
            $(document).bind("keydown", function(event) {
                var keyCode = event.keyCode;
                if(keyCode==39 || keyCode==40) {
                    //move to next
                    event.preventDefault();
                    event.stopPropagation();
                    next();
                };
                if(keyCode==37 || keyCode==38) {
                    event.preventDefault();
                    event.stopPropagation();
                    //move to previous
                    previous();
                };
                if(keyCode==27 || keyCode==13) {
                    //$this.data("dd").close();
                    $this.close();
                    setValue();
                };
                if($("#"+elementid).attr("onkeydown")!=undefined) {
                    document.getElementById(elementid).onkeydown();
                };
            });
            $(document).bind("keyup", function(event) {
                if($("#"+elementid).attr("onkeyup")!=undefined) {
                    //$("#"+elementid).keyup();
                    document.getElementById(elementid).onkeyup();
                };
            });

            $(document).bind("mouseup", function(evt){
                if(getInsideWindow()==false) {
                    //alert("evt.target: "+evt.target);
                    //$this.data("dd").close();
                    $this.close();
                };
            });
            $("#"+childid).css({
                zIndex:options.zIndex
                });
                maxpos=$(document).height();
            $("#"+childid).fadeIn(430, function() {
                if($this.onActions["onOpen"]!=null) {
                    eval($this.onActions["onOpen"])($this);
                };
                p=$("#"+childid).position();
                if(parseInt(p.top)+parseInt($("#"+childid).height())>maxpos){
                    $("#"+childid).css({
                        "margin-top":($("#"+childid).height()+$(".ddTitle").height())*-1,
                        "border-top":"1px solid"
                    });
                }
            });
            if(childid!=msOldDiv) {
                msOldDiv = childid;
            };
        };
    };
    this.close = function() {
        var childid = getPostID("postChildID");
        $(document).unbind("keydown");
        $(document).unbind("keyup");
        $(document).unbind("mouseup");
        $("#"+childid).fadeOut(430, function(event) {
            checkMethodAndApply();
            $("#"+childid).css({
                zIndex:'0'
            });
            if($this.onActions["onClose"]!=null) {
                eval($this.onActions["onClose"])($this);
            };
        });

    };
    this.selectedIndex = function(i) {
        $this.set("selectedIndex", i);
    };
    //update properties
    this.set = function(prop, val, isLocal) {
        //alert("- set " + prop + " : "+val);
        if(prop==undefined || val==undefined) throw {
            message:"set to what?"
        };
        $this.ddProp[prop] = val;
        if(isLocal!=true) {
            switch(prop) {
                case "selectedIndex":
                    setValueByIndex(prop, val);
                    break;
                case "disabled":
                    $this.disabled(val, true);
                    break;
                case "multiple":
                    document.getElementById(elementid)[prop] = val;
                    ddList = ($(sElement).attr("size")>0 || $(sElement).attr("multiple")==true) ? true : false;
                    if(ddList) {
                        //do something
                        var iHeight = $("#"+elementid).height();
                        var childid = getPostID("postChildID");
                        $("#"+childid).css("height", iHeight+"px");
                        //hide titlebar
                        var titleid = getPostID("postTitleID");
                        $("#"+titleid).hide();
                        var childid = getPostID("postChildID");
                        $("#"+childid).css({
                            display:'block',
                            position:'relative'
                        });
                        applyEventsOnA();
                    }
                    break;
                case "size":
                    document.getElementById(elementid)[prop] = val;
                    if(val==0) {
                        document.getElementById(elementid).multiple = false;
                    };
                    ddList = ($(sElement).attr("size")>0 || $(sElement).attr("multiple")==true) ? true : false;
                    if(val==0) {
                        //show titlebar
                        var titleid = getPostID("postTitleID");
                        $("#"+titleid).show();
                        var childid = getPostID("postChildID");
                        $("#"+childid).css({
                            display:'none',
                            position:'absolute'
                        });
                        var sText = "";
                        if(document.getElementById(elementid).selectedIndex>=0) {
                            var aObj = getByIndex(document.getElementById(elementid).selectedIndex);
                            sText = aObj.html;
                            manageSelection($("#"+aObj.id));
                        };
                        setTitleText(sText);
                    } else {
                        //hide titlebar
                        var titleid = getPostID("postTitleID");
                        $("#"+titleid).hide();
                        var childid = getPostID("postChildID");
                        $("#"+childid).css({
                            display:'block',
                            position:'relative'
                        });
                    };
                    break;
                default:
                    try{
                        //check if this is not a readonly properties
                        document.getElementById(elementid)[prop] = val;
                    } catch(e) {
                    //silent
                    };
                    break;
            };
        };
    //alert("get " + prop + " : "+$this.ddProp[prop]);
    //$this.set("selectedIndex", 0);
    };
    this.get = function(prop, forceRefresh) {
        if(prop==undefined && forceRefresh==undefined) {
            //alert("c1 : " +$this.ddProp);
            return $this.ddProp;
        };
        if(prop!=undefined && forceRefresh==undefined) {
            //alert("c2 : " +$this.ddProp[prop]);
            return ($this.ddProp[prop]!=undefined) ? $this.ddProp[prop] : null;
        };
        if(prop!=undefined && forceRefresh!=undefined) {
            //alert("c3 : " +document.getElementById(elementid)[prop]);
            return document.getElementById(elementid)[prop];
        };
    };
    this.visible = function(val) {
        var id = getPostID("postID");
        if(val==true) {
            $("#"+id).show();
        } else if(val==false) {
            $("#"+id).hide();
        } else {
            return $("#"+id).css("display");
        };
    };
    this.add = function(opt, index) {
        var objOpt = opt;
        var sText = objOpt.text;
        var sValue = (objOpt.value==undefined || objOpt.value==null) ? sText : objOpt.value;
        var img = (objOpt.title==undefined || objOpt.title==null) ? '' : objOpt.title;
        var i = (index==undefined || index==null) ? document.getElementById(elementid).options.length : index;
        document.getElementById(elementid).options[i] = new Option(sText, sValue);
        if(img!='') document.getElementById(elementid).options[i].title = img;
        //check if exist
        var ifA = getByIndex(i);
        if(ifA != -1) {
            //replace
            var aTag = createA(document.getElementById(elementid).options[i], i, "", "");
            $("#"+ifA.id).html(aTag);
        //a_array[key]
        } else {
            var aTag = createA(document.getElementById(elementid).options[i], i, "", "");
            //add
            var childid = getPostID("postChildID");
            $("#"+childid).append(aTag);
            applyEventsOnA();
        };
    };
    this.remove = function(i) {
        document.getElementById(elementid).remove(i);
        if((getByIndex(i))!= -1) {
            $("#"+getByIndex(i).id).remove();
            addRemoveFromIndex(i, 'd');
        };
        //alert("a" +a);
        if(document.getElementById(elementid).length==0) {
            setTitleText("");
        } else {
            var sText = getByIndex(document.getElementById(elementid).selectedIndex).html;
            setTitleText(sText);
        };
        $this.set("selectedIndex", document.getElementById(elementid).selectedIndex);
    };
    this.disabled = function(dis, isLocal) {
        document.getElementById(elementid).disabled = dis;
        //alert(document.getElementById(elementid).disabled);
        var id = getPostID("postID");
        if(dis==true) {
            $("#"+id).css("opacity", styles.disabled);
            $this.close();
        } else if(dis==false) {
            $("#"+id).css("opacity", 1);
        };
        if(isLocal!=true) {
            $this.set("disabled", dis);
        };
    };
    //return form element
    this.form = function() {
        return (document.getElementById(elementid).form == undefined) ? null : document.getElementById(elementid).form;
    };
    this.item = function() {
        //index, subindex - use arguments.length
        if(arguments.length==1) {
            return document.getElementById(elementid).item(arguments[0]);
        } else if(arguments.length==2) {
            return document.getElementById(elementid).item(arguments[0], arguments[1]);
        } else {
            throw {
                message:"An index is required!"
            };
        };
    };
    this.namedItem = function(nm) {
        return document.getElementById(elementid).namedItem(nm);
    };
    this.multiple = function(is) {
        if(is==undefined) {
            return $this.get("multiple");
        } else {
            $this.set("multiple", is);
        };

    };
    this.size = function(sz) {
        if(sz==undefined) {
            return $this.get("size");
        } else {
            $this.set("size", sz);
        };
    };
    this.addMyEvent = function(nm, fn) {
        $this.onActions[nm] = fn;
    };
    this.fireEvent = function(nm) {
        eval($this.onActions[nm])($this);
    };
    //end
    var updateCommonVars = function() {
        $this.set("version", $.msDropDown.version);
        $this.set("author", $.msDropDown.author);
    };
    var init = function() {
        //create wrapper
        createDropDown();
        //update propties
        //alert("init");
        setOriginalProperties();
        updateCommonVars();
        if(options.onInit!='') {
            eval(options.onInit)($this);
        };

    };
    init();
};
//static
$.msDropDown = {
    version: 2.3,
    author: "Marghoob Suleman",
    create: function(id, opt) {
        return $(id).msDropDown(opt).data("dd");
    }
};
$.fn.extend({
    msDropDown: function(options)
    {
        return this.each(function()
        {
            //if ($(this).data('dd')) return; // need to comment when using refresh method - will remove in next version
            var mydropdown = new dd(this, options);
            $(this).data('dd', mydropdown);
        });
    }
});

})(jQuery);