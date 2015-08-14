<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subcuenta</title>
</head>

<body>
<?php 
require_once('puc.php'); 
require_once('puccuenta.php'); 
require_once('conexion.php'); 
 
      class PUCSubcuenta extends PUC{
       
	        private $cuenta;

        public function __construct($id,$conexion){
		   $consulta='select * from subcuenta where scnt_id=?';	
		  
			$parameter = array(
			0=>$id
			);

			$operation = $conexion->select($consulta, $parameter);
			if($operation['ejecution']){
				if($operation['result']){
					foreach($operation['result'] as $fila){
				
						$this->id = $fila['scnt_id'];
						$this->nombre = $fila['nombre'];
						$this->descripcion = $fila['descripcion'];
						$this->ajuste =$fila['ajuste'];
						$this->cuenta =$fila['scnt_cntid'];

					}
				}
				
			}
		    }
			
			
		public function cargarCuenta($conexion){
			$cuenta = $this->cuenta;
			$this->cuenta = new PUCCuenta($cuenta,$conexion); 
		
			}	
		
			
		public function getCuenta(){
			 
		  return $this->cuenta;
			
			}
			
			
		 public static function listar($id,$conexion){
			  
			  $consulta='select * from subcuenta where scnt_cntid=?';	
		  
			    $parameter = array(
			    0=>$id
			    );

			    $operation = $conexion->select($consulta, $parameter);
			    return $operation;
		 }	
			
			
            }
                  $conexion = new Conexion;
		//$cuenta = new PUCSubcuenta('1105',$conexion);
       	//$cuenta->cargarGrupo($conexion);
		//$grupo = $cuenta->getGrupo();
		//echo $grupo->getClase();
	      //print_r (PUCSubcuenta::listar('1105',$conexion));


?>
</body>
</html>