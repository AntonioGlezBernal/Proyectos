<? 
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors','on');
require('conecta.php');
require('cabses.php');

ob_start();
$cSQL="SELECT FECHA_NEW,FECHA_UPDATE,TITULO,CUERPO,PIE,LISTA_TAGS,
							FOTO_MIN1,FOTO_MIN2,FOTO_MAX1,FOTO_MAX2,FECHA_FIN_PUBLICACION
							FROM NOTICIAS WHERE ID_NOTICIA=?";
					$listNew=$oConni->prepare($cSQL);
					$listNew->bind_param('i',$_POST['ID']);
					$listNew->execute() or die ("Could not execute statement");
					$listNew->store_result();
					$listNew->bind_result($FecFin,$FecUp,$Titulo,$Cuerpo,$Pie,$Lista,$FM1,$FM2,$FX1,$FX2,$FecPub);
					$listNew->fetch();
					
                   echo'<div id="'.$_POST['ID'].'" class="divOnlyPost">
                        <div id="divOnlyPostTitle" class="divOnlyPostTitle">'.$Titulo;
						if($_POST['editText']=="true") echo '<img id="toolTitle" src="img/tool.png" />';
						echo '</div>
                        <div id="divOnlyPostFot" class="divOnlyPostFot" onmouseover="funEncima()" onmouseout="funFuera()">';
						if(isset($FM1)) echo'<img src="foto.php?ID='.$_POST['ID'].'" />';
						else echo '<img src="img/empty.png" />';
						if(isset($FM2)) echo'<img src="foto.php?ID2='.$_POST['ID'].'" />';
						if($_POST['visImg']=="true")
						{
						if(isset($FX1)) echo'<img src="foto.php?ID3='.$_POST['ID'].'" />';
						if(isset($FX2)) echo'<img src="foto.php?ID4='.$_POST['ID'].'" />';
						}
						echo '<a id="cmdPrev" class="cmdPrev" onclick="funPrev()">Prev</a>
						<a id="cmdNext" class="cmdNext" onclick="funNext()">Next</a></div>
						<div id="divOnlyPostFec" class="divOnlyPostFec">';
						if($_POST['editPhotos']=="true") echo '<img id="toolPhoto" src="img/tool.png" />';
						echo $FecPub.'</div>
                        <div id="divOnlyPostBody" class="divOnlyPostBody">'.nl2br($Cuerpo);
						if($_POST['editText']=="true") echo'<img id="toolBody" src="img/tool.png" /></div>
                        <div id="divOnlyPostFoot" class="divOnlyPostFoot">'.nl2br($Pie);
						if($_POST['editText']=="true") echo '<img id="toolFoot" src="img/tool.png" /></div>
                        <div id="divOnlyPostBack" class="divOnlyPostBack"><a id="cmdBack" class="cmdBack" onclick="funHome()">Back</a></div>
                    </div>';
					$listNew->close();
$salida=ob_get_contents();
ob_clean();
$aValores=array('salida'=> $salida);
echo json_encode($aValores);						
?>