<? 
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors','on');
require('conecta.php');
require('cabses.php');
header('Content-type:image/jpeg');
header('Content-Type: text/html; charset=utf-8');

if($_POST['OP']=="title")
{
$cSQL="UPDATE 
	NOTICIAS SET TITULO=? WHERE ID_NOTICIA=?";
	$instTitle=$oConni->prepare($cSQL);
	$instTitle->bind_param('si',$_POST['text'],$_POST['ID']);
	$instTitle->execute();
	$instTitle->store_result();
	$instTitle->close();
	}

if($_POST['OP']=="body")
{
$cSQL="UPDATE 
	NOTICIAS SET CUERPO=? WHERE ID_NOTICIA=?";
	$instTitle=$oConni->prepare($cSQL);
	$instTitle->bind_param('si',$_POST['text'],$_POST['ID']);
	$instTitle->execute();
	$instTitle->store_result();
	$instTitle->close();
	}

if($_POST['OP']=="foot")
{
$cSQL="UPDATE 
	NOTICIAS SET PIE=? WHERE ID_NOTICIA=?";
	$instTitle=$oConni->prepare($cSQL);
	$instTitle->bind_param('si',$_POST['text'],$_POST['ID']);
	$instTitle->execute();
	$instTitle->store_result();
	$instTitle->close();
	}

if($_POST['OP']=="photo")
{
$inF = $_FILES['file']['tmp_name'];
$prueba = file_get_contents($inF);
switch($_POST['NUM'])
{
case 1: $NumPhoto="FOTO_MIN1"; break;
case 2: $NumPhoto="FOTO_MIN2"; break;
case 3: $NumPhoto="FOTO_MAX1"; break;
case 4: $NumPhoto="FOTO_MAX2"; break;
	}
				$stmt = $oConni->prepare("UPDATE 
				NOTICIAS SET ".$NumPhoto."=? WHERE ID_NOTICIA=?");
				$stmt->bind_param('si' ,$prueba, $_POST['ID']);
				$stmt->execute();
				$id = $stmt->insert_id;
				$stmt->close();
	}
?>