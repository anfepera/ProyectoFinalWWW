<?php
    
    include('../Controladores/controladorAlerta.php');
        $contAlert = new alertaInterface();
        $contAlert->realizarOperacion($_POST['opcion']);
        
        class alertaInterface
        {
            var $id;
            var $descripcion;
            
            function  __construct()
            {
            }
                
            function realizarOperacion($opcion)
            {
                session_start();
                if($opcion==1){
                    $this->descripcion = $_POST['descripcion'];
                }
                 $contAlerta = new ControladorAlerta($this->descripcion);
          
                 switch($opcion){
                    case 1: 
                        $contAlerta ->insertar();
                    break;		
                    
                    case 2:
                        $contAlerta->consultar($_POST['id']);
                    break;

                    case 3:
                        $contAlerta->listar($_POST['id']);
                    break;

                    case 4:
                        $contAlerta->modificar($_POST['id'], $_POST['descrip_modif']);
                    break;
                }
             }
    }

?>
