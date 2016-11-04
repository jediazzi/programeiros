<?php

function loggedIn(){
    if(isset($_SESSION['usuario']) || isset($_COOKIE['usuario'])){
        return true;
    }else return false;
}

?>