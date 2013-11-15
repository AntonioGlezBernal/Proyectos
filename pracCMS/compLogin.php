<? 
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors','on');
require('conecta.php');
require('cabses.php');

$xSQL="SELECT ID_USUARIOS FROM USUARIOS INNER JOIN PERMISOS ON ID_USUARIOS=ID_USUARIO WHERE NICK=? AND CLAVE=MD5('".$_POST['txtPassw']."') AND PERMISOS='S'";
	$selUsr=$oConni->prepare($xSQL);
	$selUsr->bind_param('s',$_POST['txtNick']);
	$selUsr->execute() or die ("Could not execute statement");
	$selUsr->bind_result($Id);
	$selUsr->fetch();

if(isset($Id)) $_SESSION['idUsuario']=$Id;

$aValores=array('UserLog'=> $_SESSION['idUsuario']);   echo json_encode($aValores); 
?>