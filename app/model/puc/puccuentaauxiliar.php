
<?php 

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

			$operation = $conexion->dml($consulta, $parameter);
			return $operation;

		}


		public static function buscar($parametro, $conexion){

			$consulta='select cargarcuenta2(?);';
			$parameter= array(0=>$parametro);

			$operation = $conexion->select($consulta, $parameter);
			return $operation;

		} 

		public function actualizaTodo($nombre, $descripcion, $ajuste, $reqta, $reqestado, $conexion){

			$consulta='update cuenta_auxiliar set nombre=?, descripcion=?, ajuste=?, reqta=?, reqestado=? where cntaux_id=?;';
			$parameter[] = array(
				0=>$nombre,  
				1=>$descripcion,
				2=>$ajuste,
				3=>$reqta,
				4=>$reqestado, 
				5=>$this->id,
			);

			$parameters[] = array('consulta' => $consulta, 'parameter' => $parameter);

			$operation = $conexion->dml($consulta, $parameter);
			return $operation;

		} 

		public static function listar($id, $conexion){

			$consulta='select * from cuenta_auxiliar where cntaux_scntid=?';	
			$parameter = array(0=>$id);

			$operation = $conexion->select($consulta, $parameter);
			return $operation;

		}	

	}
	  
?>