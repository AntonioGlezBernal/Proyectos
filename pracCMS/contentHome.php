<? 
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors','on');
require('conecta.php');
require('cabses.php');
if($_POST['Enabled']==true)
{
ob_start();
$cSQL="SELECT ID_NOTICIA,FECHA_NEW,FECHA_UPDATE,TITULO,LEFT(CUERPO,682),LEFT(PIE,140),LISTA_TAGS,
							FOTO_MIN1,FOTO_MIN2,FOTO_MAX1,FOTO_MAX2,FECHA_FIN_PUBLICACION
							FROM NOTICIAS WHERE USUARIO_CREADOR=?";
					$listNew=$oConni->prepare($cSQL);
					$listNew->bind_param('i',$_SESSION['idUsuario']);
					$listNew->execute() or die ("Could not execute statement");
					$listNew->store_result();
					$listNew->bind_result($IdNew,$FecFin,$FecUp,$Titulo,$Cuerpo,$Pie,$Lista,$FM1,$FM2,$FX1,$FX2,$FecPub);
					while($listNew->fetch())
					{?>
                    <div id="divListPost<?=$IdNew?>" class="divListPost">
                        <div id="divPostTitle" class="divPostTitle"><?=$Titulo?></div>
                        <? if($FM1<>''){?>
                        <div id="divPostFot" class="divPostFot"><img src='foto.php?ID="<?=$IdNew?>"' /></div>
						<? }
						else { ?><div id="divPostFot" class="divPostFot"><img src='img/empty.png' /></div> <? }?>
                        <div id="divPostBody" class="divPostBody"><?=$Cuerpo?></div>
                        <div id="divPostFoot" class="divPostFoot"><?=$Pie?></div>
                        <div id="divPostFec" class="divPostFec"><?=$FecPub?></div>
                        <div id="divPostSee" class="divPostSee"><a id="<?=$IdNew?>" class="cmdMore">See More</a></div>
                    </div>
						<? }

	}
else echo "<h3>Not have permission to view news</h3>";
	
$salida=ob_get_contents();
ob_clean();
$aValores=array('salida'=> $salida);
echo json_encode($aValores);	
?>