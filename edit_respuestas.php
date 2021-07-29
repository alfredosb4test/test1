<?php
session_start();
date_default_timezone_set('America/Mexico_City');
include('funciones/conexion_class.php');
$conn = new class_mysqli();
$id_cuestionario = $_GET['id_cuestionario']; 
$id_pregunta = $_GET['id_pregunta']; 
$array = $conn->get_respuestas($id_pregunta);
//echo "<pre>"; print_r($_GET); echo "</pre>";
//echo "<pre>"; print_r($array); echo "</pre>";
//echo $array['pregunta'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>OCE</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
  
<link type="text/css" href="css/estilos.css" rel="stylesheet" /> 
<link type="text/css" href="js/ui_azul/jquery-ui.min.css" rel="stylesheet" />
<link type="text/css" href="js/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/bootstrap/js/bootstrap.min.js"></script> 
<script src="js/valida_campos_2.js"></script>
<script src="js/ui_azul/jquery-ui.min.js"></script>

<script type="text/javascript">
var error = 0;
var $load = $("<div class='span_load'>&nbsp;</div>").addClass('load');
$( document ).ajaxError(function( event, request, settings ) {
  $("#ajax_respuesta").show().append( "<strong>Error: </strong>" + settings.url );
});
$(document).ready(function(e) {
	$("body").on('click', '.edit_pregunta', function(event) {
		event.preventDefault();
		oculta_dialogBox();
		$campo = $(this).attr('campo');
		$id_pregunta = $(this).attr('id_pregunta');
		$valor = $(this).text();
		//alert("Editar:"+$campo+" "+$id_pregunta+" "+$valor); 
		$("#txtPregunta").attr('value', $valor);
		$("#dialog_edit_pregunta").dialog({
			width: 900,
			height: 200,
			title:'Editar Respuesta',
			open: function( event, ui ) { $("#cont_edit_pregunta_err").empty(); $("#frm_edit_pregunta input").css('background-color', '#FFFFFF'); },			
			close: function( event, ui ) { },
			buttons: {
			  Guardar: function() {				  
				  error = 0;
				  valida_campo2(['txtPregunta'],'','','',['txtPregunta'], ["#FFD13A"], ["#FFFFFF"]);			
				  if(error){ 
				  	return;
				  }
				  $txtPregunta = $("#txtPregunta").val();
				  //alert(str_post); 
				  //return;
				  $.ajax({
					   type: "POST",
					   contentType: "application/x-www-form-urlencoded", 
					   url: "crud_tcv.php",
					   data: "accion=edit_respuesta&id_pregunta="+$id_pregunta+"&campo="+$campo+"&txtPregunta="+$txtPregunta,
					   beforeSend:function(){ $("#ajax_respuesta").html($load); },	   
					   success: function(datos){
						  //alert(datos); return;
						  try{ 
							  var obj = jQuery.parseJSON(datos);
							  //$("#contenido_dialog_nuevo_usr").hide();
							  $("#cont_edit_pregunta_err").show();
							  if(obj.accion == 'ok'){ 
								  oculta_dialogBox();
								  $("#span_resp_"+$campo).text($txtPregunta);
							  }						  
							  if(obj.accion == 'err'){ 
								   $("#cont_edit_pregunta_err").html('<span class="label label-warning"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Problemas con el servidor.</span>');
							  } 
							  $("#ajax_respuesta").empty(); 							  							  
						  }catch(err){
						  		$("#ajax_respuesta").empty(); 
							  $("#cont_edit_pregunta_err").html('<span class="label label-warning"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Problemas con el servidor.</span>');
						  }
					   },
					   timeout:90000,
					   error: function(err){ 
							  $("#cont_edit_pregunta_err").html('<span class="label label-warning"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Problemas con el servidor.</span>');
						}	   
				  });
			  }
			}
		});		
	});


});
function oculta_dialogBox(){
		$(".dialog").each(function( index ) {
			if ($(this).is(':visible'))
				$(this).dialog( "close" ); 
		});
} 
</script>

</head>
<body>
        
        <a href="ver_cuestionarios.php">&laquo;Regresar</a>
<table border="0" width="99%" cellpadding="5" cellspacing="5" id="tbl_usuarios_estatus" bgcolor="#FFFFFF" align="center" >
	<tr bgcolor="#0066FF"  class="txt_blanco negritas t_size_20">    	 
        <th><?= $array['pregunta']; ?></th>
    </tr>    
    <?php if($array['r1'] != ''){ ?>
    <tr> 
    	<td>
			<span class="hand edit_pregunta form-control" campo="r1" id="span_resp_r1" id_pregunta='<?=$array['id_pregunta'];?>' ><?= $array['r1']; ?></span>
    	</td>
    </tr>
    <?php } ?>
    <?php if($array['r2'] != ''){ ?>
    <tr> 
    	<td>
			<span class="hand edit_pregunta form-control" campo="r2"  id="span_resp_r2" id_pregunta='<?=$array['id_pregunta'];?>' ><?= $array['r2']; ?></span>
    	</td>
    </tr>
    <?php } ?>
    <?php if($array['r3'] != ''){ ?>
    <tr> 
    	<td>
			<span class="hand edit_pregunta form-control" campo="r3"  id="span_resp_r3" id_pregunta='<?=$array['id_pregunta'];?>' ><?= $array['r3']; ?></span>
    	</td>
    </tr>
    <?php } ?>
    <?php if($array['r4'] != ''){ ?>
    <tr> 
    	<td>
			<span class="hand edit_pregunta form-control" campo="r4"  id="span_resp_r4" id_pregunta='<?=$array['id_pregunta'];?>' ><?= $array['r4']; ?></span>
    	</td>
    </tr>
    <?php } ?>
    <?php if($array['r5'] != ''){ ?>
    <tr> 
    	<td>
			<span class="hand edit_pregunta form-control" campo="r5"  id="span_resp_r5" id_pregunta='<?=$array['id_pregunta'];?>' ><?= $array['r5']; ?></span>
    	</td>
    </tr>
    <?php } ?>
    <?php if($array['r6'] != ''){ ?>
    <tr> 
    	<td>
			<span class="hand edit_pregunta form-control" campo="r6"  id="span_resp_r6" id_pregunta='<?=$array['id_pregunta'];?>' ><?= $array['r6']; ?></span>
    	</td>
    </tr>
    <?php } ?>                    
</table>
<?php
$conn->close_mysqli();
?>
<div id="ajax_respuesta" style="position: relative; clear:both; margin:0 auto; z-index:10; padding-left:5px;">  </div>

<div class="dialog" id="dialog_edit_pregunta" style="display:none">
    <div id="cont_edit_pregunta" style="position: relative;"> 
            <form id="frm_edit_pregunta"> 
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1" style="width:30px;"> 
					<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                  </span> 
                  <input type="text" class="form-control"  id="txtPregunta" name="txtPregunta" maxlength="2000" size="100"  aria-describedby="basic-addon1">				           	
                </div> 					 				     	
            </form>
	</div>
    <div id="cont_edit_pregunta_err" ></div>
</div>
</body>
</html>