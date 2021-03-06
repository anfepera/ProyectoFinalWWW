<?php

include('../Clases/Usuario.php');
include('../Controladores/controladorListaReproduccion.php');
//$conus = new controladorUsuario(222, 'pass','nombre', 'ape', 'w@gmail', '2012-11-28 18:05:15.000');
//$conus->listar();

class controladorUsuario {

    var $usuario;

    function __construct($login, $password, $nombres, $apellidos, $correo, $fecha_reg) {
        $this->usuario = new Usuario($login, $password, $nombres, $apellidos, $correo, $fecha_reg);
    }

    public function Insertar() {
        $respuesta = "Error al Insertar";
        $login = $this->usuario->login;
        $password = $this->usuario->password;
        $nombres = $this->usuario->nombres;
        $apellidos = $this->usuario->apellidos;
        
        $correo = $this->usuario->correo;
        $fecha_reg = $this->usuario->fecha_reg;
        $sentencia = "INSERT INTO  Usuario (login,password,nombres,apellidos,correo) VALUES('$login', '$password', '$nombres', '$apellidos','$correo')";
        //$conexionBD = new Conexion();
        //$conexionBD->conectar();

//        echo $sentencia;
        $execute = mysql_query($sentencia);
        $sentencia2 = "INSERT INTO Coleccion (login_usuario) VALUES('$login')";
        echo $sentencia2;
        $execute2 = mysql_query($sentencia2);

        if ($execute && mysql_affected_rows() == 1) {
            session_start();
            $_SESSION["login"] = $login;
            $_SESSION["nombres"] = $nombres;
            $_SESSION["password"] = $password;
            $_SESSION["apellidos"] = $apellidos;
           
            $_SESSION["correo"] = $correo;
            $_SESSION["fecha_reg"] = $fecha_reg;

            $contLisRep = new ControladorListaReproduccion($login, 'Mi Coleccion', 'images/reproductor/library2.jpg');
            $contLisRep->insertar();
//            $contLisRep=null;
            
            //********Cambios
            $contLisRep = new ControladorListaReproduccion($login, 'Mis Favoritas', 'images/listasReproduccion/13.jpg');
            $contLisRep->insertar();
            //***Fim cambios
            $respuesta = "Registro exitoso";
            echo $respuesta;

            $_SESSION['autentificado'] = "1";
            header("Location: ../vistas/bienvenido.php");
//          
//          //Borrar el contenido del archivo de alertas
            $filename = dirname(__FILE__) . '/alertas.txt';
            file_put_contents($filename, $mensaje);
            die();

        } else {


            header("Location: ../index.php");
        }
    }

    public function Validar($login, $password) {
        $conexionBD = new Conexion();
        $conexionBD->conectar();
        $sentencia = "SELECT * FROM Usuario WHERE login='$login' && password ='$password'";
        $execute = mysql_query($sentencia);
        $filas = mysql_num_rows($execute);
        if ($filas == 1) {
            session_start();
            while ($row = mysql_fetch_array($execute)) {
                $_SESSION['autentificado'] = "1";
                $_SESSION["login"] = $row["login"];
                $_SESSION["nombres"] = $row ["nombres"];
                $_SESSION["apellidos"] = $row ["apellidos"];
                $_SESSION["correo"] = $row ["correo"];
                
                $_SESSION["fecha_reg"] = $row ["fecha_reg"];
            }
              if($login=='administrador' && $password=='administrador')
            {
                 header("Location: ../vistas/admin.php");
                
            }
             else
                 {
                //Borrar el contenido del archivo de alertas
                header("Location: ../vistas/bienvenido.php");
                $filename = dirname(__FILE__) . '/alertas.txt';
                file_put_contents($filename, '');
                die();
            }
           
        } else {

            header("Location: ../error.php");
        }
    }

    public function Consultar($login) {
        $conexionBD = new Conexion();
        $conexionBD->conectar();
        $sentencia = "SELECT * FROM Usuario WHERE login='$login'";
        $execute = mysql_query($sentencia);
        $filas = mysql_num_rows($execute);
//        session_start();
        if ($filas == 1) {
            
            
            echo "Login ya existe";
//            $_SESSION['respuesta'] = "Login ya existe";
        }
        else
        {
            echo "Login Disponible";
//           $_SESSION['respuesta'] = "Login Disponible"; 
            
        }
    }

    public function PasarDatos() {
        $_SESSION["login"] = $login;
        $_SESSION["nombres"] = $nombres;
        $_SESSION["password"] = $password;
        $_SESSION["apellidos"] = $apellidos;
        
        $_SESSION["correo"] = $correo;
        $_SESSION["fecha_reg"] = $fecha_reg;
    }
    
     public function listar()
    {
        $conexionBD = new Conexion();
        $conexionBD->conectar();
        $consulta = mysql_query('SELECT * FROM Usuario')or die ('Error de la aplicacion');
        $listaUsuarios = array();
        while ($fila = mysql_fetch_array($consulta)) {
            $listaUsuarios[] = $fila['login'];
        }
        echo json_encode($listaUsuarios);
    }

}

?>
