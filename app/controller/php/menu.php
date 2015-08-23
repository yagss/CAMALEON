<?php 

    $menu = json_decode(file_get_contents('php://input'));

    if($menu->showMenu){
        
        if($menu->name == "Home"){
            
            ob_start();
            
            ?>

            <script type="text/javascript" src="/app/controller/js/menu.js"></script>

            <nav>
                <h1><span class="icon-home2"></span> INICIO</h1>
                <a class="link" href="#" data-url="/app/view/html/administracion/inicio.html" data-name="Administrativo"><span class="icon-earth"></span> Modulo Administrativo</a>
            </nav>

            <?php
            
            $operation['result'] = ob_get_clean();
            $operation['ejecution'] = true;
            
            echo json_encode($operation);
        
        }elseif($menu->name == "Administrativo"){
            
            ob_start();
            
            ?>

            <script type="text/javascript" src="/app/controller/js/menu.js"></script>

            <nav>
                <h1><span class="icon-earth"></span> MODULO ADMINISTRATIVO</h1>
                
                    <div class="navegacion">
                        <ul>
                            <li class="submenu"><a href="#"><span class="icon-circle-right"></span> USUARIO </a>
                                <ul class="children">
                                    <li><a href="#">Agregar Usuario</a></li>
                                    <li><a href="#">Buscar Usuario</a></li>
                                </ul>
                            </li>
                            <li class="submenu"><a href="#"><span class="icon-circle-right"></span> DATOS Y VARIABLES </a>
                                <ul  class="children">
                                    <li class="submenu"><a href="#"><span class="icon-arrow-right2"></span> PUC</a>
                                        <ul class="children inte" >
                                            <li><a class="link" href="#"  data-url="/app/view/html/administracion/contabilidad/puc/cuenta_auxiliar/form.html" data-name="Form Cuenta Auxiliar">Agregar cuenta auxiliar</a></li>
                                            <li><a href="#">Buscar cuenta</a></li>
                                        </ul>
                                    </li>
                                    <li class=""><a href="#"><span class="icon-arrow-right2"></span> NOMINA</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
            </nav>

            <?php
            
            $operation['result'] = ob_get_clean();
            $operation['ejecution'] = true;
            
            echo json_encode($operation);
        
        }else{
            
            $operation['ejecution'] = false;
            
            echo json_encode($operation);
            
        }
        
    }

?>