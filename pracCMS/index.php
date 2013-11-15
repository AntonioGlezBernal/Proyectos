<? 
require('conecta.php');
require('cabses.php');
?>
<script>
var logTrue=false;
var visImg=false;
var visAll=false;
var editAll=false;
var editText=false;
var editPhotos=false;
var newPost=false;
</script>
<?
if(!$_SESSION['idUsuario'])
{
 header('Location: login.php');
}
else{
	$logTrue="disabled";
	$visImg="disabled";
	$visAll="false";
	$editAll="disabled";
	$editText="disabled";
	$editPhotos="disabled";
	$newPost=0;
	$aPerm=array();
	//unset($aPerm);
	$xSQL="SELECT ID_ACCION,PERMISOS FROM PERMISOS WHERE ID_USUARIO=?";
	$selUsr=$oConni->prepare($xSQL);
	$selUsr->bind_param('i',$_SESSION['idUsuario']);
	$selUsr->execute() or die ("Could not execute statement");
	$selUsr->bind_result($IdAc,$Permisos);
	while($selUsr->fetch())
	{
	$aPerm[$IdAc]=$Permisos;
		}
	
	if($aPerm[1]=="S") {$logTrue="enable"; ?><script>var logTrue=true;</script> <? }
	if($aPerm[2]=="S") {$visImg="enable"; ?><script>var visImg=true;</script> <? }
	if($aPerm[3]=="S") {$visAll="true"; ?><script>var visAll=true;</script><? }
	if($aPerm[4]=="S") {$editAll="enable";?><script>var editAll=true;</script> <? }
	if($aPerm[5]=="S") {$editText="enable";?><script>var editText=true;</script> <? }
	if($aPerm[6]=="S") {$editPhotos="enable";?><script>var editPhotos=true;</script> <? }
	if($aPerm[7]=="S") {$newPost=1;?><script>var newPost=true;</script> <? }
		
	//foreach($aPerm as $id=>$value) printf("ID=".$id." -> VALOR=".$value."<br />");
	if($logTrue!="enable") 
	{
	session_destroy();
	header('Location: login.php?menDes=yes');
		}	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CMSpain</title>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script> 
<script type="text/javascript" src="js/jquery.bxslider.min.js"></script>
<link rel="stylesheet" href="css/jquery.bxslider.css" /> 
<link rel="stylesheet" type="text/css" href="css/styles.css"/>
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
</head>

<body>
<div id="divAll" class="divAll">

	<div id="navMenu" class="navMenu">
    	<img id="imgLogo" class="imgLogo" src="img/logo.png" onClick="funHome()" />
    	<ul>
    		<!--<li><img src="img/logo.png" /></li>-->
            <li><a id="liHome" onClick="funHome()">Home</a></li>
            <li><a id="liPosts">Posts</a></li>
            <li><a id="liBlogs">Blogs</a></li>
            <li><a id="liDesign">Design</a></li>
            <li><a id="liLogout" onClick="funOut()">Login Out</a></li>
    	</ul>
    </div>
    
    <div id="divContainer" class="divContainer">
    	
        <div id="divOpt" class="divOpt">
        <img src="img/before.png" />
        <img src="img/next.png" />
        <a id="cmdNew" onClick="funNew(<?=$newPost;?>)" class="cmdNew">New</a>
        <select id="selDate" class="selDate">
        	<option>Select Date</option>
            <option>1</option>
        </select>
        </div>
        
 		<div id="divNew" class="divNew">
        	<div id="divNewTitle" class="divNewTitle">
            	<span>Title</span><div><input id="txtTitle" size="65" type="text" /></div>
            </div>
        	<div id="divNewBody" class="divNewBody">
            	<span>Body</span><div><textarea id="txtBody" rows="14" cols="50"></textarea></div>
            </div>
            <div id="divNewImg" class="divNewImg">
            	<span>Small Image</span><div><input id="imgSm1" type="file" /></div>
                <span>Small Image 2</span><div><input id="imgSm2" type="file" /></div>
                <span>Big Image</span><div><input id="imgSx1" type="file" /></div>
                <span>Big Images 2</span><div><input id="imgSx2" type="file" /></div>
            </div>
            <div id="divNewFoot" class="divNewFoot">
            	<span>Footer</span><div><textarea id="txtFooter" rows="3" cols="125"></textarea></div>
            </div>
            <div id="divNewTag" class="divNewTag">
            	<span>Tags</span><div><textarea id="txtTag" rows="7" cols="50"></textarea></div>
            </div>
            <div id="divCmds" class="divCmds">
            <div><a id="cmdClose">Close</a></div>
            <div><a id="cmdPost">Post</a></div>
            </div>
        </div>
        
        <div id="divPosts" class="divPosts">
        	<? if($visAll=="true") 
				{
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
                        <div id="divPostBody" class="divPostBody"><?=$Cuerpo?>...</div>
                        <div id="divPostFoot" class="divPostFoot"><?=$Pie?></div>
                        <div id="divPostFec" class="divPostFec"><?=$FecPub?></div>
                        <div id="divPostSee" class="divPostSee"><a id="<?=$IdNew?>" class="cmdMore">See More</a></div>
                    </div>
						<? }
					}
			
				else echo "<h3>Not have permission to view news</h3>";
			?>
        </div>
    </div>
    
    <div id="divFooter" class="divFooter">
