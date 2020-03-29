<?php
require("clases/db_abstract_model.php");
require("clases/usuarios_model.php");
require("clases/plantas_model.php");

if (isset($_POST['borrSI'])) {
    if(($_POST['tipo']) == "usuario"){
        $borrable = new Usuario();
    } else if(($_POST['tipo']) == "planta"){
        $borrable = new Planta();
    }
    $borrable->delete($_POST['id']);
    $error = $borrable->error;
    $msg = $borrable->msg;
    echo $borrable->error.$borrable->msg;
}