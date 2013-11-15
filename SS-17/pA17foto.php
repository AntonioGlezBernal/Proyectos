<? 
require('conecta.php');
///Foto Usuario
if(isset($_GET['ID']))
{
$cSQL="SELECT FOTO FROM ARTICULOS WHERE ID_ARTICULO=".$_GET['ID'];
//$Resultado=mysql_query($cSQL);
$Resultado=$oConni->prepare($cSQL);
//$oFoto=mysql_result($Resultado,0,"FOTO");
$Resultado->execute();
$Resultado->store_result();
$Resultado->bind_result($oFoto);
$Resultado->fetch(); 
if($oFoto<>'')
{
header("Content-type:image/jpg");
echo $oFoto;
}
else { ?><img src="/img/empty.png" /><? }
}
?>
