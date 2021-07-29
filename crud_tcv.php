<?php
session_start(); 
date_default_timezone_set('America/Mexico_City');
include('funciones/conexion_class.php');
$conn = new class_mysqli();
if(array_key_exists("accion", $_POST) && $_POST['accion']=='get_array_preguntas'){
	$get_preguntas_array = $conn->get_preguntas_array($_SESSION['g_NumEmp'],$_SESSION['g_cuestionarios'], $_SESSION['g_aleatorio']);
	if($get_preguntas_array == ""){
		echo '{"tipo":"terminado"}';
		return;
	}
	if($conn->get_cuestionario == "ok"){
		$array = $conn->preguntas;
		$tiempo = $conn->get_tiempo;
		$nombre_cuest = $conn->nombre_cuest;
		echo '{"tipo":"ok_preguntas","preguntas":"'.$array.'","tiempo":"'.$tiempo.'","nombre_cuest":"'.$nombre_cuest.'"}';
		$conn->status_pendiente($_SESSION['g_NumEmp'],$_SESSION['g_cuestionarios']);
	}else{
		echo '{"tipo":"error_sql"}';
	}
	//shuffle($conn->preguntas);
	//echo $array = json_encode($conn->preguntas);
	//$array = $conn->preguntas;
	//$array = $conn->preguntas;
	//$json_completo = '{"tipo":"ok","preguntas":"'.$array.'"}';
}
if(array_key_exists("accion", $_GET) && $_GET['accion']=='get_preguntas_cuestionario'){
	$id_cuestionario = $_GET['id_cuestionario'];
	echo $conn->get_preguntas_cuestionario($id_cuestionario);
}
if(array_key_exists("accion", $_POST) && $_POST['accion']=='get_pregunta'){
	$preguntas = explode(",", $_POST['preguntas']);
	//$pregunta = array_pop($preguntas);	// extrae y devuelve el último valor
	$pregunta = array_shift($preguntas);	// extrae y devuelve el primer valor
	$get_pregunta = $conn->get_pregunta($pregunta);	
	$preguntas = implode(',',$preguntas);

	//echo "<pre>"; print_r($get_pregunta); echo "</pre>";
 	
 	if ($get_pregunta['tipo_preg'] == 'opcionMulti') {
		echo '{"tipo":"ok_preguntas",
		   "pregunta":"'.html_entity_decode($get_pregunta['pregunta']).'","preguntas":"'.$preguntas.'",
		   "id_pregunta": "'.$get_pregunta['id_pregunta'].'",
		   "r1": '.$get_pregunta['r1'].',
		   "r2": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['r2'])).'",
		   "r3": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['r3'])).'",
		   "r4": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['r4'])).'",
		   "r5": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['r5'])).'",
		   "r6": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['r6'])).'",
		   "tipo_preg": "'.$get_pregunta['tipo_preg'].'",
		   "rok": "'.$get_pregunta['rok'].'",
		   "tip": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['tip'])).'",
		   "obligatoria": "'.$get_pregunta['obligatoria'].'",
		   "peso": "'.$get_pregunta['peso'].'",
		   "segundos": "'.$get_pregunta['segundos'].'"
		  }';
 	}else{
 		//echo "<pre>"; print_r($get_pregunta); echo "</pre>";
		echo '{"tipo":"ok_preguntas",
		   "pregunta":"'.html_entity_decode($get_pregunta['pregunta']).'","preguntas":"'.$preguntas.'",
		   "id_pregunta": "'.$get_pregunta['id_pregunta'].'",
		   "r1": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['r1'])).'",
		   "peso1": "'.$get_pregunta['peso1'].'",
		   "r2": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['r2'])).'",
		   "peso2": "'.$get_pregunta['peso2'].'",
		   "r3": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['r3'])).'",
		   "peso3": "'.$get_pregunta['peso3'].'",
		   "r4": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['r4'])).'",
		   "peso4": "'.$get_pregunta['peso4'].'",
		   "r5": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['r5'])).'",
		   "peso5": "'.$get_pregunta['peso5'].'",
		   "r6": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['r6'])).'",
		   "peso6": "'.$get_pregunta['peso6'].'",
		   "tipo_preg": "'.$get_pregunta['tipo_preg'].'",
		   "rok": "'.$get_pregunta['rok'].'",
		   "tip": "'.html_entity_decode(eregi_replace("[\n|\r|\n\r]", "", $get_pregunta['tip'])).'",
		   "obligatoria": "'.$get_pregunta['obligatoria'].'",		   
		   "peso": "'.$get_pregunta['peso'].'",
		   "segundos": "'.$get_pregunta['segundos'].'"
		  }';
		}
} //preg_replace("\x0d|\x0a", "", $texto);
if(array_key_exists("accion", $_POST) && $_POST['accion']=='comprobar_terminacion'){
	$json_string = $_POST['preguntas'];	// Preguntas que ha contestado
	$json_format = json_decode($json_string);	
 	// USR TEST
	if($_SESSION['g_NumEmp'] == 1111)
		return "";
		
	$preguntas = $conn->get_preguntas_array($_SESSION['g_NumEmp'], $_SESSION['g_cuestionarios']);	// comprueba cuantas faltan por contestar
	$preguntas = explode(',', $preguntas);	// convertimos en array
	foreach($preguntas as $id){
         foreach($json_format as $row){ 
		 // si de las preguntas faltantes se encuentran en las contestadas que por alguna razon no se guardaron la intenta guardar de nuevo 
        	 if ($row->id_pregunta == $id){ 
				 $conn->guarda_reactivo($_SESSION['g_NumEmp'], $row->id_pregunta, $_SESSION['g_cuestionarios'], $row->respuesta, $row->rok, $row->peso, $row->t_contestar);
			 }
		 } 
	}
	echo $preguntas = $conn->get_preguntas_array($_SESSION['g_NumEmp'], $_SESSION['g_cuestionarios']);
	//$pregunta = array_pop($preguntas);
}
if(array_key_exists("accion", $_POST) && $_POST['accion']=='guarda_reactivo'){
//	data: "accion=guarda_reactivo&respuesta="+respuesta+"&id_pregunta="+id_pregunta+"&rok="+rok+"&peso="+peso,	
//sleep(4);
	$respuesta = $_POST['respuesta'];

	// verificar que el tiempo si esta activado haya terminado y si esta
	// activa la opcion de preg_forzar para no guardar la pregunta como no contestada "nc"
	// y volverla a poner en cola para mostrarla nuevamente hasta q se conteste.

	if ($respuesta == 'nc' && $_SESSION['g_preg_forzar']) {
		echo '{"tipo":"poner_en_cola_prenguta"}';
		$conn->close_mysqli();
		exit();	
	}

	$id_pregunta = $_POST['id_pregunta'];
	$rok = trim($_POST['rok']);
	$peso = $_POST['peso'];
	$t_contestar = $_POST['t_contestar'];

	$get_pregunta = $conn->guarda_reactivo($_SESSION['g_NumEmp'], $id_pregunta, $_SESSION['g_cuestionarios'], $respuesta, $rok, $peso, $t_contestar);	
	
	if(strstr($get_pregunta, "error_")){
		echo $get_pregunta = $conn->guarda_reactivo($_SESSION['g_NumEmp'], $id_pregunta, $_SESSION['g_cuestionarios'], $respuesta, $rok, $peso, $t_contestar);	 
	}else
		echo $get_pregunta;
}

