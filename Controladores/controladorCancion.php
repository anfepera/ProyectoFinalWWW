<?php

include_once('../Clases/Conexion.php');
include('../Clases/Cancion.php');
$conexionBD = new Conexion();
$conexionBD->conectar();

//        $contCan = new controladorCancion(123, '', '$genero', '$album', '$precio', '$url', '$usuario');
//        $contCan->contar();
class controladorCancion {

    var $cancion;

    function __construct($titulo, $interprete, $genero, $album, $precio, $url, $usuario) {
        $this->cancion = new Cancion($titulo, $interprete, $genero, $album, $precio, $url, $usuario);
    }

    function insertar() {
        $titulo = mysql_real_escape_string($this->cancion->titulo);
        $interprete = mysql_real_escape_string($this->cancion->interprete);
        $genero = mysql_real_escape_string($this->cancion->genero);
        $album = mysql_real_escape_string($this->cancion->album);
        $precio = $this->cancion->precio;
        $url = mysql_real_escape_string($this->cancion->url);
        $usuario = mysql_real_escape_string($this->cancion->usuario);
        $sentencia = "INSERT INTO Cancion(titulo, interprete, genero, album, precio, url, login_usuario) 
									VALUES('$titulo', '$interprete', '$genero', '$album', $precio, '$url', '$usuario')";
        // echo $sentencia;
        $consulta = mysql_query($sentencia) or die("Error al insertar");

        $id_cancion = $this->contar();
        //**********Cambio tilde
        $sentencia3 = "INSERT INTO Canciones_por_Lista_Reprod(id_coleccion, nombre_lista, id_cancion) VALUES('$usuario', 'Mi Coleccion', $id_cancion)";
        $consulta3 = mysql_query($sentencia3);
//                        echo $sentencia3;
        $mensaje = mysql_real_escape_string('Se ha insertado la canción ' . $titulo . '<br> Puedes verla en la biblioteca');
        if ($consulta3) {
            $filename = dirname(__FILE__) . '/alertas.txt';
            if ($mensaje != '') {
                file_put_contents($filename, $mensaje);
                die();
            }
        }else
            echo "Error al subir la canción";
    }

    function consultar($id_cancion) {
        $datosCancion = array();
        $consulta = mysql_query("SELECT * FROM Cancion WHERE id=$id_cancion") or die('Error de la aplicacion');
        while ($fila = mysql_fetch_array($consulta)) {
            $datosCancion[0] = $fila['id'];
            $datosCancion[1] = $fila['titulo'];
            $datosCancion[2] = $fila['interprete'];
            $datosCancion[3] = $fila['genero'];
            $datosCancion[4] = $fila['album'];
            $datosCancion[5] = $fila['no_reproducciones'];
            $datosCancion[6] = $fila['no_compras'];
            $datosCancion[7] = $fila['precio'];
            $datosCancion[8] = $fila['url'];
            $datosCancion[9] = $fila['login_usuario'];
        }
        echo json_encode($datosCancion);
    }

    function actualizar() {
        
    }

    function eliminar() {
        
    }

    function listar() {
//                    echo 'entre a listar';

        $datosCancion = array();
        $consulta = mysql_query("SELECT * FROM Cancion") or die('Error de la aplicacion');
        $cont = 0;
        while ($fila = mysql_fetch_array($consulta)) {
//                       $datosCancion[] =$fila['id'];
//                        $datosCancion[] = $fila['titulo'];
//			$datosCancion[] = $fila['interprete'];
//                        $datosCancion[$cont][3] = $fila['genero'];
//			$datosCancion[] = $fila['album'];
//			$datosCancion[] = $fila['no_reproducciones'];
//			$datosCancion[] = $fila['no_compras'];
//			$datosCancion[] = $fila['precio'];
//                        $datosCancion[] = $fila['url'];
//                        $datosCancion[] = $fila['login_usuario'];

            $datosCancion[$cont][0] = $fila['id'];
            $datosCancion[$cont][1] = $fila['titulo'];
            $datosCancion[$cont][2] = $fila['interprete'];
            $datosCancion[$cont][3] = $fila['genero'];
            $datosCancion[$cont][4] = $fila['album'];
            $datosCancion[$cont][5] = $fila['no_reproducciones'];
            $datosCancion[$cont][6] = $fila['no_compras'];
            $datosCancion[$cont][7] = $fila['precio'];
            $datosCancion[$cont][8] = $fila['url'];
            $datosCancion[$cont][9] = $fila['login_usuario'];
            $cont++;
        }
        echo json_encode($datosCancion);
    }

