<?php

include('../Controladores/controladorCancion.php');
$cancionInerface = new cancionInerface();
$cancionInerface->realizarOperacion($_POST['opcion']);

class cancionInerface {

    var $titulo;
    var $interprete;
    var $genero;
    var $album;
    var $precio;
    var $url;
    var $usuario;

    function __construct() {
        
    }

    function realizarOperacion($opcion) {
        if ($opcion == 1) {
            session_start();
            $this->titulo = $_POST['titulo'];
            $this->interprete = $_POST['interprete'];
            $this->genero = $_POST['genero'];
            $this->album = $_POST['album'];
            $this->precio = $_POST['precio'];
            $this->url = $_POST['url'];
            $this->usuario = $_SESSION['login'];
        }
        $controlCancion = new ControladorCancion($this->titulo, $this->interprete, $this->genero, $this->album, $this->precio, $this->url, $this->usuario);
        if ($opcion == "descargar") {

            $controlCancion->descargarCancion($_POST['id_cancion'], $_POST['url_cancion']);
        }
        switch ($opcion) {
            case 1:
                $controlCancion->insertar();
                break;

            case 2:
                $controlCancion->consultar($_POST['id']);
                break;

            case 3:
                $controlCancion->listar();
                break;

            case 4://ojo:estaba en la opcion 5 en proyecto felipe
                $controlCancion->consultarCanciones($_POST['cancion']);
                break;

            case 5:
                $controlCancion->contar();
                break;

            case 6:
                $id_usr_rec = $_POST['id_usr_rec'];
                $id_cancion = $_POST['id_cancion'];
                $titulo = $_POST['titulo'];
                $controlCancion->compartir('', $id_usr_rec, $id_cancion, $titulo);
            break;
            case 7:
                $controlCancion->insertarCancionComprada($_POST['id']);
            break;
            case 8:
                $controlCancion->descargarCancion($_POST['id_cancion'], $_POST['url_cancion']);
            break;
            case 9:
                $controlCancion->recomendarCanciones();
            break;
            case 10:
                $controlCancion->cancionesCompradasPorUsuario($_POST['id']);
            break;
            case 11://ojo estaba en la opcion 6 felipe
                $controlCancion->modificarCancion($_POST['id']);
            break;
            case 12://ojo estaba en la opcion 6 felipe
                $controlCancion->listarCompartidas();
            break;
        }
    }

}

?>