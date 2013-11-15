<? ini_set('error_reporting', E_ALL ^ E_NOTICE);
   ini_set('display_errors', 'on');
   require('conecta.php');
   $aDiv=array();
   $cSQL="SELECT ARTICULOS.ID_ARTICULO,FECHA_FIN,PRECIO_BASE,IDPUJAS,MAXIMAPUJA 
   FROM ARTICULOS 
LEFT JOIN (SELECT MAX(PUJAS.ID_PUJA) AS IDPUJAS,PUJAS.ID_ARTICULO,MAX(IMPORTE) AS MAXIMAPUJA FROM PUJAS GROUP BY ID_ARTICULO) 
PUJ ON ARTICULOS.ID_ARTICULO=PUJ.ID_ARTICULO 
   WHERE FECHA_FIN>NOW()-10 
   ORDER BY FECHA_FIN ASC, PRECIO_BASE ASC";
   $selArt = $oConni->prepare($cSQL);
   $selArt->execute();
   $selArt->store_result();
   $selArt->bind_result($IDArticulo,$FechaFin,$PBase,$IdPuja,$Importe);
   $ahora=new DateTime();
   while ($selArt->fetch()) { 
   
   		if($IdPuja!="")
		{
   		$dSQL="SELECT NICK FROM PUJAS INNER JOIN USUARIOS ON USUARIOS.ID_USUARIO=PUJAS.ID_USUARIO WHERE ID_PUJA=".$IdPuja;
   	   $selUsur = $oConni->prepare($dSQL);
	   $selUsur->execute();
	   $selUsur->store_result();
	   $selUsur->bind_result($Nick);
	   $selUsur->fetch();
	   $selUsur->close();}
		
       $cuentAtras=new DateTime($FechaFin);
       $intervalo=$ahora->diff($cuentAtras);
	  if(($ahora > $cuentAtras)==true) 
	  {
		  $tiempo=$intervalo->format('End Bids Time');
		  
	  }
	  else{
	  if($intervalo->format('%d')==0 && $intervalo->format('%h')==0 && $intervalo->format('%i')==0 ) $tiempo=$intervalo->format('%s segundos');
	   else if($intervalo->format('%d')==0 && $intervalo->format('%h')==0 ) $tiempo=$intervalo->format('%i minutos %s segundos');
	   else if( $intervalo->format('%d')==0) $tiempo=$intervalo->format('%h horas %i minutos %s segundos');	  
	  else $tiempo=$intervalo->format('%d dia/s %h:%i:%s');
	  }
	  if($Importe=="") {$Importe=0; $Requerida=$PBase; $Nick="-";}
	  if($Importe!="") {$Requerida=$Importe;}
       $aDiv[]=array("id" => $IDArticulo,"intervalo" => $tiempo, "importe" =>$Importe,"requerida" => $Requerida,"usuario" => $Nick);
	  
   }
   echo json_encode($aDiv);
?>
