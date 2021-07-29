<?php
header("Content-type: application/vnd.ms-excel; name='oce'; charset=utf-8"); 
header("Content-Disposition:  filename=\"oce.XLS\";");
include("funciones/conexion_class.php");
 
	$conn = new class_mysqli();
	$id_usr = $_POST['id_usr'];
	$id_cuest = $_POST['id_cuest'];
	$nombre_usr = $_POST['nombre_usr'];
	$cuest = $_POST['cuest'];
	$array = $conn->ver_resp($id_usr, $id_cuest);	
	//echo "<pre>"; print_r($array); echo "</pre>"; 
	if($array == 'no_rows'){
		$tabla = '';
		$tabla_gral = '';
		$tabla .= '<div class="msg_warning"><strong>Sin Registros</strong></div>';
	}else{
		$puntos_ok = 0;
		$puntos_nok = 0;
		$f_puntos_ok = 0;
		$f_puntos_nok = 0;
		$tiempo = 0;
		$factor = 0;
		$subfactor = 0;
		$btn_factor = '<span class="btn btn-success btn-xs btn_f" id="f_todos">Todos</span>&nbsp;';
		$tabla = '<table class="tbl_datos" border="0" width="100%" cellpadding="5" cellspacing="0" id="tbl_respuestas" bgcolor="#FFFFFF">';
		$tabla .= "
		 	<tr  bgcolor='#0066FF' class='txt_blanco negritas'>
				<th width='40' id='th_ambito' >id</th>
				<th width='40'>F</th>
				<th width='40'>Sf</th>
				<th colspan='3'>Pregunta</th>
				<th width='120'>Respuesta</th>
				<th width='120'>ROK</th>
				<th width='120'>Pt</th>
				<th width='120'>Peso</th>
				<th width='120'>Tiempo</th>
				<th width='160'>Fecha</th>
			</tr>";	
		$a_factores = array();		
		$a_subfactores = array();		
		foreach($array['id_reactivos_calif'] as $key=>$nombre){		
			if($array['calif'][$key]=="si") { $puntos_ok ++;  }
			if($array['calif'][$key]=="no") { $puntos_nok ++;  }
					
			if($array['factor'][$key] != $factor){
				$tr_f = 'tr_f_'.$array['factor'][$key]; 
				$btn_factor .= '<span class="btn btn-success btn-xs btn_f" id="'.$tr_f.'"
											factor="'.$array['factor'][$key].'"
											subfactor="'.$array['subfactor'][$key].'"> F'.$array['factor'][$key].'</span>&nbsp;';
				$subfactor = 0; // reiniciar esta variable para que no se confunda con el subfactor del factor anterior
			}
			
			$a_factores[$array['factor'][$key]]['subf'.$array['subfactor'][$key]][$key] = $array['calif'][$key]; 
			
			if($array['subfactor'][$key] == "") $array['subfactor'][$key] = -1;
			
			if($array['subfactor'][$key] != $subfactor){
				$txt_subfactor = $array['subfactor'][$key]; 
				 
				
				if($array['subfactor'][$key] == -1){
					 //$subfactor = $array['subfactor'][$key];
					 $txt_subfactor = "";
				}
				$class_id = 'subf'.$array['factor'][$key];
				$tr_subf = 'tr_subf_'.$array['subfactor'][$key];
				$btn_subfactor .= '<span class="btn btn-warning btn-xs btn_subf '.$class_id.'" 
										 factor="'.$array['factor'][$key].'"
										 subfactor="'.$array['subfactor'][$key].'">F'.$array['factor'][$key].' SF'.$txt_subfactor.' </span>&nbsp;';
			}  
			
			$factor = $array['factor'][$key];
			$subfactor = $array['subfactor'][$key];	
			
			$tiempo += $array['tiempo_contestar'][$key];
			$tabla .= 
			'<tr>
				<td>'.$array['id_reactivos_calif'][$key].'</td>
				<td>'.$array['factor'][$key].'</td>
				<td>'.$txt_subfactor.'</td>
				<td colspan="3">'.$array['pregunta'][$key].'</td>
				<td align="center">'.utf8_encode($array['respuesta'][$key]).'</td>
				<td align="center">'.$array['rok'][$key].'</td>
				<td align="center">'.$array['calif'][$key].'</td>
				<td align="center">'.$array['peso'][$key].'</td>
				<td align="center">'.$array['tiempo_contestar'][$key].'</td>
				<td class="t_size_12">'.$array['fecha'][$key].'</td>
			</tr>';
			
		
		}
		//echo "<pre>"; print_r($a_factores); echo "</pre>";
		foreach($a_factores as $factor => $subfactor){
			if($factor % 2)
				$bgcolor = "#E7E6F5";
			else
				$bgcolor = "#E6F5F5";
			$f_puntos_ok = 0;
			$f_puntos_nok = 0;					
			foreach($subfactor as $key => $array_calif){
				$subf_puntos_ok = 0;
				$subf_puntos_nok = 0;
									
				foreach($array_calif as $id_preg => $calif){
					if($calif == "si") { $subf_puntos_ok ++; $f_puntos_ok ++; }
					if($calif == "no") { $subf_puntos_nok ++; $f_puntos_nok ++; }					
				}
				$tabla_gral .= "<tr bgcolor='$bgcolor'>
					<td align='center'>$factor</td>
					<td align='center'>$key</td>
					<td align='center'>$subf_puntos_ok</td>
					<td align='center'>$subf_puntos_nok</td></tr>";
			}
			$tabla_gral .= "<tr bgcolor='$bgcolor'>
								<th>&nbsp;</th>
								<th align='center'><strong>Total: </strong></th>
								<th align='center'>$f_puntos_ok</th>
								<th align='center'>$f_puntos_nok</th></tr>";
		}
		$tabla .= " ";		
	}
 	//echo $tabla;
	$conn->close_mysqli();
 
?> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  
<?=$tabla?> 
<tr>
	<td colspan="4">  
        <table>
            <tr bgcolor='#0066FF' class='txt_blanco negritas'>
                <th >Factor</th>
                <th >SubFactor</th>
                <th >Pts (+)</th>
                <th >Pts (-)</th>
            </tr>
            <?=$tabla_gral?>
        </table> 
     </td>
</tr>          
 </table> 

