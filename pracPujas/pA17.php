<? 
require('conecta.php');
require('cabses.php');
if(!$_SESSION['idUsuario'])
{
 header('Location: pA17login.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bids</title>

<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
<link href='css/bootstrap.css' rel='stylesheet' type='text/css'>
<link href='css/flat-ui.css' rel='stylesheet' type='text/css'>
<link href='css/stylesIndex.css' rel='stylesheet' type='text/css'>
</head>

<body>

<div id="divCabecera">
</div>

<div class="navbar navbar-inverse navBid">
   <div class="navbar-inner navbar-fixed-top">
       <div class="nav-collapse collapse">
          <ul class="nav">
          	  <li id="liLogo">
                <a onclick="funListado()"><img src="/1-pracRepaso/SS-17/img/logo.png" /></a>
              </li>
              <li id="liHome">
                <a onclick="funListado()">Home</a>
              </li>
              <li id="liLast">
                <a onclick="funLastBids()">Last Bids</a>
              </li>          
          </ul>
          <ul class="nav pull-right">
          	<li class="active"><a><?
            $cSQL="SELECT NOMBRE FROM USUARIOS WHERE ID_USUARIO=".$_SESSION['idUsuario'];
   			$MosUsu = $oConni->prepare($cSQL);
  			$MosUsu->execute();
   			$MosUsu->store_result();
   			$MosUsu->bind_result($Nick);
			$MosUsu->fetch();
			echo $Nick;?></a></li> 
            <li class="divider-vertical">
            </li>
            <li>
            <a onclick="funOut()" >Sign Out</a>
            </li>
    	</ul>
     </div><!--/.nav-collapse -->
  </div>
</div>


<div id="divContenido" class="divContenido">
	<div id="divListado" class="divListado">
    
	</div>
    <div id="divListadoPrecio" class="divListadoPrecio">
     
    </div>
</div>

</body>
<script>

var PVez=true;
$(document).ready(function() {					   
	funListado();
	});
	
function funListado(){
	$.ajax({ type:"POST",
                   url:"pA17listadoArticulos.php",
                   success: function(data) {
			       respuesta=$.parseJSON(data);
				   var listado=respuesta.salida;
                    $("#divListado").html(respuesta.salida);
                   }
		   });	//FIN AJAX PROD				   
		
	$.ajax({type:"POST",
                              url:"pA17listadoTiempo.php",
                              success:function(data) {
								respuesta=$.parseJSON(data);
								$("#divListadoPrecio").html('');
								for(i=0;i<respuesta.length;i++)
								{
								 $("#divListadoPrecio").append('<div>');
								 $("#divListadoPrecio > div:last-child").attr('class','divContendorPrecio');
								 $("#divListadoPrecio > div:last-child").html('<div id=Ptime'+respuesta[i].id+'><h5>'+respuesta[i].intervalo+'</h5></div><div id="MinBid'+respuesta[i].id+'">Minimum required Bid: <b>'+respuesta[i].requerida+'&euro;</b></div><div id="BestBid'+respuesta[i].id+'">Best Bid: <b>'+respuesta[i].importe+'&euro;</b></div><div id="BidUser'+respuesta[i].id+'">Bidder: <b>'+respuesta[i].usuario+'</b></div><div><input type="text" id="txtCant'+respuesta[i].id+'" placeholder="0" />&euro;<a id="cmdBid'+respuesta[i].id+'" class="btn btn-block btn-large" onclick="funBidear('+respuesta[i].id+')">Bid</a></div>');
								 if(respuesta[i].intervalo=="End Bids Time")
								 {
								 $("#cmdBid"+respuesta[i].id).attr('class','btn btn-large btn-block disabled');
								 $("#cmdBid"+respuesta[i].id).removeAttr('onclick','').unbind('click');
								 $("#txtCant"+respuesta[i].id).attr('disabled','disabled');
								 }
								}
								
                              }
                            });//FIN AJAZ TIME
	PVez=true;
	$("#liHome").attr('class','active');
	$("#liLast").removeAttr('class','');
	}//FIN FUNLISTADO

	var Tarea=setInterval(function() { 
                     $.ajax({type:"POST",
                              url:"pA17listadoTiempo.php",
                              success:function(data) {
								respuesta=$.parseJSON(data);
								for(i=0;i<respuesta.length;i++)
								{								
								 if(respuesta[i].intervalo=="End Bids Time")
								 {
								 $("#cmdBid"+respuesta[i].id).attr('class','btn btn-large btn-block disabled');
								 $("#cmdBid"+respuesta[i].id).removeAttr('onclick','').unbind('click');
								 $("#txtCant"+respuesta[i].id).attr('disabled','disabled');
								 	if(PVez==true)
									{
								 	setTimeout(function(){funListado()},10000);
									PVez=false;
									}
									 }
								 $("#Ptime"+respuesta[i].id).html('<h5>'+respuesta[i].intervalo+'</h5>');			
								 $("#MinBid"+respuesta[i].id).html('Minimum required Bid: <b>'+respuesta[i].requerida+'&euro;</b>');		
								 $("#BestBid"+respuesta[i].id).html('Best Bid: <b>'+respuesta[i].importe+'&euro;</b>');			
								 $("#BidUser"+respuesta[i].id).html('Bidder: <b>'+respuesta[i].usuario+'</b>');
								 
								}
								
                              }
                            }); },1000); //REFRESCO
	

function funBidear(Id){
				 
				 Cant=$('#txtCant'+Id).val();
				 if(!isNaN(Cant))
				 {
				 console.log(Id+" -> "+Cant);
				 $.ajax({type:"POST",
                              url:"pA17insertaPuja.php",
							  data:"IdArt="+Id+"&Cantidad="+Cant,
                              success:function(data) {
								respuesta=$.parseJSON(data);
								console.log(respuesta.salida);
								if(respuesta.salida=="Error") alert('Bid too low');
								else funListado();
                              }
                            });
				 }
				 else{ alert('Not a number'); 
				  $('#txtCant'+Id).val('');
				  }
		}
		
function funLastBids(){
				$.ajax({type:"POST",
                   url:"pA17lastBids.php",
                   success:function(data) {
				   respuesta=$.parseJSON(data);
				   	$("#divListado").html(respuesta.salida);
				   }
				  });
				 $.ajax({type:"POST",
                   url:"pA17lastTime.php",
                    success:function(data) {
								respuesta=$.parseJSON(data);
								$("#divListadoPrecio").html('');
								for(i=0;i<respuesta.length;i++)
								{
								 $("#divListadoPrecio").append('<div>');
								 $("#divListadoPrecio > div:last-child").attr('class','divContendorPrecio');
								 $("#divListadoPrecio > div:last-child").html('<div id=Ptime'+respuesta[i].id+'><h5>'+respuesta[i].intervalo+'</h5></div><div>Base price: <b>'+respuesta[i].requerida+'&euro;</b></div><div>Winning bid: <b>'+respuesta[i].importe+'&euro;</b></div><div>Winning bidder:</div><div><h2>'+respuesta[i].usuario+'</h2></div>');
								}
								
                              }
				  });
							
	$("#liHome").removeAttr('class','');
	$("#liLast").attr('class','active');
	}

function funOut(){
	$.ajax({type:"POST",
            url:"pA17out.php",
            success:function(data) {
				location.reload();
			}
		   });
	}
</script>
</html>