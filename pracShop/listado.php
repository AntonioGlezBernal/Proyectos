<? 
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors','on'); 

require ('conecta.php');
$ExistenDatos=0;
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
	$ExistenDatos+=1;
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
	$aValores=array('salida'=> $salida, 'datos' => $ExistenDatos);
	echo json_encode($aValores); 
?>