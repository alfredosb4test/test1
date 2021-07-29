<?php
session_start();
//print_r($_SESSION);
date_default_timezone_set('America/Mexico_City');
include('funciones/conexion_class.php');
?>
<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
<head>
<!-- Compatibilidad de Boostrap con IE 9+ -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>TCV</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/ui_azul/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.timer.js"></script>
<script src="js/valida_campos_2.js"></script>
<script src="js/jquery.blockUI.js "></script>

<link type="text/css" href="css/estilos.css" rel="stylesheet" />
<link type="text/css" href="js/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="js/ui_azul/jquery-ui.min.css" rel="stylesheet" />
 
<script src="js/cuestionario.js"></script>

</head>
<body> 
<input type="hidden" id="txt_id_empleado" value="<?=$_SESSION['g_NumEmp'];?>">
<input type="hidden" id="txt_nombre" value="<?=$_SESSION['g_nombre'];?>">
<input type="hidden" id="txt_cuestionarios" value="<?=$_SESSION['g_cuestionarios'];?>">
<!-- ******************************************************** ENCABEZADO *********************************************************-->
<div style="position: relative; width:100%; height:80px; border:0px solid #093; margin:0; " id="encabezado">
	<div style="position:relative; float:left; width:20%; ">
    	<img src="images/logo_SHCP.png" border="0" style="position:relative; width:90%;  margin:2px 0 0 10px;">
    </div>
	<div style="position: relative; float:left; padding:4px; width:47%; height:93%; margin:0 auto; " id="txt_nom_cuest">    	
        <div style="position:relative; background-color:#FFF; border:0px solid #093; margin:16px 0 0 26px;">	
        	<center><font size="+2"> Cuestionario: <strong>Proyecto 2a vuelta</strong> </font></center>
           	<center> Usuario: <strong><span class="t_azul"> test </strong> </span></center>           
        </div>            
    </div>
	<div style="position:relative; float: right; width:30%; ">
    	<img src="images/logo_SAT.png" border="0" style="position:relative; width:90%;  top:2px">
    </div>    
</div>

<!-- ******************************************************** Preguntas *********************************************************-->
<div style="position: relative; width:99%;  height:85%; border:1px solid #093; margin:5px 0 0 5px; padding:4px;" id="contenido">
	
    <div id="cont_contrl" style="position: absolute; padding:1px 10px 0 1px; width:100%; z-index:1000; float:right;" align="right">
        <!-- ******************************************************** RELOJ *********************************************************-->
        <div style="padding: 0px 5px 5px 2px; width:160px; height:50px; display:none; float:right" class="" id="cont_reloj">
            <div id="segundo" style="position:relative; float:left; height:25px; margin-left:4px;"></div>
            <div id="puntos" style="position:relative; float:left; height:25px;">:</div>
            <div id="milisegundo" style="position:relative; float:left; height:25px;"> </div>
        </div>
        <!-- ******************************************************** RELOJ *********************************************************-->
        <div style="position:relative; background-color: ; width:110px; height:110px;" id="btn_continuar_salir">   
            <div class="btn btn-success btn-lg" style="position: relative; width:150px;   float: right" id="btn_comenzar">
                 Empezar 
            </div>  
            
            <div class="btn btn-danger btn-lg" style="position: relative; clear:both; top:10px; width:130px; float: right; display:none" id="btn_salir">
                 Salir 
            </div>   
        </div>
        <div id="time_out" style="height:25px; font-size:24px;"></div>
        <div id="stop" style="background-color:#0FF; display:none ;"> Stop </div>
        <div id="reset" style="background-color:#0FF; display:none;"> Reset </div>     
        
        
    </div> 
    
    
        
    <div style="position: relative; width:100%; height:100%;z-index:100;display:none; background-color: #F7F1D2; font-size:26px;" id="cont_timeout" align="center"> 
        <div style="position: relative; width:600px; height:50px;margin:0 auto; font-size:30px; top:50px; ">
        	<center>
                El Tiempo de respuesta ha concluido.<br>
                Para continuar de clic en siguiente.
       		</center>
        </div>
        <br><br><br><br>
        <div class="btn btn-success btn-lg" style="width:130px; height:50px;margin:0 auto; display:none; clear:both;" id="btn_siguiente">
             Siguiente 
        </div>    
    </div>
    <!-- ************************************** Contenido Instructivo y contenedor de pregustas, respuestas *********************************-->
    <div id="cont_respuesta_resp" style="position:relative; width:100%;">
        <div style="position:relative; width:99%; height:80px;  border:0px solid #000; margin:60px 0 0 5px; display:none;" id="cont_pregunta" class="f_preguntas">
        	<center><div style="position:relative; margin-top:21px;" class="t_size_28">Para comenzar de un clic en "Empezar"</div></center>
        </div>
        <br>  
        <div id="cont_respuesta" align="center" style="position:relative; height:70%; ">
			<?php include($_SESSION['g_plantilla']); ?>            	
        </div> 
    </div> 
       
</div>


<div id="cont" style="position: absolute; top:300px; height:150px; width:100%; background-color: #CCC; display:none">
 	<div id="respuesta_time_out"> </div>
  	<div id="test"></div>
	<input type="text" id="txt_preguntas" size="140" style="position:relative; top:280px;">

    <div id="test" style="position:relative;height:140px; width:150px; float:left; overflow:auto; background-color: #09F;">  </div>
    <div id="id_pregunta" style="position:relative;height:140px; width:70px; float:left; overflow:auto; background-color:#9C6">  </div>
    <div id="preguntas" style="position:relative;height:140px; width:300px; float:left; overflow:auto; background-color: #CC6">  </div>
    <div id="preguntas2" style="position:relative;height:140px; width:300px; float:left; overflow:auto; background-color:#9C6">  </div>
    <div id="ajax_respuesta" style="position: absolute; clear:both; margin:0 auto; z-index:10; padding-left:5px;">  </div>
</div>

	<div class="growlUI_err" style="display:none;">
		<table border="0">
		<tr>
			<td width="46">
				<img src="images/notification_error.png" width="38" height="38">
			</td>
			<td>
				<span class="growlUI_msg_txt negritas" >  </span>
			</td>
		</tr>
		</table>		
	</div>
	<div class="growlUI_ok" style="display:none;">
		<table border="0">
		<tr>
			<td width="46">
				<img src="images/notification_ok.png" width="38" height="38">
			</td>
			<td>
				<span class="growlUI_msg_txt negritas" >  </span>
			</td>
		</tr>
		</table>		
	</div>
</body>
</html>