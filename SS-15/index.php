<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Drag & Drop + BBDD</title>
<script type="text/javascript" src="jquery-1.9.1.min.js"></script> 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link href='css/global.min.css' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
</head>

<body>

<div class="divCabecera">

	<h1>Drag & Drop + BBDD</h1>
    <h5>&copy;B&uacute;ho</h5>
    
</div>
	
    <div class="divListProd">
  		<ul class="ulProductos">
        <li><img title="iMac" id="Mac-01" src="img/Mac-01.png"/></li>
        <li><img title="Mac Pro" id="Mac-03" src="img/Mac-03.png"/></li>
        <li><img title="MacBook Air" id="Mac-02" src="img/Mac-02.png"/></li>
        <li><img title="MacBook Pro" id="Mac-04" src="img/Mac-04.png"/></li>
        <li><img title="Mac Mini" id="Mac-05" src="img/Mac-05.png"/></li>
        <li><img title="iPad 2" id="Pad-01" src="img/Pad-01.png"/></li>
        <li><img title="iPad Mini" id="Pad-02" src="img/Pad-02.png"/></li>
        <li><img title="iPhone 3GS" id="Mvl-01" src="img/Mvl-01.png"/></li>
        <li><img title="iPhone 4" id="Mvl-02" src="img/Mvl-02.png"/></li>
        <li><img title="iPod classic" id="MP3-01" src="img/MP3-01.png"/></li>
        <li><img title="iPod" id="MP3-04" src="img/MP3-04.png"/></li>
        <li><img title="iPod shuffle" id="MP3-05" src="img/MP3-05.png"/></li>
    	</ul>
  	</div>
    
	<div class="divArrowGif"><img src="img/arrow.gif" /></div>
    <div class="divArrow"><img src="img/arrow-right.png" /></div>
    
	<div id="divListCompra" class="divListCompra">
    <img id="imgLogoProd" class="imgLogoProd" src="img/logo apple black.png" />
    <p>Arrastre hasta aquí los articulos</p>
	</div>
    
	<div id="divBorrar" class="divBorrar">
    <img src="img/trashone2.png" />
    <p>Borrar un articulo</p>
	</div>
    
    <div id="divBorrarCompra" class="divBorrarCompra">
    <img src="img/cartremove.png" />
    <p>Vaciar carrito</p>
    </div>
    
    <div id="divBorrarAll" class="divBorrarAll">
    <img src="img/trashall.png" />
    <p>Borrar todos agrupados</p>
    <h5>&copy;Antonio Glez Bernal</h5>
	</div>


</body>
<script>
 $(document).ready(function(){
    $(".ulProductos img").draggable({
      revert: true
      
    });
    $("#divListCompra").droppable({
      accept: '.ulProductos img',
      drop: function( event, ui ) {
        var prod_id = ui.draggable.attr("id");
        $.ajax({
          type: "POST",
          url: "addShopping.php",
          data: "refArticulo="+prod_id,
          success: function(data){
			respuesta=$.parseJSON(data);
            $("#divListCompra").html(respuesta.salida);
			var numero=parseInt(respuesta.ProdModificado);
			if(numero%2==0)
			{
			$("#"+respuesta.ProdModificado).css("background-color", "rgba(189, 195, 199, 1)");
			var cambioColor=setTimeout(function(){$("#"+respuesta.ProdModificado).css("background-color", "rgba(239, 243, 244, 1)")},500);
			}
			else{
			$("#"+respuesta.ProdModificado).css("background-color", "rgba(26, 188, 156, 0.9)");
			var cambioColor=setTimeout(function(){$("#"+respuesta.ProdModificado).css("background-color", "rgba(26, 188, 156, 0.2)")},500);
				}
			
					$(".tdArticulos img").draggable({
      					revert: true
   					 });
          }
        });
            }
    });
  });
 
	
	 $("#divBorrar").droppable({
      accept: '.tdArticulos img',
      drop: function( event, ui ) {
        var prod_id = ui.draggable.attr("id");
        $.ajax({
          type: "POST",
          url: "removeOne.php",
          data: "refArticulo="+prod_id,
          success: function(data){
			respuesta=$.parseJSON(data);
            $("#divListCompra").html(respuesta.salida);
			var numero=parseInt(respuesta.ProdModificado);
			if(numero%2==0)
			{
			$("#"+respuesta.ProdModificado).css("background-color", "rgba(189, 195, 199, 1)");
			var cambioColor=setTimeout(function(){$("#"+respuesta.ProdModificado).css("background-color", "rgba(239, 243, 244, 1)")},500);
			}
			else{
			$("#"+respuesta.ProdModificado).css("background-color", "rgba(26, 188, 156, 0.9)");
			var cambioColor=setTimeout(function(){$("#"+respuesta.ProdModificado).css("background-color", "rgba(26, 188, 156, 0.2)")},500);
				}
			$(".tdArticulos img").draggable({
      					revert: true
   					 });
          }
        });
            }
    });
	 
	$("#divBorrarAll").droppable({
      accept: '.tdArticulos img',
      drop: function( event, ui ) {
        var prod_id = ui.draggable.attr("id");
        $.ajax({
          type: "POST",
          url: "removeAll.php",
          data: "refArticulo="+prod_id,
          success: function(data){
			respuesta=$.parseJSON(data);
            $("#divListCompra").html(respuesta.salida);
			$(".tdArticulos img").draggable({
      					revert: true
   					 });
          }
        });
            }
    });
	
	$("#divBorrarCompra").click(function(){
       $.ajax({ type:"POST",
                   url:"removeCart.php",
                   success: function(data) {
			       respuesta=$.parseJSON(data);
                            $("#divListCompra").html(respuesta.salida);
							
                   }
               });      
    });
	
	$("#imgLogoProd").click(function(){
       $.ajax({ type:"POST",
                   url:"listado.php",
                   success: function(data) {
			       respuesta=$.parseJSON(data);
				   if(respuesta.datos!=0)
				   {
                            $("#divListCompra").html(respuesta.salida);
							$(".tdArticulos img").draggable({
      					revert: true
   					 });//FIN DRAGGABLE
							
                   }//FIN IF
				   else { 
					$("#divListCompra").html("<img id='imgLogoProd' class='imgLogoProd' src='img/logo apple black.png' /><p style='left:30%'>Listado vacío, arrastre hasta aquí los articulos</p>"); }
				   }//FIN SUCCESS
				  
               }); //FIN AJAX     
    }); // FIN IMGLOGPROD
</script>
</html>