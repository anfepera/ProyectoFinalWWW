/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var $cantidadCanciones=2;
var $enviarReporte=false;

function comboReporte(opcion)
{
 
    var idx = opcion.selectedIndex;
    var content = opcion.options[idx].innerHTML;
 
    if(content=='elige')
    {
         
//        alert('Debes elegir un valor');
    }
    else
    {
        $cantidadCanciones=parseInt(content)
        if(isNaN($cantidadCanciones))
        {
            if(content=='todas')
            {
//                jAlert('todas las canciones');
                $enviarReporte=true;
                        
                $cantidadCanciones=content;  
            }
            else
            {
//                alert('debes elegir una opcion valida ' +$cantidadCanciones);  
                $enviarReporte=false;
            }
              
        }
       
        else
        {
//            alert('muy bien :) ' +$cantidadCanciones); 
           
            $enviarReporte=true;
        }
        
     
       
              
    }
  
}

function validar()
{
    document.getElementById("variable").value=$cantidadCanciones;
     if($enviarReporte)
         {
             return true;
             

         }
         else{
             return false;
             
             jAlert('no puedes enviar el reporte', 'advertencia')
         }
    
    
}



function obtenerReporte()
{
    
        var x;
        x=$(document);
        x.ready(enviar);

			
        function enviar()
        {
           
        
           
            $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url:"../Interfaces/reportesInterface.php",
                data:"opcion=1&cantidad="+$cantidadCanciones,
                //            data:"opcion=6",
                beforeSend:inicioEnvio,
                success:llegada,
                              
                timeout:4000,
                error:problemas
            }); 
            return false;
        }
        function inicioEnvio()
        {
            jAlert('iniciando envio', 'advertencia');
            
  
        }
        function llegada(datos)
        {
            jAlert('Llegaron los datos'+datos);	
        }
					
					
        function problemas()
        {
            jAlert('problem');
       
        }
    
    
    
    
    
}