</div>

</body>
<script>

var numImgNow=1;
var numPast=1;
var numNext=4;
function funNew(value){	
	if(value==1) $("#divNew").show("slow");	
	else alert("Not have permission to create a news");	
	};

$("#cmdClose").click(function(){	
	$("#divNew").hide("slow");
	});

function funOut(){
	$.ajax({type:"POST",
            url:"loginOut.php",
            success:function(data) {
				location.reload();
			}
		   });
	}

$("#cmdPost").click(function(){	
	
	var Titulo=$('#txtTitle').val();
	var Cuerpo=$('#txtBody').val();
	var Img1=$('#imgSm1').val();
	var Img2=$('#imgSm2').val();
	var Imx1=$('#imgSx1').val();
	var Imx2=$('#imgSx2').val();
	$.ajax({type:"POST",
            url:"newPost.php?Img1="+Img1,
			data:formData,
            success:function(data) {
				location.reload();
			}
		});
	});

$(document).on("click",".cmdMore",function(event){	
	var id = this.id;
	$.ajax({type:"POST",
            url:"bigPost.php",
			data:"ID="+id+"&visImg="+visImg+"&editText="+editText+"&editPhotos="+editPhotos,
            success:function(data) {
			respuesta=$.parseJSON(data);
			$("#divPosts").html(respuesta.salida);
			}
		});
	});

function funFuera() {
	$("#cmdPrev").css('display','none');
	$("#cmdNext").css('display','none');
	};

function funEncima() {
	$("#cmdPrev").css('display','run-in');
	$("#cmdNext").css('display','run-in');										  
	};

function funNext(){
	var longitud=$("#divOnlyPostFot img").length;
	numImgNow++;
	numPast=numImgNow-1;
	if(longitud<numImgNow) numImgNow=1;
	$("#divOnlyPostFot img:nth-child("+numPast+")").css('display','none');
	$("#divOnlyPostFot img:nth-child("+numImgNow+")").css('display','run-in');
	}

function funPrev(){
	var longitud=$("#divOnlyPostFot img").length;
	numImgNow--;
	numNext=numImgNow+1;
	if(numImgNow==0) numImgNow=longitud;
	$("#divOnlyPostFot img:nth-child("+numNext+")").css('display','none');
	$("#divOnlyPostFot img:nth-child("+numImgNow+")").css('display','run-in');
	}

function funHome(){
	$.ajax({type:"POST",
            url:"contentHome.php",
			data:"Enabled="+visAll,
            success:function(data) {
			respuesta=$.parseJSON(data);
			$("#divPosts").html(respuesta.salida);
			}
		});
	}
$(document).on("click","#toolTitle",function(event){
	//var texto=$("div.divOnlyPostTitle").text();
	$("div.divOnlyPostTitle").html("<input type='text' id='txtTitleEdit' size='65' placeholder='Insert new title'/>								   <img src='img/save.png' id='saveTitle'/><img src='img/cancel.png' id='cancelEdit'/>")
	//console.log(texto);
	});

