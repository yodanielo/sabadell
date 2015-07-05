<?php
class Mautentication extends object{
    var $table;
    var $sessionName;
    var $userField;
    var $passwordField;
    function login($u,$p){
        unset($_SESSION[$this->sessionName]);
        $u=$this->variable($u);
        $p=$this->variable($p);
        $sql="select id,$this->userField as username, $this->passwordField as password  from $this->table where $this->userField='$u' and $this->passwordField=md5('$p')";
        $db=$this->dbInstance();
        $db->setQuery($sql);
        $res=$db->loadObjectList();
        $r=$res[0];
        if(count($res)==1){
            $_SESSION[$this->sessionName]["username"]=$r->username;
            $_SESSION[$this->sessionName]["password"]=$r->password;
            $_SESSION[$this->sessionName]["id"]=$r->id;
            return true;
        }else{
            return false;
        }
    }
    function isLogged(){
        if(isset ($_SESSION[$this->sessionName])){
            return true;
        }
        else
            return false;
    }
    
}
?>
