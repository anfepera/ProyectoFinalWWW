var $todasLasCanciones;
var $descargarCancion=false;
function leerMetadatos(file) {
    var datosCancion = [];
    function callback() {
        alert(file);
        var tags = ID3.getAllTags(file);
        if(ID3.getTag(file, "title")=='undefine' || ID3.getTag(file, "title")==null)
        {
            var fragmentos = file.split(".")
            datosCancion[0] = fragmentos[0];
        }else
        {
            datosCancion[0] = ID3.getTag(file, "title");
        }
        datosCancion[1] = ID3.getTag(file, "artist");
        datosCancion[2] = ID3.getTag(file, "genre");
        datosCancion[3] = ID3.getTag(file, "album");
    };
    ID3.loadTags(file, callback);
//    alert(datosCancion[0]+' '+ datosCancion[1]+' '+ datosCancion[2]+' '+ datosCancion[3]);	
//    
//    alert('Datos de la Canción: \n\n    Título: '+ datosCancion[1]+ '\n    Interprete: '+ datosCancion[1]+ '\n    Genero: '+ datosCancion[2]+ '\n    Album: '+ datosCancion[3]);
alert("Cancion subida correcrtamente","EXito");
    return datosCancion;
}

function insertarCancion(file, precio, url, usuario)
{
    var datos = leerMetadatos(file);
    var x;
    x=$(document);
    x.ready(enviar());
    function enviar()
    {
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"../Interfaces/cancionInterface.php",
            data:"opcion=1&titulo="+datos[0]+"&interprete="+datos[1]+"&genero="+datos[2]+"&album="+datos[3]+"&precio="+precio+"&url="+url+"&usuario="+usuario,
            beforeSend:inicioEnvio,
            success:llegada,
            timeout:1000,
            error:problemas
        }); 
        return false;
    }
    function inicioEnvio()
    {
        var x=$("#resultados");
        x.html('Cargando...');
    }
    function llegada(datos)
    {
//        alert(datos);
    }
    function problemas()
    {
        alert('problem');
    }
}

//A partir de aquí siguen las funciones relacionadas con la subida del archivos

function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      document.getElementById('f1_upload_form').style.visibility = 'hidden';
      return true;
}

function stopUpload(success, file, precio, url, usuario){
      var result = '';
      if (success == 1){
         result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
         insertarCancion(file, precio, url, usuario);
         cargar('Mi Coleccion');
         cargar('Mi Coleccion');
      }
      else 
      {
         result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
      }
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('f1_upload_form').innerHTML = result + '<label>File: <input name="myfile" type="file" size="30" /><\/label><label><input type="submit" name="submitBtn" class="sbtn" value="Upload" /><\/label>';
      document.getElementById('f1_upload_form').style.visibility = 'visible'; 
      return true;   
}

function consultarCancion(id_cancion)
{
    var datos_recib = [];
    var x;
    x=$(document);
    x.ready(enviar());
    function enviar()
    {
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"../Interfaces/cancionInterface.php",
            data:"opcion=2&id="+id_cancion,
            beforeSend:inicioEnvio,
            success:llegada,
            timeout:1000,
            error:problemas
        }); 
        return false;
    }
    function inicioEnvio()
    {
        var x=$("#resultados");
        x.html('Cargando...');
    }
    function llegada(datos)
    {
        datos_recib = eval(datos);
        lert(datos_recib[0]);
     }
    function problemas()
    {
        alert('problem');
    }
}

function listarCanciones()
{   
//    alert('entra a listarCanciones');
    var datos_recib = [];
    var x;
    x=$(document);
    x.ready(enviar);
    function enviar()
    {
//        alert('entra a enviar');
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"../Interfaces/cancionInterface.php",
            data:"opcion=3",
            beforeSend:inicioEnvio,
            success:llegada,
            timeout:1000,
            error:problemas
        }); 
        return false;
    }
    function inicioEnvio()
    {
        var x=$("#resultados");
        x.html('Cargando...');
      
    }
    function llegada(datos)
    {
        datos_recib = eval(datos);
//        alert(datos_recib);
    }
    function problemas()
    {
        alert('Problema al listar las canciones');
    }
    alert('Se ha cargado toda su colección');
//    alert(datos_recib);
//    alert(datos_recib);
    return datos_recib;
}

function compartirCancion(id_cancion, id_usr_rec, titulo)
{
    var x;
    x=$(document);
    x.ready(enviar());
    function enviar()
    {
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"../Interfaces/cancionInterface.php",
            data:"opcion=6&id_cancion="+id_cancion+"&id_usr_rec="+id_usr_rec+"&titulo="+titulo,
            beforeSend:inicioEnvio,
            success:llegada,
            timeout:1000,
            error:problemas
        }); 
        return false;
    }
    function inicioEnvio()
    {
        var x=$("#resultados");
        x.html('Cargando...');
    }
    function llegada(datos)
    {
//        alert(datos);
    }
    function problemas()
    {
        alert('problem');
    }
}


//felipe


