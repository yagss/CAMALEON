<?php

	class Usuario{
		
		private $id;
		private $nombre;
		private $rol;
		private $estado;
		private $clave;

		public function __construct(){
			$this->clave = "=zE9#5Dk&Ls0!Q7f?(Xz8+)";
		}

		public function getID(){
			return $this->id;
		}

		public function getNombre(){
			return $this->nombre;
		}

		public function getEstado(){
			return $this->estado;
		}

		public function autenticar($nombre, $conexion){
					
			$consulta = 'SELECT usr_id, usr_nombre, usr_estado, rolusr_nombre FROM usuario INNER JOIN rol_usuario ON(usr_rolusrid=rolusr_id) WHERE usr_nombre=?;';
			$parameter = array(0 => $nombre,);

			$operation = $conexion->select($consulta, $parameter);

			if($operation['ejecution']){
				if($operation['result']){ 
					foreach($operation['result'] as $fila){
						$this->id = $fila['usr_id'];
						$this->nombre = $fila['usr_nombre'];
						$this->rol = $fila['rolusr_nombre'];
						$this->estado = $fila['usr_estado'];
					}
					$operation['result'] = true;
				}
			}

			return $operation;

		}
		
		public function verificarPassword($password, $conexion){

			$consulta = 'SELECT verificarPassword(?, ?);';
			$parameter = array(0 => $this->id, 1 => crypt($password, $this->clave));

			$operation = $conexion->select($consulta, $parameter);

			if($operation['ejecution']){
				if($operation['result']){ 
					foreach($operation['result'] as $fila){
						$operation['result'] = $fila['result'];
					}
				}
			}

			return $operation;

		}

	}

?>