    function contar() {
        $consulta = mysql_query("SELECT * FROM Cancion") or die('Error de la aplicacion');

        while ($fila = mysql_fetch_array($consulta)) {
            $id = $fila['id'];
        }
        return $id;  // imprimos en pantalla el número generado
    }

    function consultarCanciones($cadena) {
        $datosCancion = array();
        $consulta = mysql_query("SELECT * FROM Cancion where titulo  LIKE '$cadena%'");
        $cont = 0;
        while ($fila = mysql_fetch_array($consulta)) {


            $datosCancion[$cont][0] = $fila['id'];
            $datosCancion[$cont][1] = $fila['titulo'];
            $datosCancion[$cont][2] = $fila['interprete'];
            $datosCancion[$cont][3] = $fila['genero'];
            $datosCancion[$cont][4] = $fila['album'];
            $datosCancion[$cont][5] = $fila['no_reproducciones'];
            $datosCancion[$cont][6] = $fila['no_compras'];
            $datosCancion[$cont][7] = $fila['precio'];
            $datosCancion[$cont][8] = $fila['url'];
            $datosCancion[$cont][9] = $fila['login_usuario'];
            $cont++;
        }
        echo json_encode($datosCancion);
    }

    function compartir($id_usr_env, $id_cancion, $id_usr_rec, $titulo)
 {
        session_start();
        $id_usr_env = mysql_real_escape_string($_SESSION['login']);

        $sentencia = "INSERT INTO Canciones_compartidas(login_usuario_envia, id_cancion, login_usuario_recibe) VALUES('$id_usr_env', $id_cancion, $id_usr_rec)";
//                    echo $sentencia;
        $consulta = mysql_query($sentencia) or die('No se pudo compartir la cancion');
        if ($consulta) {
            $mensaje = $id_usr_env . ' ha compartido la canción ' . $titulo . ' con ' . $id_usr_rec;
            $filename = dirname(__FILE__) . '/alertas.txt';
            if ($mensaje != '') {
                file_put_contents($filename, $mensaje);
                die();
            }
            echo 'el usuario: ' . $id_usr_rec . ' ahora puede reproducir tu canción';
        }
    }
    
    function modificarCancion($identificador) {

        $consulta = "UPDATE Cancion SET no_reproducciones=no_reproducciones +1 WHERE id=$identificador ";
        $resultado = mysql_query($consulta);
        
    }
    
      function insertarCancionComprada($identificador) {
        session_start();
        $usuario = $_SESSION['login'];
        $consulta = "INSERT INTO Canciones_compradas(login_usuario, id_cancion) VALUES('$usuario', '$identificador')";
         $consulta2 = "UPDATE Cancion SET no_compras=no_compras +1 WHERE id=$identificador ";
        echo $consulta;
        echo $consulta2;
        $resultado = mysql_query($consulta);
        $resultado2 = mysql_query($consulta2);
    }
    
     function cancionesCompradasPorUsuario($id) {
        session_start();
        $respuesta="error";
        $usuario = $_SESSION['login'];
        $sentencia = "SELECT * FROM Canciones_compradas WHERE login_usuario='$usuario' && id_cancion ='$id'";
//        echo $sentencia;
        $execute = mysql_query($sentencia);
        $filas = mysql_num_rows($execute);
        if ($filas > 0) {
           $respuesta="ok";
           echo json_encode($respuesta);
            return true;
            
        }
        else
        {
             
           echo json_encode($respuesta);
            return false;
        }
        
    }
    
      function descargarCancion($id, $url) 
    {
        
        if ($this->cancionesCompradasPorUsuario($id)) 
            {
             echo'el usuario puede descargar la cacnion';
            $file = '../vistas/' . $url;

            if (file_exists($file)) {
                echo'el archvo '.$file .' existe';
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($file));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
//                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
                exit;
            } 
            else 
                {
                    echo 'archivo no existe';
                }
           
        } 
        else 
            {

            echo 'No puedes descargar esta cancion, debes comprarla';
        }
    }
    
    function listarCompartidas()
    {
        $canciones_comp = array();
        $consulta = mysql_query('SELECT * FROM Canciones_compartidas');
        while($fila = mysql_fetch_array($consulta))
        {
            $canciones_comp[] =$fila['login_usuario_envia'];
            $canciones_comp[] =$fila['id_cancion'];
            $canciones_comp[] =$fila['login_usuario_recibe'];
        }
        echo json_encode($canciones_comp);
    }
    
    

}

?>