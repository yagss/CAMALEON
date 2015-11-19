<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/conexion.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/log.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/usuario.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/transaccion/transaccion.php');
    session_start();
    if(isset($_SESSION['usuario']) && isset($_SESSION['transaccion']))
    {
    	$usuario = unserialize($_SESSION['usuario']);
    	$transaccion = unserialize($_SESSION['transaccion']);
    	$get = json_decode(file_get_contents('php://input'));
        if(!isset($get->registrar)){$get->registrar=false;}else{$get->registrar = base64_decode($get->registrar);}
        if(!isset($get->loadData)){$get->loadData=false;}
        if(!isset($get->instanciar)){$get->instanciar=false;}
        if(!isset($get->actualizar)){$get->actualizar=false;}
        if(!isset($get->buscar)){$get->buscar=false;}
        //if(!isset($get->borrar)){$get->borrar=false;}
        if($get->registrar)
        {
        	$get->detalle = base64_decode($get->detalle);
			$get->sucursal = base64_decode($get->sucursal);
			$get->req = base64_decode($get->req);
			$get->codtoa = base64_decode($get->codtoa);
			$get->cuenta = base64_decode($get->cuenta);
			$get->debe = base64_decode($get->debe);
			$get->haber = base64_decode($get->haber);
			if ($get->detalle != "" && $get->sucursal != "" && $get->req_tercero != "" && $get->req_activo != "" && $get->codtoa != "" && $get->cuaenta != "" && $get->debe != "" && $get->haber) {
				$conexion = new Conexion();
				$operation = MovimientoContable::registrar($transaccion->getID(), $get->sucursal, $get->detalle, $get->cuaenta, $get->codtoa, $get->req, $get->debe, $get->haber, $conexion);
				if($operation['result']){
					$movimiento = new MovimientoContable($operation['data']['id'], $conexion);
				}
			}else{
				$operation['ejecution'] = true;
                $operation['result'] = false;
              	$operation['message'] = "Por favor diligencie los todos los campos del formulario.";
			}
			echo json_encode($operation);
        }
	}
?>