function validarDescargaCancion(id_cancion,url_cancion,nombre_cancion)
{
    
    descargarCancion(id_cancion);
    if($descargarCancion)
    {
        var cadena="";
        cadena+="<h3 style=\"color:black;\" >¿Deseas descargar la cancion <span style=\"color:blue;\">"+ nombre_cancion+"</span>?</h3>";
        cadena+="<form action=\"../Interfaces/cancionInterface.php\" method=\"POST\">";
         
        cadena+="<input id=\"id_cancion\"  value=\""+id_cancion+"\" name=\"id_cancion\" type=\"hidden\" />"
        cadena+="<input id=\"url_cancion\" value=\""+url_cancion+"\" name=\"url_cancion\" type=\"hidden\" />"
        cadena+="<input id=\"botonDescargar\" title=\"clic aqui para descargar la cacnion\" style=\"background:green; margin-left:20%;width: 40%;height:105%; display:none;\" type=\"submit\" value=\"descargar\"  name=\"opcion\"/>"
        
        cadena+="</form>";
        document.getElementById("descargarCancion").innerHTML=cadena;
         
        jConfirm(cadena, 'Descargar cancion', function(r) {
            if(r)
            {
                document.getElementById('botonDescargar').click()
               
               
            }
            else{
               

            }

        });
    //   
            
            
    }

   
        
    
    
}

function descargarCancion(id_cancion)
{ 
    
    
  
    var x;
    x=$(document);
    x.ready(enviar);

			
    function enviar()
    {
        
        //       jAlert(nombreCancion);
        $.ajax({
            async:false,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"../Interfaces/cancionInterface.php",
            data:"opcion=10&id="+id_cancion,
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
        var datosJson= eval(datos);
        if(datosJson=='ok')
        {
//            jAlert('se puede descargar la cancion '+datos);	 
            $descargarCancion=true;
                
        }
        else if(datosJson=='error')
        {
            $descargarCancion=false;
            jAlert('Para poder descargar esta cacnion debes comprarla','Advertencia');	 
                
        }
        else{
            $descargarCancion=false;
                
            jAlert('error desconocido '+datos);	 
        }
    //        jAlert('Llegaron los datos ?????'+datos);	
    }
					
					
    function problemas()
    {
        jAlert('problem');
       
    }
}

function listarCompartidas()
{   
//    alert('entra a listarCompartidas');
    var datos_recib = [];
    var x;
    x=$(document);
    x.ready(enviar);
    function enviar()
    {
//        alert('entra a enviar');
        $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:"../Interfaces/cancionInterface.php",
            data:"opcion=12",
            beforeSend:inicioEnvio,
            success:llegada,
            timeout:1000,
            error:problemas
        }); 
        return false;
    }
    function inicioEnvio()
    {
        var x=$("#resultados");
        x.html('Cargando...');
      
    }
    function llegada(datos)
    {
        datos_recib = eval(datos);
//        alert(datos_recib);
    }
    function problemas()
    {
        alert('Problema al listar las canciones');
    }
    alert('Se han cargado sus canciones compartidas');
    return datos_recib;
}

function eliminarCancionDelista(album_id,identificador)
{
  var x;
  x=$(document);
  x.ready(enviar);

 	  
  function enviar()
  {
   
  // jAlert(nombreCancion);
  $.ajax({
  async:false,
  type: "POST",
  dataType: "html",
  contentType: "application/x-www-form-urlencoded",
  url:"../Interfaces/listaReproduccionInterface.php",
  data:"opcion=7&id="+identificador+"&nombre_lista="+album_id,
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
  var respuesta=eval(datos);
  if(respuesta=='Cancion eliminada correctamente')
  {
   
  alert(datos);
  cargar(album_id);
  }
  else{
   
  alert(datos,'Respuesta');
  }
   
   
   
  // jAlert('Llegaron los datos ?????'+datos); 
  }
 	  
 	  
  function problemas()
  {
  jAlert('problem');
   
  }   
   
}

function informacionMetadatos()
{
    mostrarElemento('subirCancion');
    cadena="<h4 style=\"font-size:17px;\">Al subir una cancion, se obtiene de esta los metadatos(titulo, artista,album ,etc) por lo tanto es recomendable que las canciones que subas contengan estos datos, de lo contrario se insertara en la base de datos \'undefined\' , ";
    cadena+="recomendamos agregar metadatos a las canciones, pueden usar este  <a style=\"color: #2972d5\" href=\"http://www.xdlab.ru/en/\" TARGET=\"_blank\">programa (windows)</a> ; se debe usar el navegador Mozilla Firefox <img src= \"images/mozilla.png \" width=\"20\" height=\"20 \"> para poder subir canciones y se deben aceptar todos los alert.<br><br>"
    cadena+="Los formatos que puede reproducir este navegador es <span style=\"color: blue;\">.ogg </span>, entonces se debe realizar la conversion de archivos al formato antes mencionado, puede usar  <a style=\"color: #2972d5\" href=\"http://video.online-convert.com/convert-to-ogg\" TARGET=\"_blank\">siguiente pagina</a>.<br><br> para realizar la conversion. Disculpen las molestias ocasionadas.</h4>"
    
    jAlert(cadena,'Sugerencia Administrador Univalle Music');
}