if(array_key_exists("accion", $_POST) && $_POST['accion']=='ver_resp'){
//	data: "accion=guarda_reactivo&respuesta="+respuesta+"&id_pregunta="+id_pregunta+"&rok="+rok+"&peso="+peso,
	$id_empleado = $_POST['id_empleado'];

}
if(array_key_exists("accion", $_POST) && $_POST['accion']=='selec_cuestionario'){
	$_SESSION['g_cuestionarios'] = $_POST['id'];
	$info_cuestionario = $conn->get_nom_cuestionario($_POST['id']);
	$_SESSION['g_nom_cuestionario'] = $info_cuestionario['nombre'];
	$_SESSION['g_aleatorio'] = $info_cuestionario['aleatorio'];
	$_SESSION['g_preg_forzar'] = $info_cuestionario['preg_forzar'];
	$_SESSION['g_tiempo'] = $info_cuestionario['tiempo'];	
	$_SESSION['g_plantilla'] = $info_cuestionario['instrucciones'];
}
if(array_key_exists("accion", $_POST) && $_POST['accion']=='status_terminar'){
	$conn = new class_mysqli();
	$terminado = $conn->status_terminar($_POST['id_empleado'], $_POST['id_cuestionario']);
}

if(array_key_exists("accion", $_POST) && $_POST['accion']=='nuevo_usuario'){
	$cuestionarios = "[".rtrim($_POST['cuestionarios'],",")."]";
	$txtNum = trim($_POST['txtNum']);
	$Nombre = trim($_POST['txtNombre']);
	$NumEmp = trim($_POST['txtPassword']); 
	$password = "pwd|".md5($NumEmp); 
	//echo $password;
	echo $conn->guarda_nuevo_usuario($txtNum, $Nombre, $password, $cuestionarios);
}
if(array_key_exists("accion", $_POST) && $_POST['accion']=='add_cuestionario'){
	$cuestionarios = "[".rtrim($_POST['cuestionarios'],",")."]";
	$id_usr = trim($_POST['id_usr']);
	//echo $password;
	echo $conn->add_cuestionario($id_usr, $cuestionarios);
}
if(array_key_exists("accion", $_POST) && $_POST['accion']=='nuevo_cuest'){		 
	$txtNombreCuest = trim($_POST['txtNombreCuest']);
	$txttiempo = trim($_POST['optionsTiempo']);
	//echo '{"insert":"ok"}';
	echo $conn->nuevo_cuest($txtNombreCuest, $txttiempo);
}
if(array_key_exists("accion", $_POST) && $_POST['accion']=='edit_pregunta'){	
	$id_pregunta = $_POST['id_pregunta'];
	$campo = $_POST['campo'];
	$txtPregunta = trim($_POST['txtPregunta']);
	//echo '{"insert":"ok"}';
	echo $conn->edit_pregunta($id_pregunta, $campo, $txtPregunta);
}
if(array_key_exists("accion", $_POST) && $_POST['accion']=='edit_respuesta'){	
	$id_pregunta = $_POST['id_pregunta'];
	$campo = $_POST['campo'];
	$txtPregunta = trim($_POST['txtPregunta']);
	//echo '{"insert":"ok"}';
	echo $conn->edit_respuesta($id_pregunta, $campo, $txtPregunta);
}
if(array_key_exists("accion", $_POST) && $_POST['accion']=='del_pregunta_cuest'){	
	$id_pregunta = $_POST['id_pregunta'];
	$id_cuestionario = $_POST['id_cuestionario'];
	//echo '{"insert":"ok"}';
	echo $conn->del_pregunta_cuest($id_pregunta, $id_cuestionario);
}
if(array_key_exists("accion", $_POST) && $_POST['accion']=='ocultar_pregunta_cuest'){	
	$id_pregunta = $_POST['id_pregunta'];
	$id_cuestionario = $_POST['id_cuestionario'];
	//echo '{"insert":"ok"}';
	echo $conn->ocultar_pregunta_cuest($id_pregunta, $id_cuestionario);
}
if(array_key_exists("accion", $_POST) && $_POST['accion']=='visible_pregunta_cuest'){	
	$id_pregunta = $_POST['id_pregunta'];
	$id_cuestionario = $_POST['id_cuestionario'];
	//echo '{"insert":"ok"}';
	echo $conn->visible_pregunta_cuest($id_pregunta, $id_cuestionario);
}

$conn->close_mysqli();
?>