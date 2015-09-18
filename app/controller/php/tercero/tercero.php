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
    require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/terceros/persona.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/app/model/terceros/empresa.php');

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
        	if(base64_decode($get->tipo) == "natural") 
        	{
        		if($get->nombre != "" && $get->apellido != "" && $get->tipo_documento != "" && $get->numero_documento != "" && $get->pais != "" && $get->departamento != "" && $get->ciudad != "" && $get->direccion != "" && $get->telefono != "")
        		{
	                $get->nombre = strtoupper(base64_decode($get->nombre));
	                $get->apellido = strtoupper(base64_decode($get->apellido));
	                $get->tipo_documento = base64_decode($get->tipo_documento);
	                $get->numero_documento = base64_decode($get->numero_documento);
	                $get->pais = base64_decode($get->pais);
	                $get->departamento = base64_decode($get->departamento);
	                $get->ciudad = base64_decode($get->ciudad);
	                $get->direccion = base64_decode($get->direccion);
	                $get->telefono = base64_decode($get->telefono);
	                $get->tipo = strtoupper(base64_decode($get->tipo));
	                $get->estado = base64_decode($get->estado);
	                $get->regimen = base64_decode($get->regimen);

	                $conexion = new Conexion();
	                $operation = Persona::registrar($get->nombre,$get->apellido,$get->tipo_documento,$get->numero_documento,$get->ciudad,$get->direccion,$get->telefono,$conexion);

	                if(($operation['ejecution'])&&($operation['result']))
	                {          
	                	$operation = Tercero::registrar($get->numero_documento, $get->tipo, $get->regimen, $get->estado, $conexion);
	                	
	                    $operation['message'] = "Se registro correctamente la información.";

	                    $log = Log::registro($usuario->getID(), "info", "Registro de información. - Tercero. {".$get->tipo.", ".$get->regimen.", ".$get->estado."}", $conexion);
	                   
	                    $log = Log::registro($usuario->getID(), "info", "Registro de información. - Tercero Persona. {".$get->nombre.", ".$get->apellido.", ".$get->tipo_documento.", ".$get->numero_documento.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."}", $conexion);  
						
						//Instanciar persona con el numero de documento
						$persona = new Persona($get->numero_documento, $conexion);
						//$ciudad = $persona->getCiudad();

						//Instanciar tercero sin conocer ID desde numero de documento
						$tercero = new Tercero();
						$tercero->instanciarSubID($get->numero_documento, $get->tipo, $conexion);
						//$persona = $tercero->getPersona();

	                    $_SESSION['persona'] = serialize($persona);
	                    $_SESSION['tercero'] = serialize($tercero);

	                }
	                elseif(!($operation['ejecution']))
	                {
	                    $log = Log::registro($usuario->getID(), "error", "Registro la información. Tercero Persona. {".$get->nombre.", ".$get->apellido.", ".$get->tipo_documento.", ".$get->numero_documento.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."} - {".$operation['error']."}", $conexion);
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
	                $get->nit = strtoupper(base64_decode($get->nit));
	                $get->razon_social = strtoupper(base64_decode($get->razon_social));
	                $get->naturaleza = base64_decode($get->naturaleza);
	                $get->fecha = base64_decode($get->fecha);
	                $get->pais = base64_decode($get->pais);
	                $get->departamento = base64_decode($get->departamento);
	                $get->ciudad = base64_decode($get->ciudad);
	                $get->direccion = base64_decode($get->direccion);
	                $get->telefono = base64_decode($get->telefono);
	                $get->tipo = strtoupper(base64_decode($get->tipo));
	                $get->estado = base64_decode($get->estado);
	                $get->regimen = base64_decode($get->regimen);

	                $conexion = new Conexion();

	                $operation = Empresa::registrar($get->nit, $get->razon_social, $get->naturaleza, $get->fecha, $get->ciudad, $get->direccion, $get->telefono, $conexion);

	                if(($operation['ejecution']) && ($operation['result']))
	                {
	          
	                	$operation = Tercero::registrar($get->nit, $get->tipo, $get->regimen, $get->estado, $conexion);

	                    $operation['message'] = "Se registro correctamente la información.";

	                    $log = Log::registro($usuario->getID(), "info", "Registro de información. - Tercero. {".$get->tipo.", ".$get->regimen.", ".$get->estado."}", $conexion);
	                   
	                    $log = Log::registro($usuario->getID(), "info", "Registro de información. - Tercero Empresa. {".$get->nit.", ".$get->razon_social.", ".$get->naturaleza." , ".$get->fecha.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."}", $conexion); 

	               
	                   	//Instanciar Empresa con el numero de documento
						$empresa = new Empresa($get->nit, $conexion);

						//Instanciar tercero sin conocer ID desde numero de documento
						$tercero = new Tercero();
						$tercero->instanciarSubID($get->nit, $get->tipo, $conexion);

	                    $_SESSION['empresa'] = serialize($empresa);
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
        	if(isset($_SESSION['tercero']) && (isset($_SESSION['persona']) || isset($_SESSION['empresa']))) 
        	{

				$tercero = unserialize($_SESSION['tercero']);
				$data['id_t'] = $tercero->getId();
        		$data['regimen'] = $tercero->getRegimen();
        		$tipo = $tercero->getTipo();
				$data['tipo'] = $tipo;
				$data['gc'] = $tercero->getGC();
	    		if($tipo == "NATURAL")
				{
					$persona = unserialize($_SESSION['persona']);

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

	                $operation['ejecution'] = true;
	                $operation['result'] = true;
	                $operation['message'] = "Se cargo correctamente la información";
	                $operation['data'] = $data;

	                echo json_encode($operation);

	    		}
	    		elseif($tipo == "JURIDICA")
	    		{
	    		 	$empresa = unserialize($_SESSION['empresa']);

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

	                $operation['ejecution'] = true;
	                $operation['result'] = true;
	                $operation['message'] = "Se cargo correctamente la información";
	                $operation['data'] = $data;

	                echo json_encode($operation);
	    		}
        	}
        }

        if ($get->actualizar) 
        {
        	if(isset($_SESSION['tercero']) && (isset($_SESSION['persona']) || isset($_SESSION['empresa']))) 
        	{
        		$s_tercero = unserialize($_SESSION['tercero']);
        		if($s_tercero->getTipo() == "NATURAL") 
        		{
        			$s_persona = unserialize($_SESSION['persona']);	
        			if($get->nombre != "" && $get->apellido != "" && $get->tipo_documento != "" && $get->numero_documento != "" && $get->pais != "" && $get->departamento != "" && $get->ciudad != "" && $get->direccion != "" && $get->telefono != "")
        			{
		                $get->nombre = strtoupper(base64_decode($get->nombre));
		                $get->apellido = strtoupper(base64_decode($get->apellido));
		                $get->tipo_documento = base64_decode($get->tipo_documento);
		                $get->numero_documento = base64_decode($get->numero_documento);
		                $get->pais = base64_decode($get->pais);
		                $get->departamento = base64_decode($get->departamento);
		                $get->ciudad = base64_decode($get->ciudad);
		                $get->direccion = base64_decode($get->direccion);
		                $get->telefono = base64_decode($get->telefono);
		                $get->estado = base64_decode($get->estado);
		                $get->regimen = base64_decode($get->regimen);

		                $conexion = new Conexion();
		                $persona = new Persona($s_persona->getNumDoc(), $conexion);
		                $operation = $persona->modificar($get->nombre,$get->apellido,$get->tipo_documento,$get->numero_documento,$get->ciudad,$get->direccion,$get->telefono,$conexion);
		                
		                if(($operation['ejecution'])&&($operation['result']))
		                {
		                	$tercero = new Tercero();
		                	$tercero->instanciarID($s_tercero->getId(), $conexion);
		                	$operation = $tercero->modificar($s_tercero->getTipo(), $get->regimen, $get->estado, $conexion);
		                	
		                    $operation['message'] = "Se actualizó correctamente la información.";

		                    $log = Log::registro($usuario->getID(), "info", "Actualización de información. - Tercero. {".$s_tercero->getTipo().", ".$get->regimen.", ".$get->estado."}", $conexion);
		                   
		                    $log = Log::registro($usuario->getID(), "info", "Actualización de información. - Tercero Persona. {".$get->nombre.", ".$get->apellido.", ".$get->tipo_documento.", ".$get->numero_documento.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."}", $conexion);  
							
							//Instanciar persona con el numero de documento
							$persona = new Persona($get->numero_documento, $conexion);
							//$ciudad = $persona->getCiudad();

							//Instanciar tercero sin conocer ID desde numero de documento
							$tercero = new Tercero();
							$tercero->instanciarSubID($get->numero_documento, $s_tercero->getTipo(), $conexion);

		                    $_SESSION['persona'] = serialize($persona);
		                    $_SESSION['tercero'] = serialize($tercero);
	                }
	                elseif(!($operation['ejecution']))
	                {
	                    $log = Log::registro($usuario->getID(), "error", "Actualización de la información. Tercero Persona. {".$get->nombre.", ".$get->apellido.", ".$get->tipo_documento.", ".$get->numero_documento.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."} - {".$operation['error']."}", $conexion);
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
        		$s_empresa = unserialize($_SESSION['empresa']);
        		if($get->nit != "" && $get->razon_social != "" && $get->pais != "" && $get->departamento != "" && $get->ciudad != "" && $get->direccion != "" && $get->telefono != "")
        		{
	                $get->nit = strtoupper(base64_decode($get->nit));
	                $get->razon_social = strtoupper(base64_decode($get->razon_social));
	                $get->naturaleza = base64_decode($get->naturaleza);
	                $get->fecha = base64_decode($get->fecha);
	                $get->pais = base64_decode($get->pais);
	                $get->departamento = base64_decode($get->departamento);
	                $get->ciudad = base64_decode($get->ciudad);
	                $get->direccion = base64_decode($get->direccion);
	                $get->telefono = base64_decode($get->telefono);
	                $get->estado = base64_decode($get->estado);
	                $get->regimen = base64_decode($get->regimen);

	                $conexion = new Conexion();

	                $empresa = new Empresa($s_empresa->getNit(), $conexion);
	                $operation = $empresa->modificar($get->nit, $get->razon_social, $get->naturaleza, $get->fecha, $get->ciudad, $get->direccion, $get->telefono, $conexion);

	                if(($operation['ejecution']) && ($operation['result']))
	                {
	                	$tercero = new Tercero();
		               	$tercero->instanciarID($s_tercero->getId(), $conexion);
	                	$operation = $tercero->modificar($s_tercero->getTipo(), $get->regimen, $get->estado, $conexion);

	                    $operation['message'] = "Se Actualizó correctamente la información.";

	                    $log = Log::registro($usuario->getID(), "info", "Actualización de información. - Tercero. {".$s_tercero->getTipo().", ".$get->regimen.", ".$get->estado."}", $conexion);
	                   
	                    $log = Log::registro($usuario->getID(), "info", "Actualización de información. - Tercero Empresa. {".$get->nit.", ".$get->razon_social.", ".$get->naturaleza." , ".$get->fecha.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."}", $conexion); 

	                  	//Instanciar Empresa con el numero de documento
						$empresa = new Empresa($get->nit, $conexion);

						//Instanciar tercero sin conocer ID desde numero de documento
						$tercero = new Tercero();
						$tercero->instanciarSubID($get->nit, $s_tercero->getTipo(), $conexion);

	                    $_SESSION['empresa'] = serialize($empresa);
	                    $_SESSION['tercero'] = serialize($tercero);


	                }
	                elseif(!($operation['ejecution']))
	                {

	                    $log = Log::registro($usuario->getID(), "error", "Actualización la información. Tercero Empresa. {".$get->nit.", ".$get->razon_social.", ".$get->naturaleza." , ".$get->fechaconst.", ".$get->ciudad.", ".$get->direccion.", ".$get->telefono."} - {".$operation['error']."}", $conexion);
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
        	$get->subcuenta = strtoupper(base64_decode($get->subcuenta));
        	$conexion = new Conexion();

        	$operation = Tercero::buscar($get->subcuenta, $conexion);
        	if($operation['ejecution'])
        	{
	            $operation['message'] = "Se cargo correctamente la información";
	        }
	        else
	       	{
	            $operation['message'] = "No hay registros de terceros.";
	        }

            echo json_encode($operation);	 
        }

        if ($get->instanciar) 
        {
        	$get->tipo = base64_decode($get->tipo);
        	
        	$conexion =new Conexion();

        	if ($get->tipo == "NATURAL") {
        		$get->numero_documento =  base64_decode($get->numero_documento);
        		//Instanciar persona por el numero de documento
				$persona = new Persona($get->numero_documento, $conexion);

				//Instanciar tercero sin conocer ID con numero de documento
				$tercero = new Tercero();
				$tercero->instanciarSubID($get->numero_documento, $get->tipo, $conexion);

				$_SESSION['persona'] = serialize($persona);
        		$_SESSION['tercero'] = serialize($tercero);
        		$operation['message'] = "Se cargo correctamente la información de ". $persona->getNombre() . " " . $persona->getApellido().".";
        	}else if($get->tipo == "JURIDICA"){
        		$get->nit =  base64_decode($get->nit);
        		//Instanciar empresa por el nit
				$empresa = new Empresa($get->nit, $conexion);

				//Instanciar tercero sin conocer ID con nit
				$tercero = new Tercero();
				$tercero->instanciarSubID($get->nit, $get->tipo, $conexion);
				
				$_SESSION['empresa'] = serialize($empresa);
				$_SESSION['tercero'] = serialize($tercero);
				$operation['message'] = "Se cargo correctamente la información de ".$empresa->getRazonSocial().".";
        	}

        	$operation["ejecution"] = true;
        	$operation['result'] = true;
        	
          	echo json_encode($operation);
        }
    }

?>