$(document).on("click","#toolBody",function(event){
	var texto=$("div.divOnlyPostBody").text();
	$("div.divOnlyPostBody").html("<textarea id='txtBodyEdit' >"+texto+"</textarea><img src='img/save.png' id='saveBody'/><img src='img/cancel.png' id='cancelEdit'/>")
	//console.log(texto);
	});

$(document).on("click","#toolFoot",function(event){
	var texto=$("div.divOnlyPostFoot").text();
	$("div.divOnlyPostFoot").html("<textarea id='txtFootEdit' >"+texto+"</textarea><img src='img/save.png' id='saveFoot'/><img src='img/cancel.png' id='cancelEdit'/>")
	//console.log(texto);
	});

$(document).on("click","#toolPhoto",function(event){
	
	$("div.divOnlyPostFot").html("<input type='file' id='srcImg' /><div><img src='img/save.png' id='savePhoto'/></div><div class='cancelEditPhoto'><img src='img/cancel.png' id='cancelEdit'/></div>")
	//console.log(texto);
	});

////EDITAR TITULO
$(document).on("click","#saveTitle",function(event){
	var texto=$("#txtTitleEdit").val();
	var ID=$(".divOnlyPost").attr("id");
	//console.log(texto);
	regex=/\s/;
	//&& !texto.match(regex)
	if(texto!="")
	{
		$.ajax({type:"POST",
            url:"savePost.php",
			data:"OP=title&ID="+ID+"&text="+texto,
            success:function(data) {
			funReloadPost(ID);
			}
		});
		}
	else alert("Title wrong");
	});

////EDITAR BODY
$(document).on("click","#saveBody",function(event){
	var texto=$("#txtBodyEdit").val();
	var ID=$(".divOnlyPost").attr("id");
	//console.log(texto);
	regex=/\s/;
	//&& !texto.match(regex)
	if(texto!="")
	{
		$.ajax({type:"POST",
            url:"savePost.php",
			data:"OP=body&ID="+ID+"&text="+texto,
            success:function(data) {
			funReloadPost(ID);
			}
		});
		}
	else alert("Body wrong");
	});

/////EDITAR PIE PAGINA
$(document).on("click","#saveFoot",function(event){
	var texto=$("#txtFootEdit").val();
	var ID=$(".divOnlyPost").attr("id");
	//console.log(texto);
	regex=/\s/;
	//&& !texto.match(regex)
	if(texto!="")
	{
		$.ajax({type:"POST",
            url:"savePost.php",
			data:"OP=foot&ID="+ID+"&text="+texto,
            success:function(data) {
			funReloadPost(ID);
			}
		});
		}
	else alert("Foot wrong");
	});

$(document).on("click","#cancelEdit",function(event){
	var ID=$(".divOnlyPost").attr("id");
	funReloadPost(ID);
	});

////EDITAR FOTO
$(document).on("click","#savePhoto",function(event){
	var ID=$(".divOnlyPost").attr("id");
	var fd = new FormData();    
	fd.append('file',$('#srcImg')[0].files[0]);
	fd.append('ID',ID);
	fd.append('NUM',numImgNow);
	fd.append('OP','photo');
	
		$.ajax({type:"POST",
            url:"savePost.php",
			processData: false,
	  		contentType: false,
			data:fd,
            success:function(data) {
			funReloadPost(ID);
			}
		});
	});

$(document).on("click","#cancelEdit",function(event){
	var ID=$(".divOnlyPost").attr("id");
	funReloadPost(ID);
	});
	
function funReloadPost(id){
	numImgNow=1;
	$("#divOnlyPostFot img:nth-child(1)").css('display','run-in');
	$("#divOnlyPostFot img:nth-child(2)").css('display','none');
	$("#divOnlyPostFot img:nth-child(3)").css('display','none');
	$("#divOnlyPostFot img:nth-child(4)").css('display','none');
	$.ajax({type:"POST",
            url:"bigPost.php",
			data:"ID="+id+"&visImg="+visImg+"&editText="+editText+"&editPhotos="+editPhotos,
            success:function(data) {
			respuesta=$.parseJSON(data);
			$("#divPosts").html(respuesta.salida);
			}
		});
	}
</script>
</html>