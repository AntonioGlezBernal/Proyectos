<? 
require('conecta.php');

if(isset($_GET['ID']))
{
$cSQL="SELECT FOTO_MIN1 FROM NOTICIAS WHERE ID_NOTICIA=".$_GET['ID'];
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
}

///////////////FOTO MIN 2
if(isset($_GET['ID2']))
{
$cSQL="SELECT FOTO_MIN2 FROM NOTICIAS WHERE ID_NOTICIA=".$_GET['ID2'];
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
}

//////////FOTO MAX 1
if(isset($_GET['ID3']))
{
$cSQL="SELECT FOTO_MAX1 FROM NOTICIAS WHERE ID_NOTICIA=".$_GET['ID3'];
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
}

/////////////FOTO MAX 2
if(isset($_GET['ID4']))
{
$cSQL="SELECT FOTO_MAX2 FROM NOTICIAS WHERE ID_NOTICIA=".$_GET['ID4'];
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
}
?>
