<?php

include('../Clases/Conexion.php');
include('../Clases/ListaReproduccion.php');

 $conect = new Conexion();
 $conect->conectar();
// $contListaReproduccion = new ControladorListaReproduccion('123', 'Otra mas', 'Mi ruta5');
// $contListaReproduccion->contarConacionesPorLista(123, 'Lista 1');
 
class ControladorListaReproduccion {

    var $listaReproduccionz;

    function __construct($id_coleccion, $nombre, $ruta_imagen)
    {
        $this->listaReproduccion = new ListaReproduccion($id_coleccion, $nombre, $ruta_imagen);
    }

    public function insertar() {
        $id_coleccion = $this->listaReproduccion->id_coleccion;
        $nombre = $this->listaReproduccion->nombre;
        $ruta_imagen = $this->listaReproduccion->ruta_imagen;

        $sentencia = "INSERT INTO  Lista_de_Reproduccion (id_coleccion, nombre, ruta_imagen) VALUES('$id_coleccion', '$nombre', '$ruta_imagen')";
        echo $sentencia;
        $execute = mysql_query($sentencia) or die('Error al crear la lista');

        if ($execute) {
            echo "La lista se creó correctamente";
        }
        header("Location: ../vistas/bienvenido.php");
    }

    public function consultar($id_coleccion, $nombre) {
        $sentencia = "SELECT * FROM Lista_de_Reproduccion WHERE id_coleccion='$id_coleccion' AND nombre='$nombre'";
        $consulta = mysql_query($sentencia) or die('Error al consultar');
        echo $sentencia;
        $datosLista = array();
        while ($fila = mysql_fetch_array($consulta))
        {
           $datosLista[0] = $fila['id_coleccion'];
           $datosLista[1] = $fila['nombre'];
           $datosLista[2] = $fila['ruta_imagen'];
        }
        echo json_encode($datosLista);
    }
    
    function modificar($id_coleccion, $nombre, $nombre_modif, $r_imag_modif)
    {
        $sentencia = "UPDATE Lista_de_Reproduccion SET nombre='$nombre_modif', ruta_imagen='$r_imag_modif' WHERE id_coleccion='$id_coleccion' AND nombre='$nombre'";
        $consulta = mysql_query($sentencia) or die ('No se pudo modificar');
        
    }
    
    
    function listar($id_coleccion)
    {
        $sentencia = "SELECT * FROM Lista_de_Reproduccion WHERE id_coleccion='$id_coleccion' order by nombre";
        $consulta = mysql_query($sentencia) or die('No se pudo generar la lista');
        $datosLista = array();
        $cont=0;
        while($fila=  mysql_fetch_array($consulta))
        {
            $datosLista[$cont][0] =$fila['id_coleccion'];
            $datosLista[$cont][1] =$fila['nombre'];
            $datosLista[$cont][2] =$fila['ruta_imagen'];
            $cont++;
        }
        echo json_encode($datosLista);
    }
    function agregarCancion($id_coleccion, $nombre_lista, $id_cancion, $titulo)
    {
      
        $sentencia = "INSERT INTO Canciones_por_Lista_Reprod (id_coleccion, nombre_lista, id_cancion) VALUES('$id_coleccion', '$nombre_lista', '$id_cancion')";
        echo $sentencia;
        $execute = mysql_query($sentencia) or die('Error al agregar la canción');

        if ($execute) {
            echo "La cancion se agregó correctamente";
            $mensaje = 'A '.$id_coleccion.' le gusta la cancion '.$titulo; 
            $filename = dirname(__FILE__) . '/alertas.txt';
            file_put_contents($filename, $mensaje);
            die();
        }        
    }
    
    function listarCancionesPorListaRep($id_coleccion)
    {
        $sentencia = "SELECT * FROM Canciones_por_Lista_Reprod WHERE id_coleccion='$id_coleccion' order by id_coleccion, nombre_lista, id_cancion";
        $consulta = mysql_query($sentencia) or die('No se pudo generar la lista');
        $datos_por_lista = array();
//        $todas_las_listas = array();
//        $listaActual="";
        $cont=0;
        while($fila=  mysql_fetch_array($consulta))
        {
            $datos_por_lista[$cont][0] =$fila['id_coleccion'];
            $datos_por_lista[$cont][1] =$fila['nombre_lista'];
            $datos_por_lista[$cont][2] =$fila['id_cancion'];
       
//            if($listaActual=="")
//            {
//                $listaActual=$fila['nombre_lista'];
//            }elseif (!($listaActual==$fila['nombre_lista']))
//            {
//                $todas_las_listas[] = $datos_por_lista;
//                $datos_por_lista = array();
//                $listaActual=="";
//            }
            
            $cont++;
        }
        echo json_encode($datos_por_lista);
    }
    
    function  contarConacionesPorLista($id_coleccion, $nombre_lista)
    {
        $sentencia = "SELECT count(*) FROM Canciones_por_Lista_Reprod WHERE id_coleccion='$id_coleccion' AND nombre_lista='$nombre_lista'";
        $consulta = mysql_query($sentencia) or die('No se pudo realizar la operacion');
        echo $sentencia;
        $cont=0;
        while($fila=  mysql_fetch_array($consulta))
        {
           $cont++;
        }
        echo $cont;
    }
    
    function eliminarCancionDeLista($login, $id_cancion, $nombre_lista)
  {
  if($nombre_lista!="todo")
  {
  $sentencia = "DELETE FROM Canciones_por_Lista_Reprod WHERE id_coleccion='$login' && nombre_lista='$nombre_lista' && id_cancion=$id_cancion";
  $consulta= mysql_query($sentencia) or die('No se pudo realizar la operacion');
  echo json_encode("Cancion eliminada correctamente");
   
  }
  else 
  echo json_encode("No se permite eliminar una cancion de la lista general");
   
// echo $sentencia;
   
  }
}

?>
