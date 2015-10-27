<?php
	/**
	* @autor : Steven Medina y Juan Camilo Lara
	* @editor : Sublime Text 3
	* @metodo : PHP en el controlador con PDO
	* @descripcion : Desarrollo del controlador en PHP para registrar, modificar, cargar, borrar
	*/

	require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/conexion.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/log.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/usuario.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/terceros/tercero.php');

    session_start();

    if(isset($_SESSION['usuario']))
    {
    	$usuario = unserialize($_SESSION['usuario']);

    	$get = json_decode(file_get_contents('php://input'));
        if(!isset($get->registrar)){$get->registrar=false;}else{$get->registrar = base64_decode($get->registrar);}
        if(!isset($get->loadData)){$get->loadData=false;}
        if(!isset($get->instanciar)){$get->instanciar=false;}
        if(!isset($get->actualizar)){$get->actualizar=false;}
        if(!isset($get->buscar)){$get->buscar=false;}
        //if(!isset($get->borrar)){$get->borrar=false;}

        if($get->registrar)
        {

        	$get->tipo = strtoupper(base64_decode($get->tipo));
            $get->estado = base64_decode($get->estado);
            $get->regimen = base64_decode($get->regimen);

        	$get->nombre = strtoupper(base64_decode($get->nombre));
            $get->apellido = strtoupper(base64_decode($get->apellido));
            $get->tipo_documento = base64_decode($get->tipo_documento);
            $get->numero_documento = base64_decode($get->numero_documento);

			$get->nit = strtoupper(base64_decode($get->nit));
            $get->razon_social = strtoupper(base64_decode($get->razon_social));
            $get->naturaleza = base64_decode($get->naturaleza);
            $get->fecha = base64_decode($get->fecha);

            $get->pais = base64_decode($get->pais);
            $get->departamento = base64_decode($get->departamento);
            $get->ciudad = base64_decode($get->ciudad);
            $get->direccion = base64_decode($get->direccion);
            $get->telefono = base64_decode($get->telefono);
            
        	if($get->tipo == "NATURAL") 
        	{
        		if($get->nombre != "" && $get->apellido != "" && $get->tipo_documento != "" && $get->numero_documento != "" && $get->ciudad != "" && $get->direccion != "" && $get->telefono != "")
        		{

	                $conexion = new Conexion();

	                $operation = Persona::registrar($get->nombre,$get->apellido,$get->tipo_documento,$get->numero_documento,$get->ciudad,$get->direccion,$get->telefono,$conexion);

	                if(($operation['ejecution'])&&($operation['result']))
	                {

	                	$operation = Tercero::registrar($get->numero_documento, $get->tipo, $get->regimen, $get->estado, $conexion);
	                	
	                    $operation['message'] = "Se registro correctamente la información.";
	                   
	                    $log = Log::registro($usuario->getID(), "info", "Registro de información. - Tercero Persona. {".$get->tipo.", ".$get->regimen.", ".$get->estado.", ".$get->nombre.", ".$get->apellido.", ".$get->tipo_documento.", ".$get->numero_documento.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."}", $conexion);  

						$tercero = new Tercero();
						$tercero->instanciarSubID($get->numero_documento, $get->tipo, $conexion);

	                    $_SESSION['tercero'] = serialize($tercero);

	                }
	                elseif(!($operation['ejecution']))
	                {
	                    $log = Log::registro($usuario->getID(), "error", "Registro la información. Tercero Persona. {".$get->tipo.", ".$get->regimen.", ".$get->estado.", ".$get->nombre.", ".$get->apellido.", ".$get->tipo_documento.", ".$get->numero_documento.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."} - {".$operation['error']."}", $conexion);
	                }
	            }
	            else
	            {
	                $operation['ejecution'] = true;
	                $operation['result'] = false;
	              	$operation['message'] = "Por favor diligencie los todos los campos del formulario.";
	            }
        	}
        	else 
        	{
        		if($get->nit != "" && $get->razon_social != "" && $get->pais != "" && $get->departamento != "" && $get->ciudad != "" && $get->direccion != "" && $get->telefono != "")
        		{

	                $conexion = new Conexion();

	                $operation = Empresa::registrar($get->nit, $get->razon_social, $get->naturaleza, $get->fecha, $get->ciudad, $get->direccion, $get->telefono, $conexion);

	                if(($operation['ejecution']) && ($operation['result']))
	                {
	          
	                	$operation = Tercero::registrar($get->nit, $get->tipo, $get->regimen, $get->estado, $conexion);

	                    $operation['message'] = "Se registro correctamente la información.";
	                   
	                    $log = Log::registro($usuario->getID(), "info", "Registro de información. - Tercero Empresa. {".$get->tipo.", ".$get->regimen.", ".$get->estado.", ".$get->nit.", ".$get->razon_social.", ".$get->naturaleza." , ".$get->fecha.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."}", $conexion); 

						$tercero = new Tercero();
						$tercero->instanciarSubID($get->nit, $get->tipo, $conexion);

	                    $_SESSION['tercero'] = serialize($tercero);

	                }
	                elseif(!($operation['ejecution']))
	                {
	                    $log = Log::registro($usuario->getID(), "error", "Registro la información. Tercero Empresa. {".$get->nit.", ".$get->razon_social.", ".$get->naturaleza." , ".$get->fechaconst.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."} - {".$operation['error']."}", $conexion);
	                }
	            }
	            else
	            {
	                $operation['ejecution'] = true;
	                $operation['result'] = false;
	                $operation['message'] = "Por favor diligencie los todos los campos del formulario.";
	            }
        	}

            echo json_encode($operation);
        }

        if ($get->loadData)
        {
        	if(isset($_SESSION['tercero'])) 
        	{

				$tercero = unserialize($_SESSION['tercero']);
				$data['id_t'] = $tercero->getId();
        		$data['regimen'] = $tercero->getRegimen();
				$data['tipo'] = $tercero->getTipo();
				$data['gc'] = $tercero->getGC();
	    		if($tercero->getTipo() == "NATURAL")
				{
					$persona = $tercero->getPersona();

					$data['id'] = $persona->getID();
					$data['nombre'] = $persona->getNombre();
					$data['apellido'] = $persona->getApellido();
					$data['tipo_documento'] = $persona->getTipoDoc();
					$data['numero_documento'] = $persona->getNumDoc();
					$ciudad = $persona->getCiudad();
					$data['idCiudad'] = $ciudad->getID();
					$data['nomCiudad'] = $ciudad->getNombre();
					$departamento = $ciudad->getDepartamento();
					$data['idDepartamento'] = $departamento->getID();
					$data['nomDepartamento'] = $departamento->getNombre();
					$pais = $departamento->getPais();
					$data['idPais'] = $pais->getID();
					$data['nomPais'] = $pais->getNombre();		
					$data['direccion'] = $persona->getDireccion();
					$data['telefono'] = $persona->getTelefono();

	    		}
	    		elseif($tercero->getTipo() == "JURIDICA")
	    		{
	    		 	$empresa = $tercero->getEmpresa();

	    		 	$data['id'] = $empresa->getID(); 
	    		 	$data['nit'] = $empresa->getNit();
					$data['razon_social'] = $empresa->getRazonSocial();
					$data['naturaleza'] = $empresa->getNaturaleza();
					$data['fechaconst'] = $empresa->getFechaconst();
					$ciudad = $empresa->getCiudad();
					$data['idCiudad'] = $ciudad->getID();
					$data['nomCiudad'] = $ciudad->getNombre();
					$departamento = $ciudad->getDepartamento();
					$data['idDepartamento'] = $departamento->getID();
					$data['nomDepartamento'] = $departamento->getNombre();
					$pais = $departamento->getPais();
					$data['idPais'] = $pais->getID();
					$data['nomPais'] = $pais->getNombre();		
					$data['direccion'] = $empresa->getDireccion();
					$data['telefono'] = $empresa->getTelefono();

	                
	    		}

	    		$operation['ejecution'] = true;
                $operation['result'] = true;
                $operation['message'] = "Se cargo correctamente la información";
                $operation['data'] = $data;

                echo json_encode($operation);
        	}
        }

        if ($get->actualizar) 
        {

            $get->estado = base64_decode($get->estado);
            $get->regimen = base64_decode($get->regimen);

        	$get->nombre = strtoupper(base64_decode($get->nombre));
            $get->apellido = strtoupper(base64_decode($get->apellido));
            $get->tipo_documento = base64_decode($get->tipo_documento);
            $get->numero_documento = base64_decode($get->numero_documento);

			$get->nit = strtoupper(base64_decode($get->nit));
            $get->razon_social = strtoupper(base64_decode($get->razon_social));
            $get->naturaleza = base64_decode($get->naturaleza);
            $get->fecha = base64_decode($get->fecha);

            $get->pais = base64_decode($get->pais);
            $get->departamento = base64_decode($get->departamento);
            $get->ciudad = base64_decode($get->ciudad);
            $get->direccion = base64_decode($get->direccion);
            $get->telefono = base64_decode($get->telefono);

        	if(isset($_SESSION['tercero'])) 
        	{

        		$tercero = unserialize($_SESSION['tercero']);

        		if($tercero->getTipo() == "NATURAL") 
        		{
        			$persona = $tercero->getPersona();

        			if($get->nombre != "" && $get->apellido != "" && $get->tipo_documento != "" && $get->numero_documento != "" && $get->ciudad != "" && $get->direccion != "" && $get->telefono != "")
        			{

		                $conexion = new Conexion();

		                $operation = $persona->modificar($get->nombre,$get->apellido,$get->tipo_documento,$get->numero_documento,$get->ciudad,$get->direccion,$get->telefono,$conexion);
		                
		                if(($operation['ejecution'])&&($operation['result']))
		                {
		                	
		                	$operation = $tercero->modificar($tercero->getTipo(), $get->regimen, $get->estado, $conexion);
		                	
		                    $operation['message'] = "Se actualizó correctamente la información.";
		                   
		                    $log = Log::registro($usuario->getID(), "info", "Actualización de información. - Tercero Persona. {".$tercero->getTipo().", ".$get->regimen.", ".$get->estado.", ".$get->nombre.", ".$get->apellido.", ".$get->tipo_documento.", ".$get->numero_documento.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."}", $conexion);

		                    $id = $tercero->getID();
		                    $tipo = $tercero->getTipo();
							
							$tercero = new Tercero();
							$tercero->instanciarID($id, $conexion);

		                    $_SESSION['tercero'] = serialize($tercero);
	                	}
		                elseif(!($operation['ejecution']))
		                {
		                    $log = Log::registro($usuario->getID(), "error", "Actualización de la información. Tercero Persona. {".$tercero->getTipo().", ".$get->regimen.", ".$get->estado.", ".$get->nombre.", ".$get->apellido.", ".$get->tipo_documento.", ".$get->numero_documento.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."} - {".$operation['error']."}", $conexion);
		                }
		            }
		            else
		            {
		                $operation['ejecution'] = true;
		                $operation['result'] = false;
		              	$operation['message'] = "Por favor diligencie los todos los campos del formulario.";
		            }
	        	}
	        	else 
	        	{

	        		$empresa = $tercero->getEmpresa();

	        		if($get->nit != "" && $get->razon_social != "" && $get->pais != "" && $get->departamento != "" && $get->ciudad != "" && $get->direccion != "" && $get->telefono != "")
	        		{

		                $conexion = new Conexion();

		                $operation = $empresa->modificar($get->nit, $get->razon_social, $get->naturaleza, $get->fecha, $get->ciudad, $get->direccion, $get->telefono, $conexion);

		                if(($operation['ejecution']) && ($operation['result']))
		                {

		                	$operation = $tercero->modificar($tercero->getTipo(), $get->regimen, $get->estado, $conexion);

		                    $operation['message'] = "Se actualizó correctamente la información.";
		                   
		                    $log = Log::registro($usuario->getID(), "info", "Actualización de información. - Tercero Empresa. {".$tercero->getTipo().", ".$get->regimen.", ".$get->estado.", ".$get->nit.", ".$get->razon_social.", ".$get->naturaleza." , ".$get->fecha.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."}", $conexion); 

		                  	$id = $tercero->getID();
		                    $tipo = $tercero->getTipo();

							$tercero = new Tercero();
							$tercero->instanciarID($id, $conexion);

		                    $_SESSION['tercero'] = serialize($tercero);

		                }
		                elseif(!($operation['ejecution']))
		                {

		                    $log = Log::registro($usuario->getID(), "error", "Actualización la información. Tercero Empresa. {".$tercero->getTipo().", ".$get->regimen.", ".$get->estado.", ".$get->nit.", ".$get->razon_social.", ".$get->naturaleza." , ".$get->fecha.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."} - {".$operation['error']."}", $conexion);
		                }
		            }
		            else
		            {
		                $operation['ejecution'] = true;
		                $operation['result'] = false;
		                $operation['message'] = "Por favor diligencie los todos los campos del formulario.";
		            }
	        	}

            echo json_encode($operation);

        	}
        }

        if ($get->buscar) 
        {

        	$conexion = new Conexion();

        	$get->parametro = strtoupper(base64_decode($get->parametro));

        	$operation = Tercero::buscar($get->parametro, $conexion);

	        if(count($operation['result'])==1)
        	{
	            $operation['message'] = "Se encontro ".count($operation['result'])." registro.";
	        }
	        elseif(count($operation['result'])>1)
        	{
	            $operation['message'] = "Se encontraron ".count($operation['result'])." registros.";
	        }
	        else
	       	{
	            $operation['message'] = "No se encuentran registros con los parametros ingresados.";
	        }

            echo json_encode($operation);

        }

        if ($get->instanciar) 
        {
        	$get->tipo = base64_decode($get->tipo);
        	
        	$conexion =new Conexion();

        	if ($get->tipo == "NATURAL") {

        		$get->numero_documento =  base64_decode($get->numero_documento);

				$tercero = new Tercero(); 
				$tercero->instanciarSubID($get->numero_documento, $get->tipo, $conexion);

        		$_SESSION['tercero'] = serialize($tercero);
        		$persona = $tercero->getPersona();

        		$operation['message'] = "Se cargo correctamente la información.";

        	}else if($get->tipo == "JURIDICA"){

        		$get->nit =  base64_decode($get->nit);

				$tercero = new Tercero();
				$tercero->instanciarSubID($get->nit, $get->tipo, $conexion);

				$_SESSION['tercero'] = serialize($tercero);
				$empresa = $tercero->getEmpresa();

				$operation['message'] = "Se cargo correctamente la información.";

        	}

        	$operation["ejecution"] = true;
        	$operation['result'] = true;
        	
          	echo json_encode($operation);
        }
    }

?>