<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Bids</title>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<link href='css/stylesLogin.css' rel='stylesheet' type='text/css'>
<link href='css/bootstrap.css' rel='stylesheet' type='text/css'>
<link href='css/flat-ui.css' rel='stylesheet' type='text/css'>
</head>

<body class="body">

<div id="divLogin" class="divLogin">
	<div id="divClipboard" class="divClipboard">
   <!--<img src="img/clipboard.png" />-->
    <h3>Welcome to</h3>
    <h4>CMSpain Login</h4>
    </div>
	
    <div id="divFrmLogin" class="divFrmLogin">
    <form>
    	<div class="control-group">
        	<input type="text" placeholder="Nick" id="txtNick" />
        </div>
        <div class="control-group">
        	<input type="password" placeholder="Password" id="txtPassword" />
        </div>
        <div class="control-group">
        	<a id="aCmdLogin" class="btn btn-danger btn-large btn-block">Login</a>
            <h6><? if(isset($_GET['menDes'])) echo "Your Account are not activated"; ?></h6>
        </div>

    </form>
    </div>

</div>

</body>
<script>
$("#aCmdLogin").click(function() {
	$.ajax({ type:"POST",
                   url:"compLogin.php",
                   data:"txtNick="+$("#txtNick").val()+"&txtPassw="+$("#txtPassword").val(),
                   success: function(data) {
			       respuesta=$.parseJSON(data);
                    if(respuesta.UserLog)
					{
					location.href='index.php';
						}
					else{
						$(".control-group h6").html('Nick or Password are not correct');
						$(".control-group").addClass('.control-group error');
						}
                   }
		   });
	});
</script>
</html>