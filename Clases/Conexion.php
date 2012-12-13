<?php

class Conexion {

    var $usuario;
    var $password;

    function conectar() {

        $usuario = 'anfepera';
        $password = 'anfepera';
        $servidor = 'mysql';
        $base_datos = 'anfepera';
        $conectarse = mysql_connect($servidor, $usuario, $password) or die("No se puede conectar con servidor");
        if ($conectarse) {
//          echo 'Servidor encontardo<br>';
        }
        $accederBD = mysql_select_db($base_datos, $conectarse) or die("No se puede conectar con la base de datos");
        if ($accederBD) {
//          echo 'Acceso a BD exitoso';
        }
    }

}

?>
