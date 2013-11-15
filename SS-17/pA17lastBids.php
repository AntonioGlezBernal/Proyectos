<?
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors', 'on');
require('conecta.php');

ob_start();
	$xSQL="SELECT 
	ID_ARTICULO,REFERENCIA,DESCRIPCION,OBSERVACIONES,
	PRECIO_BASE,FOTO,FECHA_INICIO,
	FECHA_FIN,ID_USUARIO 
	FROM ARTICULOS WHERE FECHA_FIN<NOW()
	ORDER BY FECHA_FIN DESC, PRECIO_BASE ASC";
	$selArt=$oConni->prepare($xSQL);
	$selArt->execute() or die ("Could not execute statement");
	$selArt->bind_result($IdAr,$Ref,$Descp,$Obs,$PBase,$Foto,$Fecha_Inicio,$Fecha_Fin,$IdUsur);
	
	
	while($selArt->fetch()){
	$image="pA17foto.php?ID=".$IdAr;
	echo "<div id=".$IdAr." class='divContenedorProd'>";
	if($Foto<>''){echo "<div><img src='pA17foto.php?ID=".$IdAr."' /></div>"; }
	else { echo "<div><img src='img/empty.png' /></div>";}
	echo "<div><b>Reference: </b>".$Ref."</div>
	<div><b>Description: </b>".$Descp."</div>
	<div><b>Observations: </b>".$Obs."</div>
	<div><b>Base price: </b>".$PBase."&euro;</div>
	</div>";
	
	}
	$selArt->close();
	$salida=ob_get_contents();
ob_clean();
	
	$aValores=array('salida'=> $salida);
	echo json_encode($aValores); 
?>