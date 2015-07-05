$.fn.formValidator=function(alterminar,options){
    df={
        "required"      :"required",//obligatorio
        "email"         :"email",//email
        "alpha"         :"alpha",//letras normlaes
        "uppercase"     :"mayusculas",//letras normlaes
        "lowercase"     :"minusculas",//letras normlaes
        "special"       :"especial",//caracteres especiales
        //"numero"       :"number",//numeros
        "decimal"       :"decimal",//decimales
        "entero"        :"integer",//entero
        "thousand"      :"thousand",//miles
        "eol"           :"<br/>",//eol de linea
        "msgrequired"   :"El campo {campo} es requerido",
        "msginvalid"    :"El campo {campo} no es válido",
        "sepdecimal"    :".",
        "sepmiles"      :",",
        "fieldname"     :"rel"
    };
    df=$.extend(df,options);
    eol=df["eol"];
    isempty=function(ctl){
        if(ctl.split(" ").join("")=="")
            return true;
        else
            return false;
    }
    checknumber=function(a){
        cumple=true;
        s=$(a).val();
        for (i = 0; i < s.length; i++){
            c = s.charAt(i);
            if(!(parseInt(c) >= 0 && parseInt(c) <= 9) && c!=df["sepdecimal"] && c!=df["sepmiles"]){
                cumple=false;
            }
        }
        if(cumple){
            //checo formatos
            t=s.split(df["sepdecimal"]);
            m=s.split(df["sepmiles"]);
            if(t.length>2){
                if(t[1].indexOf(df["sepmiles"]));
                cumple=false;
            }
            else{
                if($(a).hasClass(df["entero"]) && t.length!=1){
                    cumple=false;
                }
                if($(a).hasClass(df["thousand"])){
                    cumple=true;
                    for(i=0;i<m.length;i++){
                        gm=m[i];
                        if(gm.length!=3 && i>1){
                            cumple=false;
                        }
                    }
                }
            }
        }else
            cumple=false;
        return cumple;
    }
    addcadena=function(c,d,h){
        for(i=d;i<=h;i++){
            c=c.concat(String.fromCharCode(i));
        }
        return c;
    }
    jQuery(this).submit(function(){
        mensaje="";
        $(this).find("*").each(function(){
            conformato=false;
            cars=new Array();
            formato=true;
            s=jQuery(this).val();
            //requeridos
            if($(this).hasClass(df["required"])){
                if(isempty(s)){
                    mensaje+=df["msgrequired"].split("{campo}").join($(this).attr(df["fieldname"]))+df["eol"]
                }
            }
            
            //numeros
            if($(this).hasClass(df["entero"]) || $(this).hasClass(df["thousand"]) || $(this).hasClass(df["decimal"])){
                if(checknumber(this)==true){
                    cars=addcadena(cars,48, 57);
                    if($(this).hasClass(df["thousand"]))
                        cars=addcadena(cars,String.charCodeAt(df["sepmiles"]), String.charCodeAt(df["sepmiles"]));
                    if($(this).hasClass(df["decimal"]))
                        cars=addcadena(cars,String.charCodeAt(df["sepdecimal"]), String.charCodeAt(df["sepdecimal"]));
                }else
                    formato=false;
            }
            //email
            if(jQuery(this).hasClass(df["email"])){
                r=jQuery(this).val();
                arroba=r.indexOf("@");
                punto=r.indexOf(".");
                len=r.length;
                if(!isempty(r))
                    if(len<=2 || arroba>punto || arroba==-1 || punto==-1 || arroba==punto-1 || punto>=len-1){
                        formato=false;
                    }
                /*if(formato==true){
                    cars=addcadena(cars,33,64);
                    cars=addcadena(cars,91,96);
                    cars=addcadena(cars,123,256);
                }*/
            }
            //cadenas
            if($(this).hasClass(df["alpha"])){
                cars=addcadena(cars,65,90);//may
                cars=addcadena(cars,97,122);//min
            }else{
                if($(this).hasClass(df["lowercase"]))
                    cars=addcadena(cars,97,122);
                if($(this).hasClass(df["uppercase"]))
                    cars=addcadena(cars,65,90);
            }
            if($(this).hasClass(df["special"])){
                cars=addcadena(cars,33,64);
                cars=addcadena(cars,91,96);
                cars=addcadena(cars,123,256);
            }
            if(formato && cars.length>0){
                for(i=0;i<s.length;i++){
                    x=s.toString().charAt(i);
                    xyz=false;
                    for(j=0;j<cars.length;j++){
                        if(cars[j]==x)
                            xyz=true;
                    }
                    if(xyz==false){
                        mensaje+=df["msginvalid"].split("{campo}").join($(this).attr(df["fieldname"]))+df["eol"];
                        break;
                    }
                }
            }else{
                if(!formato)
                    mensaje+=df["msginvalid"].split("{campo}").join($(this).attr(df["fieldname"]))+df["eol"];
            }
        });
        if(mensaje.split(" ").join("").split("\n").join("")==""){
            //mision cumplida
            return alterminar("");
        }else{
            //mision fallida
            alterminar(mensaje);
            return false;
        }
    });
};