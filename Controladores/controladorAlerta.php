<?php
    include_once('../Clases/Conexion.php');	
    include('../Clases/Alerta.php');
    $conect = new Conexion();
    $conect->conectar();
//    $contAlert = new ControladorAlerta('Mi primer alerta');
//    $contAlert->insertar();
    
    class ControladorAlerta{
        
        var $alerta;
        var $peticion_inicial=true;

        function __construct($descripcion)
        {
            $this->alerta = new Alerta($descripcion);
        }

        public function insertar()
        {
            $descripcion = $this->alerta->descripcion;
            $sentencia = "INSERT INTO  Alerta(descripcion) VALUES('$descripcion')";
            echo $sentencia;
            $execute = mysql_query($sentencia) or die('Error al crear la lista');
            if($execute)
            {
                $filename  = dirname(__FILE__).'/alertas.txt';
                if ($descripcion != '')
                {
                    file_put_contents($filename, $descripcion);
                    die();
                }
            }
        }
        
        public function consultar($id)
        {
            $sentencia = "SELECT * FROM Alerta WHERE id='$id'";
            $consulta = mysql_query($sentencia) or die('Error al consultar');
            echo $sentencia;
            $datosLista = array();
            while ($fila = mysql_fetch_array($consulta))
            {
                $datosLista[0] = $fila['id'];
                $datosLista[1] = $fila['descripcion'];
            }
            echo json_encode($datosLista);
        }
    
        function modificar($id, $desccrip_modif)
        {
            $sentencia = "UPDATE Alerta SET descripcion='$desccrip_modif' WHERE id='$id'";
            $consulta = mysql_query($sentencia) or die ('No se pudo modificar');

        }
        
        function listar()
        {
            $sentencia = "SELECT * FROM Alerta";
            $consulta = mysql_query($sentencia) or die('No se pudo generar la lista');
            $datosLista = array();
            $cont=0;
            while($fila=  mysql_fetch_array($consulta))
            {
                $datosLista[$cont][0] =$fila['id'];
                $datosLista[$cont][1] =$fila['descripcion'];
                $cont++;
            }
            echo json_encode($datosLista);
        }
        
    }
?>
