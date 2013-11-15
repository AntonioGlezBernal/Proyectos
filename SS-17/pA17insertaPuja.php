<? 
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors','on'); 
require ('conecta.php');
require('cabses.php');
$dSQL="SELECT MAX(IMPORTE),PRECIO_BASE 
	FROM PUJAS INNER JOIN ARTICULOS ON PUJAS.ID_ARTICULO=ARTICULOS.ID_ARTICULO
	WHERE PUJAS.ID_ARTICULO=?";
	$selPuja=$oConni->prepare($dSQL);
	$selPuja->bind_param('i',$_POST['IdArt']);
	$selPuja->execute();
	$selPuja->store_result();
	$selPuja->bind_result($Importe,$PBase);
	$selPuja->fetch();
	$selPuja->close();
if($_POST['Cantidad']>$Importe && $_POST['Cantidad']>=$PBase )
{
   $cSQL="INSERT 
	INTO PUJAS 
	(ID_ARTICULO,ID_USUARIO,IMPORTE) 
	VALUES (?,?,?)";
	$instPuja=$oConni->prepare($cSQL);
	$instPuja->bind_param('iii',$_POST['IdArt'],$_SESSION['idUsuario'],$_POST['Cantidad']);
	$instPuja->execute();
	$instPuja->store_result();
	$instPuja->close();
	$salida='Correct';
}
	
	else{
		$salida='Error';
		}
$aValores=array('salida'=> $salida);
echo json_encode($aValores);
?>