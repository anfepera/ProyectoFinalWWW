<?php

    class Alerta
    {
        var $id;
        var $descripcion;
        
        function __construct($descripcion) {
            $this->descripcion = $descripcion;
        }
        
        function getId()
        {
            return $this->id;
        }
        function setId($id)
        {
            $this->id = $id;
        }
        function getDescripcion()
        {
            return $this->descripcion;
        }
        function setDescripcion($descripcion)
        {
            $this->descripcion = $descripcion;
        }
        
    }
?>
