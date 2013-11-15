<? 
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors','on'); 

require ('conecta.php');

$cSQL="TRUNCATE PREVIO";
	$instArticulo=$oConni->prepare($cSQL);
	$instArticulo->execute();
	$instArticulo->store_result();
	$instArticulo->close();	
	
ob_start();
echo "<img id='imgLogoProd' class='imgLogoProd' src='img/logo apple black.png' />
    <p style='left:30%'>Listado vacío, arrastre hasta aquí los articulos</p>";
	$salida=ob_get_contents();
	ob_clean();
	$aValores=array('salida'=> $salida);
	echo json_encode($aValores); 
?>