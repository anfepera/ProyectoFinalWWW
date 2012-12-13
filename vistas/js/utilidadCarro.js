/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function obtenerCanciones()
{   
  
    var x;
    x=$(document);
    x.ready(enviar);

			
    function enviar()
    {
        var nombreCancion=$("#searchSong").attr("value");
        //       jAlert(nombreCancion);
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"../Interfaces/cancionInterface.php",
            data:"opcion=4&cancion="+nombreCancion,
            beforeSend:inicioEnvio,
            success:llegada,
                              
            timeout:4000,
            error:problemas
        }); 
        return false;
    }
    function inicioEnvio()
    {
    //        //        alert('---- enviando  ---');
    //        var x=$("#resultados");
    //        x.html('Cargando...');
    }
    function llegada(datos)
    {
       
        //         $("#principal").css("display", "none");
        //     alert('llegaron los datos');
        // jAlert(datos);
        //        mostrarElemento('content');
        var  cadena="<h2>Resultado Busqueda</h2>";
						
        var dataJson = eval(datos);
        
       
        
        
        for(var i in dataJson)
        {
            cadena+=" <div class=\"alsoContainer\">"
            cadena+=" <div class=\"alsoInfo\">"
            cadena+=dataJson[i][1]+"<br>";
            cadena+="<input type=\"button\" value=\"Agregar al carrito\" onclick=\"simpleCart.add('name="+dataJson[i][1]+"','price="+dataJson[i][7]+"','identificador="+dataJson[i][0]+"','Ruta="+dataJson[i][8]+"');return false;\">";
            cadena+=" <input type=\"button\" value=\"Reproducir\" onclick=\"reproducirCancion('"+dataJson[i][8]+"','"+dataJson[i][0]+"','"+dataJson[i][5]+"')\"/>"; 
//            cadena+="<input  type=\"button\" value=\"Agregar a mi Coleccion\" style=\"background-image: url('../images/reproductor/addSong.png')\"/>" 

            cadena+="</div>";
            cadena+=" <div class=\"alsoPrice\">"+dataJson[i][7]+"</div></div>";

    
        }
    
   
        document.getElementById("sidebar").innerHTML=cadena;      
						
    }
					
					
    function problemas()
    {
        jAlert('problem');
       
    }
}



function reproducirCancion(ruta,id,numReproducciones)
{
    //    jAlert(ruta+id+numReproducciones);
//    numReproducciones++;
    aumentarNumeroReproducciones(id);
   
    cadena="<audio src=\""+ruta+"\" controls=\"controls\" autoplay>";
    cadena+="</audio>";
                 
    document.getElementById("audio").innerHTML=cadena;  
}


function pagarCanciones()
{
    
    var cadena="";
    cadena += "<div id=\"titulo\" >Realizar Pagos</div>";
    cadena += "<span id=\"contenidoVentanaModal\">";
    cadena += "El total de tu compra fue de  <span style=\"font-size:17px; color: green; font-weight:bold;\">"+$valorAcumulado + "</span> :<br><br>"
    cadena += "Debes digitar el numero de tarjeta: <input type=\"input\" value=\"\"/>"; 
    cadena +="<select name=\"thelist \" style=\"width: 90%; margin-left: 1%;\" onChange=\"combo(this)\">";
    cadena +="<option>Elige una opcion</opcion>";
    cadena +="<option>Visa</option>"
    cadena +="<option>Masterd Card</option>"
    cadena +="<option>V</option>"
            
    cadena +="</select></span>" 
  
            
  
        
                cadena +=  "<div id=\"botonesModal\">";
                cadena +=  "<input id=\"btnAceptar\" onclick=\"jAlert('Su compra fue exitosa','Felicidades');\" name=\"btnAceptar\" size=\"20\" type=\"button\" value=\"Aceptar\" /> <input id=\"btnCancelar\" onclick=\"ocultarVentana();\" name=\"btnAceptar\" size=\"20\" type=\"button\" value=\"Cancelar\" /></div>";
//    jAlert(cadena,"pagos UNivalle Music");
            document.getElementById("miVentana").innerHTML=cadena;  
            mostrarVentana();
}



function aumentarNumeroReproducciones(id_cancion)
{   
  
    var x;
    x=$(document);
    x.ready(enviar);

			
    function enviar()
    {
        
        //       jAlert(nombreCancion);
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"../Interfaces/cancionInterface.php",
            data:"opcion=11&id="+id_cancion,
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
    //        //        alert('---- enviando  ---');
    //        var x=$("#resultados");
    //        x.html('Cargando...');
    }
    function llegada(datos)
    {
//        jAlert("Llegaron bien"+datos);		
    }
					
					
    function problemas()
    {
        jAlert('problem');
       
    }
}


function registrarCancionesCompradas(id_cancion)
{   
  
    var x;
    x=$(document);
    x.ready(enviar);

			
    function enviar()
    {
        
        //       jAlert(nombreCancion);
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"../Interfaces/cancionInterface.php",
            data:"opcion=7&id="+id_cancion,
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
  
    }
    function llegada(datos)
    {
//        jAlert('Llegaron los datos'+datos);	
    }
					
					
    function problemas()
    {
        jAlert('problem');
       
    }
}




