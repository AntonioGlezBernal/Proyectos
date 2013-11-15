<? 
require ('conecta.php');
   ini_set('error_reporting', E_ALL ^ E_NOTICE);
   ini_set('display_errors','on');
ob_start(); 
	echo "<thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Mensaje</th>
      </tr>
    </thead>
	<tbody>";
	$dSQL="SELECT ID,MENSAJE FROM MENSAJES WHERE NICK='".$_POST['selUser']."'";//.$_POST['selUser'];
	$Rsp=$oConni->prepare($dSQL);
	//$Rsp=bind_param('s',$_POST['selUser']);
    $Rsp->execute();
    $Rsp->store_result();
    $Rsp->bind_result($Id,$Mensaje);	
	while($Rsp->fetch())
	{   
   echo "
      <tr>
        <td>".$Id."</td>
        <td>".$_POST['selUser']."</td>
        <td>".$Mensaje."</td>
      </tr>";}
	echo "</tbody>";
   $Rsp->close();
   $salida=ob_get_contents();
   ob_clean();
   $aValores=array('salida'=> $salida);
   echo json_encode($aValores); 
?>