<!DOCTYPE html>
<html lang="es">
<head>
<title>Proyecto OCE</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.timer.js"></script>
<script src="js/valida_campos_2.js"></script>


<link type="text/css" href="js/ui_azul/jquery-ui.min.css" rel="stylesheet" />
<link type="text/css" href="js/b4/css/bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="css/estilos.css" rel="stylesheet" />
 
<script src="js/ui_azul/jquery-ui.min.js"></script>
<script src="js/index.js"></script>

</head>
<body style="background-color:#FFF;">

    <div style="margin:0 auto; width:485px; height:490px; padding-top:150px; " id="cont_login">
        <!--<img src="images/esfera_logo_small.png" style="position:absolute; margin:-20px 0 0 320px" />-->
        <div id="login-box2">
            <center><H1 class="t_azul t_size_38">Proyecto 2a vuelta</H1></center>
            
            <br /><br /> 


	 		<button type="button" class="btn btn-outline-secondary btn-lg btn-block"  id="btn_login">Entrar</button>
     
            <div id="ajax_respuesta_login" style="position: absolute; margin-top:10px; width:370px;"> </div>
        </div>
    </div> 

</body>
<div id="dialog_select_cuest" style="width:390px; display:none">
    <span id="msg_status" style="display: ; position: relative; font-size:12px;">
		<select id="select_cuestionarios">
        	
        </select>
    </span>
</div>
</html>