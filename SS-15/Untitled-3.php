<? 
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors','on'); 

require ('conecta.php');
$dSQL="SELECT CANTIDAD FROM PREVIO WHERE REFERENCIA=".$_POST['refArticulo'];

	if(isset($dSQL) && !empty($dSQL))
	{
	$selCant=$oConni->prepare($dSQL);
	//$selCant->bind_param('s',$_POST['refArticulo']);
	$selCant->execute();
	$selCant->store_result($Cant);
	if($Cant){
		$cSQL="INSERT 
		INTO PREVIO 
		(CANTIDAD) 
		VALUES (?) WHERE REFERENCIA=?";
		$instArticulo=$oConni->prepare($cSQL);
		$instArticulo->bind_param('is',$Cant,$_POST['refArticulo']);
		$instArticulo->execute();
		$instArticulo->store_result();
		$instArticulo->close();
		}
	else{
		$cSQL="INSERT 
		INTO PREVIO 
		(REFERNCIA,CANTIDAD) 
		VALUES ('".$_POST['refArticulo']."',1)";
		$instArticulo=$oConni->prepare($cSQL);
		//$instArticulo->bind_param('si',$_POST['refArticulo'],1);
		$instArticulo->execute();
		$instArticulo->store_result();
		$instArticulo->close();
		}
	}
	$selCant->close();
	
//$Cant=$Cant+1;
	
ob_start();
	echo "<thead>
      <tr>
        <th>Referencia</th>
        <th>Cantidad</th>
      </tr>
    </thead>
	<tbody>";
	
	$xSQL="SELECT REFERENCIA,CANTIDAD FROM PREVIO GROUP BY REFERENCIA";
	$selArt=$oConni->prepare($xSQL);
	$selArt->execute();
	$selArt->store_result($RefTot,$CantTot);
	while($selArt->fetch()){
	echo "
      <tr>
        <td>".$RefTot."</td>
        <td>".$CantTot."</td>
      </tr>";
	  }
	echo "</tbody>";
	$selArt->close();
	$salida=ob_get_contents();
ob_clean();
$aValores=array('salida'=> $salida);
echo json_encode($aValores); 
?>