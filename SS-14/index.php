<? 
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors','on');
require('conecta.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mensajes LS+BBDD</title>
<script type="text/javascript" src="jquery-1.9.1.min.js"></script> 
<link href='bootstrap.min.css' rel='stylesheet' type='text/css'>
<link href='global.min.css' rel='stylesheet' type='text/css'>
</head>

<body>
<div class="divCabecera">

	<h1>Mensajes con Local Storage y Base de datos</h1>
    
</div>

<section>
<div class="divFormulario">

    <form id="frmMensajes" name="frmMensajes">
    
        <div class="divSelectUser">
            <select id="selUser">
            	<option id="0" value="0">Seleccione Usuario</option>
                <option id="Antonio" value="Antonio">Antonio Gonzalez</option>
                <option id="Borja" value="Borja">Borja Ramirez</option>
                <option id="Alvaro" value="Alvaro">Alvaro Lavin</option>
                <option id="Mari" value="Mari">Mari Angeles Lola</option>
                <option id="Ricardo" value="Ricardo">Ricardo</option>
                <option id="Javi" value="Javi">Javier Arab</option>
            </select>
            <p class="help-block">Instrucciones de uso: </p>
            <p class="help-block">>Elija un usuario ya creado</p>
            <p class="help-block">>Escriba un mensaje</p>
            <p class="help-block">>Envielo</p>
            <p class="help-block">>Disfrute leyendo sus mensajes</p>
     	</div>
        
        <div class="divTextArea">
        <textarea id="txtAreaSMS" placeholder="Escriba un mensaje"></textarea>
        </div>
         
       	<div class="divProggresBar">
      		<div class="progress progress-danger progress-striped active">
        		<div class="bar"></div>
      		</div>
    	</div>   
        <div class="divValorestxtArea">
       		<div id="divPorcentaje">
            Porcentaje: <font color='#e46b24'>0.00%</font> 
            | Caracteres restantes: <font color='#e46b24'>250</font></div>
        </div>
           
		<div id="divMostrarTxtSave"></div>
        <input type="button" id="cmdEnviar" value="Enviar" />
    </form>    
</div>

<div class="divListadoSMS">
    <table id="tableSMS" class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Mensaje</th>
      </tr>
    </thead>
  </table>
<div id="divMensajeError"></div>
</div>
</section>


</body>
<script>
$('#txtAreaSMS').bind('keypress keydown keyup focusout focusin', function(e) {
		
		var valProgBar=$('#txtAreaSMS').val().length;
		
		caracteresRestantes=250-valProgBar;
		valProgBar*=0.4;
		longitud=valProgBar*3.65;
		valProgBar=valProgBar.toFixed(2);
		
		$('#divPorcentaje').html("Porcentaje: <font color='#e46b24'>"+valProgBar+"%</font> | Caracteres restantes: <font color='#e46b24'>"+caracteresRestantes+"</font>");
		
		$('.bar').css('width',longitud);
	});

$("#cmdEnviar").click(function() {	
		 localStorage.removeItem($("#selUser").val());
		 localStorage.removeItem($("#selUser").val()+"SMS");
        if($("#selUser").val()!="0" && $("#txtAreaSMS").val()!="")
		{
		$("#divMensajeError").html('');
		$.ajax({ type:"POST",
                   url:"newsms.php",
                   data:"selUser="+$("#selUser").val()+"&txtSms="+$("#txtAreaSMS").val(),
                   success: function(data) {
			       respuesta=$.parseJSON(data);
                            $("#tableSMS").html(respuesta.salida);
							$("#txtAreaSMS").val('');
							$("#selUser").val('0');
							$('#divPorcentaje').html("Porcentaje: <font color='#e46b24'>0.00%</font> | Caracteres restantes: <font color='#e46b24'>250</font>");
							$('.bar').css('width',"0");
                   }
               }); 
		}
		else $("#divMensajeError").html('Rellene los campos que faltan por favor y su mensaje aparecer&aacute; en esta tabla');
    });

$("#selUser").change(function() {
		 $("#txtAreaSMS").val('');
		 $("#divMensajeError").html('');
         $.ajax({ type:"POST",
                   url:"listado.php",
                   data:"selUser="+$("#selUser").val(),
                   success: function(data) {
			       respuesta=$.parseJSON(data);
                            $("#tableSMS").html(respuesta.salida);
							
                   }
               });
	if(localStorage.getItem($("#selUser").val()) && $("#selUser").val()!="0"){ 
		$("#txtAreaSMS").val(localStorage.getItem($("#selUser").val()+"SMS"));
		console.log(localStorage.getItem($("#selUser").val()));
		}
					$('#divPorcentaje').html("Porcentaje: <font color='#e46b24'>0.00%</font> | Caracteres restantes: <font color='#e46b24'>250</font>");
					$('.bar').css('width',"0");
    });

intervaloSave =setInterval("funSaveLS()",10000);

function funSaveLS(){
	if($("#selUser").val()!="0" && $("#txtAreaSMS").val()!="")
	{
	console.log("Guardado");
	$("#divMostrarTxtSave").html("Guardado");
	txtSave=setTimeout(function(){$("#divMostrarTxtSave").html("")},2000);
	console.log(localStorage.getItem("Nick"));
	localStorage.setItem($("#selUser").val(),$("#selUser").val());
	localStorage.setItem($("#selUser").val()+"SMS",$("#txtAreaSMS").val());
	}
	}
</script>
</html>