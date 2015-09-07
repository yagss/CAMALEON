<?php 
require_once('../conexion.php');
 

class persona{
	private $id;
	private $nombre;
	private $apellido;
	private $tipodoc;
	private $numdoc;
	private $ciudad;
	private $direccion;
	private $telefono;
	
	public function getID(){
		
		return $this->id;
		}
	public function getNombre(){
		
		return $this->nombre;
		}
	public function getApellido(){
		
		return $this->apellido;
		}
	public function getTipoDoc(){
		
		return $this->tipodoc;
		}
	public function getNumDoc(){
		
		return $this->numdoc;
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
		
	public function __construct($numdoc,$conexion){
		
		$consulta='select * from persona where prn_numdoc=?';	
			$parameter = array(0=>$numdoc);

			$operation = $conexion->select($consulta, $parameter);
			
			if($operation['ejecution']){
				if($operation['result']){
					foreach($operation['result'] as $fila){
						$this->id = $fila['prn_id'];
						$this->nombre = $fila['prn_nombre'];
						$this->apellido = $fila['prn_apellido'];
						$this->tipodoc = $fila['prn_doc'];
						$this->numdoc = $fila['prn_numdoc'];
						$this->ciudad = $fila['prn_cddid'];
						$this->direccion = $fila['prn_dir'];
						$this->telefono = $fila['prn_tel'];
									
					}
				}
			}
		
		}
		
	public static function registrar($id,$nombre,$apellido,$tipodoc,$numdoc,$ciudad,$direccion,$telefono,$conexion){
		
		$consulta='insert into persona values(?,?,?,?,?,?,?,?);';

			$parameter[] = array(
			    0=>$id,
				1=>$nombre,
				2=>$apellido,
				3=>$tipodoc,
				4=>$numdoc,
				5=>$ciudad,
				6=>$direccion,
				7=>$telefono
			);
			
				$parameters[] = array( 'consulta' => $consulta,'parameter' => $parameter,);
				
				
			

			$operation = $conexion->dml($parameters);
		  print_r($operation);
		
		}
		
	public function modificar($nombre,$apellido,$tipodoc,$numdoc,$ciudad,$direccion,$telefono,$conexion){
			
            $consulta='update persona set prn_nombre=?, prn_apellido=?, prn_doc=?, prn_numdoc=?,prn_cddid=?,
			                              prn_dir=?,prn_tel=? where prn_numdoc=?;';

			$parameter[] = array(
				
				0=>$nombre,
				1=>$apellido,
				2=>$tipodoc,
				3=>$numdoc,
				4=>$ciudad,
				5=>$direccion,
				6=>$telefono,
			    7=>$this->numdoc
			);

			$parameters[] = array( 'consulta' => $consulta,'parameter' => $parameter);

			$operation = $conexion->dml($parameters);
			print_r($operation);
			}
			
	 public static function buscar($parametro, $conexion){
		 
		 $consulta='select cargarpersona(?);';
			$parameter= array(0=>$parametro);

			$operation = $conexion->select($consulta, $parameter);
			print_r($operation);
		 
		 } 		
			
	}
   	$conexion = new Conexion();
     
	//persona::registrar('13','JUAN','GABRIEL','cedula','5765','5001','calle10','567865',$conexion);
	  //$persona = new persona('19347',$conexion);
	   //$persona->modificar('Maria','clara','tarjeta','9807065','5042','Trans8','5444334',$conexion);
	 //persona::buscar('r',$conexion);
	   
     


?>