
<?php 

	//require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/conexion.php');

	require_once('pucsubcuenta.php');

	class PUCCuentaAuxiliar extends PUC{

		private $reqta;
		private $estado;
		private $subcuenta;

		public function __construct($id, $conexion){

			$consulta='select * from cuenta_auxiliar where cntaux_id=?';	
			$parameter = array(0=>$id);

			$operation = $conexion->select($consulta, $parameter);

			if($operation['ejecution']){
				if($operation['result']){
					foreach($operation['result'] as $fila){
						$this->id = $fila['cntaux_id'];
						$this->nombre = $fila['nombre'];
						$this->descripcion = $fila['descripcion'];
						$this->ajuste =$fila['ajuste'];
						$this->reqestado =$fila['reqestado'];
						$this->reqta =$fila['reqta'];
						$this->subcuenta =$fila['cntaux_scntid'];
					}
				}
			}

		}

		public function cargarSubcuenta($conexion){
			$subcuenta = $this->subcuenta;
			$this->subcuenta = new PUCSubcuenta($subcuenta, $conexion);
		}

		public function getReqTA(){
			return $this->reqta;
		}

		public function getEstado(){
			return $this->estado;
		}

		public function getSubcuenta(){
			return $this->subcuenta;
		}

		public static function registrar($nombre, $descripcion, $ajuste, $reqta, $reqestado, $subcuenta, $id, $conexion){

			$consulta='insert into cuenta_auxiliar values(?,?,?,?,?,?,?);';

			$parameter[] = array(
				0=>$nombre,
				1=>$descripcion,
				2=>$ajuste,
				3=>$reqta,
				4=>$reqestado,
				5=>$subcuenta,
				6=>$id
			);

			$parameters[] = array( 'consulta' => $consulta,'parameter' => $parameter,);

			$operation = $conexion->dml($parameters);
			return $operation;

		}


		public static function buscar($parametro, $conexion){

			$consulta='select buscarCuentaAuxiliar(?);';
			$parameter= array(0=>$parametro);

			$operation = $conexion->select($consulta, $parameter);
			return $operation;

		} 

		public function actualizar($nombre, $descripcion, $ajuste, $reqta, $reqestado, $subcuenta, $id, $conexion){

			$consulta='update cuenta_auxiliar set nombre=?, descripcion=?, ajuste=?, reqta=?, reqestado=?, cntaux_scntid=?, cntaux_id=? where cntaux_id=?;';
			$parameter[] = array(
				0=>$nombre,  
				1=>$descripcion,
				2=>$ajuste,
				3=>$reqta,
				4=>$reqestado,
				5=>$subcuenta,
				6=>$id, 
				7=>$this->id,
			);

			$parameters[] = array('consulta' => $consulta, 'parameter' => $parameter);

			$operation = $conexion->dml($parameters);

			if($operation['result']){PUCCuentaAuxiliar($id, $conexion);}

			return $operation;

		} 

		public static function listar($id, $conexion){

			$consulta='select * from cuenta_auxiliar where cntaux_scntid=?';	
			$parameter = array(0=>$id);

			$operation = $conexion->select($consulta, $parameter);
			return $operation;

		}	

	}

	//$conexion = new Conexion();
	//$operation = PUCCuentaAuxiliar::registrar('BANCOLOMBIA','CUENTA DE AHORROS NUMERO 123456789','MENSUAL','1','1','112005','11200501', $conexion);
	//$operation = PUCCuentaAuxiliar::buscar('B',$conexion);
	//$operation = PUCCuentaAuxiliar::listar('112005',$conexion);
	//$cuenta = new PUCCuentaAuxiliar('11200501', $conexion);
	//$operation = $cuenta->actualizar('BANCO CAJA SOCIAL','CUENTA CORRIENTE NUMERO 123456789','ANUAL','1','1','112005','11200501', $conexion);
	//print_r($operation);

?>