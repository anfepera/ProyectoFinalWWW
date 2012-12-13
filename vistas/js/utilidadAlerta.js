/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var datos_recibidos;
function enviarA(ruta_archivo, str_datos)
{
//    alert('entra a enviar');
    $.ajax({
            async:true,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url:ruta_archivo,
            data:str_datos,
            beforeSend:previoEnvio,
            success:recibirDatos,
            timeout:1000,
            error:errores
        }); 
        return false;
}

function recibirDatos(datos)
{
        datos_recibidos = eval(datos);
//        alert(datos);
}

function errores()
{
    alert('Error al realizar la operacion');
}

function previoEnvio()
{
//    alert('iniciando el envio delos datos');
}

function insertarAlerta(descripcion)
{
    descripcion=$("#descripcion").attr("value");
    var url = "../Interfaces/alertaInterface.php";
    var datos_a_enviar = "opcion=1&descripcion="+descripcion;
    $("#descripcion").val("");
//    alert(url+': '+ datos_a_enviar);
    var x;
    x=$(document);
    x.ready(enviarA(url, datos_a_enviar));
    return datos_recibidos;
    
}


