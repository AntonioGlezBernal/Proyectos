<html>
    <head>
        <script src="jquery-1.9.1.min.js"></script>
        <meta charset="UTF-8">        
        <title>Cuentra Atrás</title>
    </head>
    <body>
        
    </body>    
    <script>
        $(document).ready(function() {
           var Tarea=setInterval(function() { 
                     $.ajax({type:"GET",
                              url:"pintaTiempoAtras.php",
                              success:function(data) {
                                  console.log(data);
                              }
                            }); },2000);           
       });
    </script>
</html>    
            
            