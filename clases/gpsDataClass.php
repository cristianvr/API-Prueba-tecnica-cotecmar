<?php
class gpsData
{
	private $conexion=false;
	function __construct($datos_conexion = false)
	{
		if(!$datos_conexion){
			$server = gethostbyname("www.cvrelectronica.com");
			$username='**********';
			$password='**********';
			$db='**********';

			$this->conexion= new mysqli($server,$username,$password,$db);
			if($this->conexion->connect_errno){
				echo($this->conexion->connect_error);
			}else{
				$this->conexion->set_charset("utf8");
				//echo("conexion completa!");
			}
		}
	}

	function getGpsData(){ 
        $query = "SELECT * FROM gps_cotecmar";
                
        $result = $this->conexion->query($query);
        if($result->num_rows > 0){
            $data = array();
            while($f = $result->fetch_assoc()){
                array_push($data, $f);
            }
            return json_encode($data);
        }else{
            return '{"result":"no data"}';
        }
    }

    function saveGpsData($lon, $lat, $vel, $date){
        $res = $this->conexion->query("INSERT INTO gps_cotecmar (longitud, latitud, velocidad,fecha_hora) 
                                                                VALUES ('$lon', '$lat', '$vel', '$date')");
        if($this->conexion->affected_rows > 0){
            return '{"register":"success"}';
        }else{
            return '{"register":"fail"}';
        }
    }

}

?>