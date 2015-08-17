<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PUC-Grupo</title>
</head>

<body>
<?php 
require_once('puc.php');
require_once('pucclase.php');
require_once('conexion.php');

	class PUCGrupo extends PUC{
	 
	 private $clase;
	
	 
	 public function __construct($id,$conexion){
		 $consulta='select * from cuenta_grupo where cntg_id=?';	
		  
			$parameter = array(
			0=>$id
			);

			$operation = $conexion->select($consulta, $parameter);
			if($operation['ejecution']){
				if($operation['result']){
					foreach($operation['result'] as $fila){
				
						$this->id = $fila['cntg_id'];
						$this->nombre = $fila['nombre'];
						$this->descripcion = $fila['descripcion'];
						$this->ajuste =$fila['ajuste'];
						$this->clase =$fila['cntg_cntcid'];

					}
				}
				
			}
     }
		 
		 
		 
		 
	 public function cargarClase($conexion){

		$clase=$this->clase;
		$this->clase = new PUCClase($clase,$conexion); 
		 
		 }
	
	public function getClase(){
		 return $this->clase;
		 
		 }
		 
	public static function listar($id,$conexion){
		$consulta='select * from cuenta_grupo where cntg_cntcid=?';	
		  
			$parameter = array(
			0=>$id
			);

			$operation = $conexion->select($consulta, $parameter);
			return $operation;
		}	 
	}
	
       		
			$conexion = new Conexion;
		//$grupo = new PUCGrupo('11',$conexion);
		//$grupo->cargarClase($conexion);
		//$clase = $grupo->getClase();
		//echo $clase->getNaturaleza();
         //print_r (PUCGrupo::listar('1',$conexion));


?>
</body>
</html>