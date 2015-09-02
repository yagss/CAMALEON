<?php 

	require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/puc/puccuenta.php'); 
 
	class PUCSubcuenta extends PUC{

		private $cuenta;

		public function __construct($id,$conexion){
		
			$consulta='select * from subcuenta where scnt_id=?';	
			$parameter = array(0=>$id);

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
			$parameter = array(0=>$id);

			$operation = $conexion->select($consulta, $parameter);
			return $operation;

		}

	}

?>