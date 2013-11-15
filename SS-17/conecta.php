<?  ini_set('error_reporting', E_ALL ^ E_NOTICE);
    ini_set('display_errors','on'); 
    $oConni=new mysqli('192.168.0.40','root', '1234', 'DBPUJAS') 
            or die("Error al conectar.");
    $oConni->set_charset('utf8');
?>