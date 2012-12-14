<?
include ('../Interfaces/seguridad.php');
?>
<!DOCTYPE HTML>

<html>
    <head>
        <?php
        header("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
        header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
        header("Pragma: no-cache");
        ?>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Sitio Web Univalle Music</title>
<!--        <link rel="stylesheet" type="text/css" href="http://blogdisemucho.blogcindario.com/ficheros/buttons.css" />-->

        <script type="text/javascript" src="js/utilidadCancion.js"></script>
        <script type="text/javascript" src="js/utilidadAlerta.js"></script>
        <script type="text/javascript" src="js/utilidadListReproducion.js"></script>
        <script src="js/utilidadCarro.js" type="text/javascript"></script>
        <script src="js/simpleCart.js" type="text/javascript"></script>
        <script type='text/javascript' src='js/binaryajax.js'></script>
        <script type='text/javascript' src='js/id3.js'></script>
        <link href="css/styleUpload.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script src="js/utilidades.js" type="text/javascript"></script>
        <script src="js/jquery.alerts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>

        <script src="js/jqueryAudio.js" type="text/javascript"></script>
        <script src="js/audio.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script src="js/jquery.uploadify.min.js" type="text/javascript"></script>

        <script src="js/jquery-ui.min.js" type="text/javascript"></script>
        <script src="js/jquery.jcarousel.min.js" type="text/javascript"></script>
        <script src="js/cufon-yui.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
        <script src="js/ChunkFive_400.font.js" type="text/javascript"></script>

        <script src="js/ajax.js" type="text/javascript"></script> 
        <link href="css/estilo.css" rel="stylesheet" type="text/css">
        <link href="css/jquery.alerts.css" rel="stylesheet" type="text/css">
        <link href="css/example.css" rel="stylesheet" type="text/css">

        <script type="text/javascript" src="js/sessvars.js"></script>
        
<!--        Reportes-->
        <script src="js/utilidadReportes.js" type="text/javascript"></script>
        <script type="text/javascript">

            $(document).ready(function(){
	
                $(".menu h3").eq(2).addClass("active");
                $(".menu p").eq(2).show();
                //                $(".menu div").eq(2).show();

                $(".menu h3").click(function(){
                    $(this).next("p").slideToggle("slow")
                    .siblings("p:visible").slideUp("slow")
                    .siblings("div:visible").slideUp("slow");
                    
                    $(this).next("div").slideToggle("slow")
                    .siblings("p:visible").slideUp("slow");
                    
                    $(this).toggleClass("active");
                    $(this).siblings("h3").removeClass("active");
                });

            });
        </script>

        <script>
            $(document).ready(function(){
                cargar('Mi Coleccion');
            });
        </script>

        <script type="text/javascript">
            simpleCart = new cart("<? echo $_SESSION['correo'] ?>");
        </script>

        <!--Comet-->

        <!--    Fin comet-->
    </head>
    <body>
        <header>
            <img src="images/logo_1.png" width="170" height="90"/>

            <span id="bienvenida" style="
                  text-shadow: 1px 1px white, -1px -1px #333;
                  /*background-color: #ddd;*/
                  color: #ddd;
                  padding: 10px;
                  font-size: 180%;
                  margin-left: 10%;


                  ">BIENVENIDOS A UNIVALLE MUSIC  </span>
            <div id="logueo">
                <table>
                    <tr>

                        <th><span style="color: white; margin-left: 70%;">Usuario:</span></th><th> <span id="usLogeado" style="color : #3366ff; margin-left: 70%;"> <?
        session_start();
        echo $_SESSION['login'];
        ?></span> </th>
                    </tr> 
                </table>

              <form action="../Interfaces/Cerrar.php">
                    
                    <input style=" margin-left: 35%; width: 30%; background:#e4bf15;" type="submit" value="Salir"/>
                </form>
                
            </div>
        </header>

        <div class="menu">
            <h3 onclick="informacionMetadatos();">Subir una Cancion</h3>
            <div>
                <form action="ajaxupload/upload.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();">
                    <p id="f1_upload_process">Loading...<br/><img src="images/loader.gif" /><br/></p>
                    <div id="f1_upload_form" align="center"><br/>
                        <label>File:  
                            <input name="myfile" type="file" size="30" />
                        </label>
                        <label>
                            <input type="submit" name="submitBtn" class="sbtn" value="Subir archivo" />
                        </label>
                    </div>
                    <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                </form>
                <!--                    -->
                <form action="ajaxupload/upload.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
                    <p id="f1_upload_process">Loading...<br/><img src="images/loader.gif" /><br/></p>
                    <p id="f1_upload_form" align="center"><br/>
                        <label>File:  
                            <input name="myfile" type="file" size="30" />
                        </label>
                        <label>
                            <input type="submit" name="submitBtn" class="sbtn" value="Upload" />
                        </label>
                    </p>
                    <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                </form>
            </div>
            
            <h3 onclick="mostrarElemento('content')">Comprar canciones</h3>
            <p id="panelBusqueda">
                <input id="searchSong" type="search" style="width: 80%; height: 10%;" placeholder="Busqueda de canciones" onkeyup="obtenerCanciones();"><br> <br>
<!--                <input type="button" style="width: 80%; height: 10%;"   onclick="jAlert('buscar');" value="Buscar"><br> <br>-->

            </p>

            <h3>Biblioteca musical</h3>
            <p id="panelListas">
                <input type="button" style="width: 80%; background:#e4bf15; height: 10%;"   onclick="obtenerBiblioteca();" value="Biblioteca General"><br> <br>
                <input type="button" style="width: 80%; background:#e4bf15"   onclick="crearListaReproduccion();" value="Crear lista"><br> <br>
                <input type="button" style="width: 80%;background:#e4bf15"   onclick="cargar('Mi Coleccion');" value="Ver mi coleccion"><br><br>
                <input type="button" style="width: 80%;background:#e4bf15"   onclick="cargar('Mis Favoritas');" value="Ver mis canciones favoritas"><br><br>
                <input type="button" style="width: 80%;background:#e4bf15"   onclick="jAlert('Canciones recomendadas','en Construccion');" value="Ver Canciones recomendadas"><br><br>
                <input type="button" style="width: 80%;background:#e4bf15"   onclick="editarListas();" value="Editar mis listas de reproduccion"><br><br>
                <input type="button" style="width: 80%;background:#e4bf15"   onclick="listarCancionesCompartidas();" value="Ver mis canciones compartidas"><br><br>
            </p>
            <h3>Organizar por:</h3>
            <p>
                <input style=" margin-left: 5%; width: 40%; background:#e4bf15;" type="button" value="Genero" onclick="jAlert('por Genero','Organizar');"/><br><br>
                <input style=" margin-left: 5%; width: 40%; background:#e4bf15;" type="button" value="Artista" onclick="jAlert('por Artista','Organizar');"/><br><br>
                <input style=" margin-left: 5%; width: 40%; background:#e4bf15;" type="button" value="Album" onclick="jAlert('por Album','Organizar');"/><br><br>
                
            </p>
            <h3 onclick="mostrarElemento('DatosPersonales')"> Información Personal</h3>
            <h3 id="tituloReporte" style="display:none">Reportes</h3>
            <p>
                <input type="button" id="reportes" style="display:none; width: 80%; background:#e4bf15; height: 10%;"   onclick="mostrarElemento('reporteEscuchadas');" value="Canciones mas escuchadas"><br> <br>
            </p>
            <h3 id="tituloMensaje" style="display:none">Enviar Mensajes</h3>
            <p id="mesajes" style="display:none">
                <textarea id="descripcion" style="width:200px;height:100px;resize:none;" rows="10" ></textarea>
                <input type="button" id="guardar" value="Enviar" onclick="insertarAlerta('');"/>
            </p>
            <h3 id="prueba" style="display:none" >Alertas</h3>
            <div id="recMensajes" style="display:none">
                 <iframe width="240" height="150" src="comet.html" scrolling="auto" frameborder="no" ></iframe>
            </div>
        </div>

        <div id="principal">

            <div id="reproductor" class="mp_wrapper">

                <div id="mp_content_wrapper" class="mp_content_wrapper">
                </div>
                <div id="mp_player" class="mp_player">
                    <div id="jquery_jplayer"></div>
                    <div class="jp-playlist-player">
                        <div class="jp-interface">
                            <ul class="jp-controls">
                                <li><a href="#" id="jplayer_play" class="jp-play" tabindex="1">play</a></li>
                                <li><a href="#" id="jplayer_pause" class="jp-pause" tabindex="1">pause</a></li>
                                <li><a href="#" id="jplayer_stop" class="jp-stop" tabindex="1">stop</a></li>
                                <li><a href="#" id="jplayer_volume_min" class="jp-volume-min" tabindex="1">min volume</a></li>
                                <li><a href="#" id="jplayer_volume_max" class="jp-volume-max" tabindex="1">max volume</a></li>
                                <li><a href="#" id="jplayer_previous" class="jp-previous" tabindex="1">previous</a></li>
                                <li><a href="#" id="jplayer_next" class="jp-next" tabindex="1">next</a></li>
                                <li><a href="#" id="jplayer_add" class="jp-add" tabindex="1">next</a></li>
                            </ul>
                            <div class="jp-progress">
                                <div id="jplayer_load_bar" class="jp-load-bar">
                                    <div id="jplayer_play_bar" class="jp-play-bar"></div>
                                </div>
                            </div>
                            <div id="jplayer_volume_bar" class="jp-volume-bar">
                                <div id="jplayer_volume_bar_value" class="jp-volume-bar-value"></div>
                            </div>
                            <div id="jplayer_play_time" class="jp-play-time"></div>
                            <div id="jplayer_total_time" class="jp-total-time"></div>
                        </div>
                        <div id="jplayer_playlist" class="jp-playlist"><ul></ul></div>
                    </div>
                </div>
                <ul id="mp_albums" class="mp_albums jcarousel-skin">

                </ul>
            </div>
           
            <div id="reporteEscuchadas">
                <form action="../Interfaces/reportesInterface.php" method="POST" onsubmit="validar()">
                    <h1>Canciones más escuchadas</h1>
                    <label style="color:#e49b1a;margin-left: 20%; font-size: 22px;">mostrar reporte de las</label> <select name="thelist" style="width: 10%; margin-left: 0%;" onChange="comboReporte(this)">

                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>10</option>
                        <option>12</option>


                    </select><label style="color:#e49b1a; font-size: 22px;"> canciones mas escuchadas</label>
                    <input id="variable" name="variable" type="hidden" />
                    <input type="submit" value="ver_Reporte" name="opcion"/>
                </form>

            </div>

            <div id="crearLista">
                <h1>Crear una lista</h1>

                <label> Nombre de la lista</label> <input id="nombreLista" placeholder="introduce el nombre de la lista" /><br><br>
                <label> Elige una imagen</label><br>
                <select name="list_mail" multiple size="4" id="list_images"  onchange="imagenSeleccionada(this);">
                    <option value="1" >imagen1</option>
                    <option value="2" >imagen2</option>
                    <option value="3" >imagen3</option>
                    <option value="4" >imagen4</option>
                    <option value="5" >imagen5</option>
                    <option value="6" >imagen6</option>
                    <option value="7" >imagen7</option>
                    <option value="8" >imagen8</option>
                    <option value="9" >imagen9</option>
                    <option value="11" >imagen10</option>
                    <option value="12" >imagen11</option>
                    <option value="13" >imagen12</option>
                </select><br>
                <div id="imagen">
                    <img src= "images/noDisponible.jpg" width="200" height="150">
                </div>
                <input style="margin-left: 20%;" type="button" value="Crear lista" onclick="verificarLista('123', 'images/listasReproduccion')"/><input style="margin-left: 10%;" type="submit" value="cancelar" onclick="mostrarElemento('reproductor')" />
            </div>

            

            <div id="DatosPersonales">
                <h2> Informacion Personal</h2>
                <table>
                    <tr>

                        <th><span style="color: white;">login</span></th><th> <input id="login" class="output" value=<? echo $_SESSION['login'] ?> />  </th>
                    </tr> 

                    <tr>

                        <th><span style="color: white;">Nombres</span></th><th> <input id="nombreUsuario"  class="output" value=<? echo $_SESSION['nombres'] ?> /></th>
                    </tr> 
                    <tr>
                        <th><span style="color: white;">Apellidos</span></th><th><input id="apellidosUsuario" class="output" value=<? echo $_SESSION['apellidos'] ?> /> </th>
                    </tr>

                    <tr>
                        <th><span style="color: white;">Correo</span></th><th><input id="correoUsuario" type="email" class="output" value=<? echo $_SESSION['correo'] ?>/></th>
                    </tr>
                    <tr>
                        <th><span style="color: white;">Fecha de Registro</span></th><th><output id="fechaRegistro" class="output" style="margin-left: -30%" ><? echo $_SESSION['fecha_reg'] ?></output></th>
                    </tr>
                </table>
            </div>
            <div id="miVentana">
                <div id="titulo" >Editar listas de Reproduccion</div>
                <span id="contenidoVentanaModal">

                    al dar clic en <img src= "images/reproductor/addSong.png" width="20" height="20 ">
                    podras agregar canciones a las listas ya creadas, para eliminar canciones de una lista de reproduccion, simplemente das clic en el icono
                    <img src= "images/reproductor/Delete.png " width="20" height="20">
                    <select name="thelist" style="width: 90%; margin-left: 1%;" onChange="combo(this)">
                        <option>Elige una opcion</opcion>
                        <option>list1</opcion>
                        <option>list2</opcion>
                    </select>
                </span>" 
                <div id="botonesModal">
                    <input id="btnAceptar" onclick="ocultarVentana();" name="btnAceptar" size="20" type="button" value="Aceptar" />
                </div>
            </div>
            
            
               <div  style="display: none;" id="descargarCancion"></div>
       
        
        <div id="content">
				  <div id="sidebar" style="margin-top:20px">
                  </div>
                 <div id="left">
                    <h1>Carrito de compras</h1>
						<div id="audio">
                           <audio src="ruta" controls="controls" autoplay>
                            </audio>
                       </div>


                    <!--Add a Div with the class "simpleCart_items" to show your shopping cart area.-->
                    <div class="simpleCart_items" >
                    </div>

                    <div class="checkoutEmptyLinks">
                        <!--Here's the Links to Checkout and Empty Cart-->
                        <table>
                            <tr>
                                <td> <input type="button"  value="Vaciar carrito" class="simpleCart_empty"></td><td> <input type="button"  value="Pagar via paypal" class="simpleCart_checkout"></td>

                            </tr>

                        </table>

                    </div>
                </div>





                <!--End #content-->		
            </div>
        </div>

        <script type="text/javascript">
<?php $timestamp = time(); ?>
                 $(function() {
                     $('#file_upload').uploadify({
                         'formData'     : {
                             'timestamp' : '<?php echo $timestamp; ?>',
                             'token'     : '<?php echo md5('unique_salt' . $timestamp); ?>'
                         },
                         'swf'      : 'uploadify.swf',
                         'uploader' : '../ScripsUpload/uploadify.php'
                     });
                 });
        </script>
    </body>

</html>


