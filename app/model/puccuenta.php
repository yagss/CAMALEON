<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PUC-Cuenta</title>
</head>

<body>
<?php 
require_once('puc.php'); 
require_once('pucgrupo.php');
require_once('conexion.php');


    class PUCCuenta extends PUC{
          private $grupo;	
	
	      public function __construct($id,$conexion){
		     $consulta='select * from cuenta where cnt_id=?';	
		  
			$parameter = array(
			0=>$id
			);

			$operation = $conexion->select($consulta, $parameter);
			if($operation['ejecution']){
				if($operation['result']){
					foreach($operation['result'] as $fila){
				
						$this->id = $fila['cnt_id'];
						$this->nombre = $fila['nombre'];
						$this->descripcion = $fila['descripcion'];
						$this->ajuste =$fila['ajuste'];
						$this->grupo =$fila['cnt_cntgid'];

					}
				}
				
			}
		  }
	
		 
	      public function cargarGrupo($conexion){
		      $grupo=$this->grupo;
		      $this->grupo = new PUCGrupo($grupo,$conexion); 
		
		  }
	      public function getGrupo(){	
	
	          return $this->grupo;
	
	      }
		  
		  public static function listar($id,$conexion){
			  
			  $consulta='select * from cuenta where cnt_cntgid=?';	
		  
			    $parameter = array(
			    0=>$id
			    );

			    $operation = $conexion->select($consulta, $parameter);
			    return $operation;
		 }

	}
	      $conexion = new Conexion;
		//$cuenta = new PUCCuenta('11',$conexion);
//		$cuenta->cargarGrupo($conexion);
//		$grupo = $cuenta->getGrupo();
//		echo $grupo->getClase();
	      //print_r (PUCCuenta::listar('11',$conexion));
	
?>
</body>
</html>