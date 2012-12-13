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


        <!--Scripts relacionados con subida de canciones -->

        <link href="css/styleUpload.css" rel="stylesheet" type="text/css" />
      

        <!--Scripts relacionados con la gestion de listas de reproduccion -->


        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>

        <script src="js/jquery.alerts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>


        <script type="text/javascript" src="js/jquery.min.js"></script>



        <script src="js/utilidades.js" type="text/javascript"></script>
       
        <script src="js/jquery-ui.min.js" type="text/javascript"></script>


        <!--<script src="js/cufon-yui.js" type="text/javascript"></script>-->
        <script type="text/javascript" src="js/jquery.jplayer.min.js"></script>

        <script src="js/utilidadReportes.js" type="text/javascript"></script>


        <link href="css/estilo.css" rel="stylesheet" type="text/css">
        <link href="css/jquery.alerts.css" rel="stylesheet" type="text/css">
        <link href="css/example.css" rel="stylesheet" type="text/css">

        <script type="text/javascript">
            $(document).ready(function(){
	
                $(".menu h3").eq(2).addClass("active");
                $(".menu p").eq(2).show();
                $(".menu div").eq(2).show();

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
    </head>


    <body>
        <header>
            <img src="images/logo_1.png" width="170" height="90"/>
            <span id="respuesta"></span>

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

                        <th><span style="color: white; margin-left: 70%;">Usuario:</span></th><th> <span style="color : #3366ff; margin-left: 70%;"> <?
        session_start();
        echo $_SESSION['login'];
        ?></span> </th>
                    </tr> 



                </table>

                <a href="../Interfaces/Cerrar.php" style="margin-left: 30%; background-color: #bf850d;">Salir</a> 


            </div>
            <!--</div>-->


        </header>

        <div class="menu">
            <h3>Enviar alerta</h3>

            <p>

            </p>

            <!--                    -->


            <h3 >Reportes</h3>
            <p>
                <input type="button" style="width: 80%; background:#e4bf15; height: 10%;"   onclick="mostrarElemento('reporteEscuchadas');" value="Canciones mas escuchadas"><br> <br>
                

            </p>

            <h3 onclick="mostrarElemento('DatosPersonales')"> Información Personal</h3>
            <p>

            </p>


        </div>



        <div id="principal">
            <div id="DatosPersonales" >
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

            <div id="reporteCompradas">
                <h1>Canciones más Compradas</h1>
                <input type="button" value="mi boton" class="button" data-type="zoomin"/>

            </div>

            <div id="id_popup" class="overlay-container">
<!--                <div class="window-container zoomin">
                    <h1 style="color: #1f0f0f">Versión en Zoom in</h1> 
                    Texto de la ventana emergente<br/>
                    <br/>
                    <span class="close">Cerrar</span>
                </div>-->
            </div>











        </div>










    </body>






</html>



