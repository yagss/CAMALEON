<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PUC-Cuenta-Auxiliar</title>
</head>

<body>
<?php 
require_once('puc.php');
require_once('pucsubcuenta.php');
require_once('conexion.php');
	class PUCCuentaAuxiliar extends PUC{
		
		private $reqta;
		private $estado;
		private $subcuenta;
		
		public function __construct($id,$conexion){
			 $consulta='select * from cuenta_auxiliar where cntaux_id=?';	
		  
			$parameter = array(
			0=>$id
			);

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
			$this->subcuenta = new PUCSubcuenta($subcuenta,$conexion);
			
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
			
		public static function registrar($nombre,$descripcion,$ajuste,$reqta,$reqestado,$subcuenta,$id){
		
		//	$consulta = 'select cntaux_id from cuenta_auxiliar where cntaux_id=?;';
//			if ($consulta=true){
//			$parameter = array(
//			0=>$id
//			);
//
//			$operation = $gbd->select($consulta, $parameter);
			
				$gbd = new Conexion();
					
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
				
					$parameters[] = array( 
				'consulta' => $consulta,
				'parameter' => $parameter,
			     );

			$operation = $gbd->dml($parameters);
			print_r($operation);
			
		}
			
			
		public static function buscar($parametro,$conexion){
		$gbd = new Conexion();
		
		$consulta='select cargarcuenta2(?);';
		$parameter= array(
		0=>$parametro
		);
		
			$operation = $gbd->select($consulta, $parameter);
			 
			print_r($operation);
	
			} 
			
			
			
		public function actualizaTodo($nombre,$descripcion,$ajuste,$reqta,$reqestado){
					
			$gbd = new Conexion();
						
			$consulta='update cuenta_auxiliar set nombre=?, descripcion=?, ajuste=?, reqta=?, reqestado=? where cntaux_id=?;';
			 $parameter[] = array(
			   
			   
				0=>$nombre,  
				1=>$descripcion,
				2=>$ajuste,
				3=>$reqta,
				4=>$reqestado, 
				5=>$this->id,
			    );
				
					$parameters[] = array( 
				'consulta' => $consulta,
				'parameter' => $parameter,
			     );
                				
			        $operation = $gbd->dml($parameters);
			
			
			} 
			
	//	public static function actualizaEstado($conexion){
//			
//			$consulta='update cuenta_auxiliar set reqestado=?';
//			 $parameter = array(
//				0=>$id,
//			    );
//				
//					$parameters[] = array( 
//				'consulta' => $consulta,
//				'parameter' => $parameter,
//			     );
//
//			$operation = $gbd->dml($parameters);
//			print_r($operation);
//			} 
			
		public static function listar($id,$conexion){
			
			$consulta='select * from cuenta_auxiliar where cntaux_scntid=?';	
		  
			    $parameter = array(
			    0=>$id
			    );

			    $operation = $conexion->select($consulta, $parameter);
			    return $operation;
				
			}	
			
		}
		 $conexion = new Conexion;
		 //$subcuenta = new PUCCuentaAuxiliar('110505',$conexion);
         //$subcuenta->cargarGrupo($conexion);
		 //$grupo = $subcuenta->getGrupo();
		 //echo $grupo->getCuenta();
	     // print_r (PUCCuentaAuxiliar::listar('110505',$conexion));
		  
		//PUCCuentaAuxiliar::registrar('Camila','Esta es la cuenta auxiliar para calvear al mechudo','MENSUAL','TRUE','TRUE','110505','11050515',$conexion);
       //$actualiza = new PUCCuentaAuxiliar('11050505',$conexion);
          //$actualiza->actualizaTodo('PERRA TONTA','La pichona esta gorda y es fea','MENSUAL','TRUE','TRUE');
	  PUCCuentaAuxiliar::buscar('1',$conexion);
	  
?>
</body>
</html>