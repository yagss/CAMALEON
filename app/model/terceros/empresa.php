<?php 
require_once('../conexion.php');

class empresa{
	private $id; 
	private $nit;
	private $razonsocial;
	private $naturaleza;
	private $fechaconst;
	private $ciudad; 
	private $direccion; 
	private $telefono;
	
	public function getID(){
		
		return $this->id;
		}
	public function getNit(){
		
		return $this->nit;
		}
	public function getRazonSocial(){
		
		return $this->razonsocial;
		}
		
		
	public function getCiudad(){
		
		$ciudad = $this->ciudad;
	            $this->ciudad = new ciudad();
		}
	public function getDireccion(){
		
		return $this->direccion;
		}
	public function getTelefono(){
		
		return $this->telefono;
		}
		public function __construct($nit,$conexion){
				
			$consulta='select * from empresa where empr_nit=?';	
			$parameter = array(0=>$nit);

			$operation = $conexion->select($consulta, $parameter);
			
			if($operation['ejecution']){
				if($operation['result']){
					foreach($operation['result'] as $fila){
						$this->id = $fila['empr_id'];
						$this->nit = $fila['empr_nit'];
						$this->naturaleza = $fila['empr_naturaleza'];
						$this->fecha = $fila['empr_fechaconst'];
						$this->razonsocial = $fila['empr_rs'];
						$this->ciudad = $fila['empr_cddid'];
						$this->direccion = $fila['empr_dir'];
						$this->telefono = $fila['empr_tel'];
					}
				}
			}
			
			
			}
		public static function registrar($nit,$razonsocial,$naturaleza,$fechacont,$ciudad,$direccion,$telefono,$conexion){
		
			$consulta='insert into empresa (empr_nit,empr_rs,empr_naturaleza,empr_fechaconst,empr_cddid,empr_dir,empr_tel)values (?,?,?,?,?,?,?);';

			$parameter[] = array(
			
				0=>$nit,
				1=>$razonsocial,
				2=>$naturaleza,
				3=>$fechacont,
				4=>$ciudad,
				5=>$direccion,
				6=>$telefono
			);

			$parameters[] = array( 'consulta' => $consulta,'parameter' => $parameter,);

			$operation = $conexion->dml($parameters);
			print_r($operation);
		}
		
		public function modificar($naturaleza,$fechaconst,$razonsocial,$ciudad,$direccion,$telefono,$nit,$conexion){
			
            $consulta='update empresa set empr_naturaleza=?, empr_fechaconst=?, empr_rs=?, empr_cddid=?,
			                             empr_dir=?,empr_tel=? where empr_nit=?;';

			$parameter[] = array(
				
				0=>$naturaleza,
				1=>$fechaconst,
				2=>$razonsocial,
				3=>$ciudad,
				4=>$direccion,
				5=>$telefono,
			    6=>$this->nit
			);

			$parameters[] = array( 'consulta' => $consulta,'parameter' => $parameter);

			$operation = $conexion->dml($parameters);
			print_r($operation);
			}
			
			public static function buscar($parametro, $conexion){
		 
		 $consulta='select cargarempresa(?);';
			$parameter= array(0=>$parametro);

			$operation = $conexion->select($consulta, $parameter);
			print_r($operation);
		 
		 } 
	}
	
	$conexion = new Conexion();
	//empresa::registrar('1020','razon social','debito','2015/04/04','5001','calle100','570',$conexion);
	//$empresa = new empresa('1020',$conexion);
    //$empresa->modificar('Credito','12/05/06','Vender cosas','5030','Trans8','5646567','1020',$conexion);
    //empresa::buscar('1',$conexion);





?>