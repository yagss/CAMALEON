<?php
// declaracion de clase conexion
	class Conexion extends PDO{
		//declaracion de atributos privados
		private $sgbd='pgsql';
		private $host='localhost';
        private $port='5432';
		private $db='camaleon';
		private $usuario='cl_user';
		private $password='Server_252';
		//Sobreescribiendo el metodo construtor de la clase PDO
		public function __construct(){
			
			try{
                parent::__construct($this->sgbd.':host='.$this->host.' port='.$this->port.' dbname='.$this->db.' user='.$this->usuario.' password='.$this->password);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				print '¡Error en la conexion a la base de datos!<br>'.$e->getMessage().'<br>';
				die();
			}
            
		}

		/*

			$gbd = new Conexion();

			$consulta = 'INSERT INTO pais (pais_id, pais_nombre) VALUES(?, ?);';
			$parameter[] = array( 
				0 => 3, 
				1 => 'PANAMA',
			);
			
			$parameters[] = array( 
				'consulta' => $consulta,
				'parameter' => $parameter,
			);

			$operation = $gbd->dml($parameters);
			print_r($operation);

		*/

		public function dml($parameters){

			try{		
				$this->beginTransaction();
				for($i=0; $i<count($parameters); $i++){
					$sentencia = $this->prepare($parameters[$i]['consulta']);
					for($j=0; $j<count($parameters[$i]['parameter']); $j++){
						for($k=0; $k<count($parameters[$i]['parameter'][$j]); $k++){
							$sentencia->bindParam(($k+1), $parameters[$i]['parameter'][$j][$k]);
						}
					}
					$sentencia->execute();
				}
				$this->commit();
				if($sentencia->rowCount()>0){
					$operation['result'] = $sentencia->fetch();
				}else{
					$operation['result'] = $sentencia->rowCount();
				}
				$operation['ejecution'] = true;			
			}catch(PDOException $e){
				$this->rollBack();
				$operation['ejecution'] = false;
				$operation['error'] = $e->getMessage();
			}
			return $operation;

		}

		/*

			$consulta = 'SELECT * FROM departamento;';
			$parameter = array();

			$operation = $gbd->select($consulta, $parameter);
			print_r($operation);


		*/

		public function select($consulta, $parameter){

			try{		
				$this->beginTransaction();
				$sentencia = $this->prepare($consulta);
				for($i=0; $i<count($parameter); $i++){$sentencia->bindParam(($i+1), $parameter[$i]);}
				$sentencia->execute();
				if(($sentencia->rowCount())>0){
					while($fila=$sentencia->fetch()){
						$operation['result'][] = $fila;
					}
				}elseif(($sentencia->rowCount())==0){
					$operation['result'] = $sentencia->rowCount();
				}
				$this->commit();
				$operation['ejecution'] = true;			
			}catch(PDOException $e){
				$this->rollBack();
				$operation['ejecution'] = false;
				$operation['error'] = $e->getMessage();
			}
			return $operation;

		}
		
	}

    
?>

