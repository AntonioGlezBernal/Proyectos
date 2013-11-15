<? 
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors','on'); 

require ('conecta.php');
$ProdModificado=$_POST['refArticulo'];
$Referencia=$_POST['refArticulo'];

	$cSQL="DELETE FROM PREVIO WHERE REFERENCIA=?";
	$instArticulo=$oConni->prepare($cSQL);
	$instArticulo->bind_param('s',$Referencia);
	$instArticulo->execute();
	$instArticulo->store_result();
	$instArticulo->close();	

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
	echo "
      <tr>
	  <div>
	  	<td class='tdArticulos'><img id='".$RefTot."' src='img/".$RefTot."' width='37px' height='37px' style='cursor:pointer;'/></td>
        <td>".$RefTot."</td>
        <td>".$CantTot."</td>
	  </div>
      </tr>";
	  }
	echo "</tbody> </table>";
	$selArt->close();
	$salida=ob_get_contents();
	ob_clean();
	$aValores=array('salida'=> $salida);
	echo json_encode($aValores); 
?>