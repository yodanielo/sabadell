<?php
    class Cidioma extends application{
        function index($id){
            if($id=="esp" || $id="cat"){
                $_SESSION["lang"]=$id;
            }
                $this->redirect("");
        }
    }
?>