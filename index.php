<?php
header('Access-Control-Allow-Origin: *');
$request_method = $_SERVER['REQUEST_METHOD'];

$url = $_GET['url'];

require("./clases/gpsDataClass.php");

$gps = new gpsData();

if(isset($_GET['url'])){
	if($request_method == "GET"){

		$url = $_GET['url'];

		$commands = explode("/",$url);

        $type = $commands[0];
        switch ($type) {
			case 'getGpsData':
                header('Content-Type: application/json');
                echo($gps->getGpsData());
                break; 
        	case 'saveGpsData':
            // /5133.81 N/00042.25 W/0.090/14:30:42/25-08-2005
                $lon = $commands[1];
                $lat = $commands[2];
                $vel = $commands[3];
                $time = $commands[4];
                $date = $commands[5];

                $res = $gps->saveGpsData($lon, $lat, $vel,$date."_".$time);

                $resArray = json_decode($res, true);

                if($resArray['register'] == "success"){
                    http_response_code(200);
                }else{
                    http_response_code(400);
                }
                break;
            default:
            echo("
            <p>Esta api está destinada a la prueba de ingreso al departamento de I+D Cotecmar <br>
                <br>
                Fué constuida con la intención de agregar funciones a la prueba.
                <br><br>Escrita por <b>Cristian Valdez</b> <br><br>
                A continuación se describe la meta-data
                <ol>
                    <li><b>saveGpsData</b><br> Registra los datos en la base de datos: <br><br>/longitud/latitud/velocidad/hora/fecha<br><br> <b>Ejemplo:https://apipruebacotecmar.cvrelectronica.com/saveGpsData/5133.81 N/00042.25 W/0.090/14:30:42/25-08-2005 </b></li><br><br>
                    <li><b>getGpsData</b><br> Retorna un JSON con los datos registrados en la base de datos: <b>Ejemplo: https://apipruebacotecmar.cvrelectronica.com/getGpsData/</b></li>
                </ol>
            </p>
            ");
        }		
	}
	
}else{
    echo("
        <p>Esta api está destinada a la prueba de ingreso al departamento de I+D Cotecmar <br>
            <br>
            Fué constuida con la intención de agregar funciones a la prueba.
            <br><br>Escrita por <b>Cristian Valdez</b> <br><br>
            A continuación se describe la meta-data
            <ol>
                <li><b>saveGpsData</b><br> Registra los datos en la base de datos: <br><br>/longitud/latitud/velocidad/hora/fecha<br><br> <b>Ejemplo:https://apipruebacotecmar.cvrelectronica.com/saveGpsData/5133.81 N/00042.25 W/0.090/14:30:42/25-08-2005 </b></li><br><br>
                <li><b>getGpsData</b><br> Retorna un JSON con los datos registrados en la base de datos: <b>Ejemplo: https://apipruebacotecmar.cvrelectronica.com/getGpsData/</b> <br><br> Estos datos pueden ser consumidos desde cualquier aplicación para su posterior analisis</li>
            </ol>
        </p>
    ");
}

?>