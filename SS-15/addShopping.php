<? 
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors','on'); 

require ('conecta.php');
$ProdModificado=$_POST['refArticulo'];
$Referencia=$_POST['refArticulo'];
$Cantidad=0;
$Contador=1;
$dSQL="SELECT CANTIDAD FROM PREVIO WHERE REFERENCIA=?";
	$Rsp=$oConni->prepare($dSQL);
	$Rsp->bind_param('s',$Referencia);
    $Rsp->execute();
    $Rsp->bind_result($Cant);
	$Rsp->fetch();
	$Cantidad=(int)$Cant;
	$Rsp->close();
	$Cantidad+=1;
if($Cantidad>1){
$mSQL="UPDATE PREVIO 
	SET CANTIDAD=? 
	WHERE REFERENCIA=?";
	$instArticuloOld=$oConni->prepare($mSQL);
	$instArticuloOld->bind_param('is',$Cantidad,$Referencia);
	$instArticuloOld->execute();
	$instArticuloOld->store_result();
	$instArticuloOld->close();
}
else{
	$cSQL="INSERT INTO PREVIO (REFERENCIA,CANTIDAD) VALUES (?,1)";
	$instArticulo=$oConni->prepare($cSQL);
	$instArticulo->bind_param('s',$Referencia);
	$instArticulo->execute();
	$instArticulo->store_result();
	$instArticulo->close();	
}
ob_start();
	echo "
	<table id='tableArticulos' class='tableArticulos' >
	<thead>
      <tr>
	  	<th>Articulo</th>
        <th>Referencia</th>
        <th>Cantidad</th>
      </tr>
    </thead>
	<tbody>";
	
	$xSQL="SELECT REFERENCIA,CANTIDAD FROM PREVIO ORDER BY CANTIDAD DESC, REFERENCIA ASC";
	$selArt=$oConni->prepare($xSQL);
	$selArt->execute() or die ("Could not execute statement");
	$selArt->bind_result($RefTot,$CantTot);
	while($selArt->fetch()){
	if($ProdModificado==$RefTot) $Modificado=$Contador;
	echo "
      <tr id='".$Contador."'>
	  <div>
	  	<td class='tdArticulos'><img id='".$RefTot."' src='img/".$RefTot."' width='37px' height='37px' style='cursor:pointer;'/></td>
        <td>".$RefTot."</td>
        <td>".$CantTot."</td>
	  </div>
      </tr>";
	  $Contador+=1;
	  }
	echo "</tbody> </table>";
	$selArt->close();
	$salida=ob_get_contents();
	ob_clean();
	$aValores=array('salida'=> $salida , 'ProdModificado' => $Modificado);
	echo json_encode($aValores); 
?>