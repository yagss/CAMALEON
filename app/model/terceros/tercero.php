<?php 
require_once('../conexion.php');
require_once('persona.php');
require_once('empresa.php');

class tercero{
	private $id;
	private $tipo;
	private $regimen;
	private $gc; 
	private $empresa; 
	private $persona;
	
    public function getId(){
		
		return $this->id;
		
		}
	public function getTipo(){
		
		return $this->tipo;
		
		}
	public function getRegimen(){
		
		return $this->regimen;
		}
		
    public function getGC(){
		
		return $this->gc;
		}
	
	public function getEmpresa(){
		 
		$empresa = $this->empresa;
			$this->empresa = new empresa();
		
		}
		
	public function getPersona(){
		$persona = $this->persona;
		$this->persona = new persona();
		
		}	
		
		public function __construct($id,$conexion){
				
			$consulta='select * from tercero where trc_id=?';	
			$parameter = array(0=>$id);

			$operation = $conexion->select($consulta, $parameter);
			
			if($operation['ejecution']){
				if($operation['result']){
					foreach($operation['result'] as $fila){
						$this->id = $fila['trc_id'];
						$this->tipo = $fila['trc_tipo'];
						$this->regimen = $fila['trc_regimen'];
						$this->gc = $fila['trc_gc'];
						
					}
				}
			}
		}
		public static function registrar($tipo,$regimen,$gc,$conexion){
		
			$consulta='insert into tercero (trc_tipo, trc_regimen, trc_gc)values(?,?,?);';

			$parameter[] = array(
				
				0=>$tipo,
				1=>$regimen,
				2=>$gc,
				);

			$parameters[] = array( 'consulta' => $consulta,'parameter' => $parameter);

			$operation = $conexion->dml($parameters);
			print_r($operation);
		}
	
	public function modificar($id,$tipo,$regimen,$gc,$conexion){
			
            $consulta='update tercero set trc_id=?, trc_tipo=?, trc_regimen=?, trc_gc=?
			                             where trc_id=?;';

			$parameter[] = array(
				
				0=>$id,
				1=>$tipo,
				2=>$regimen,
				3=>$gc,
			    4=>$this->id
			);

			$parameters[] = array( 'consulta' => $consulta,'parameter' => $parameter);

			$operation = $conexion->dml($parameters);
			print_r($operation);
			}
		
	public static function buscar($parametro, $conexion){
		 
		 $consulta='select cargartercero(?);';
			$parameter= array(0=>$parametro);

			$operation = $conexion->select($consulta, $parameter);
			print_r($operation);
		 
		 }  
	
	}
      $tercero = new Conexion();
	  tercero::registrar('persona','Sub','true',$conexion);
      //$tercero = new tercero('1010',$conexion);
	  //$tercero->modificar('1010','Persona','Sancionatorio','false',$conexion);
	  //tercero::buscar('1',$conexion);
	  







?>