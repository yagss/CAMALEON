<?php 

    $menu = json_decode(file_get_contents('php://input'));

    if($menu->showMenu){
        
        ob_start();
            
        ?>

        <script type="text/javascript" src="/app/controller/js/menu/menu.js"></script>

        <div class="user-name">
            <p>Administrador</p>
            <a href="#" id="logout">Salir</a>
        </div>

        <?php

        $operation['result'] = ob_get_clean();
        
        if($menu->name == "Home"){
            
            ob_start();
            
            ?>
                <nav>
                    <lh class="title a"><span class="icon-home2"></span> INICIO</lh>
                    <li><a class="link" href="#" data-url="/app/view/html/administracion/inicio.html" data-name="Administrativo"><span class="icon-earth"></span> Modulo Administrativo</a></li>
                    <lh class="title b"> ACCESOS</lh>
                    <li class="submenu b">
                        <a href="#"><span class="icon-spinner10"></span> Terceros</a>
                        <div class="submenu float">
                            <nav>
                                <lh class="title a"><span class="icon-home2"></span> Terceros</lh>
                                <li><a href="#">Agregar</a></li>
                                <li><a href="#">Buscar</a></li>
                                <li class="volver">VOLVER</li>
                            </nav>
                        </div>
                    </li>
                </nav>

            <?php
            
            $operation['result'] .= ob_get_clean();
            $operation['ejecution'] = true;
            
            echo json_encode($operation);
        
        }elseif($menu->name == "Administrativo"){
            
            ob_start();
            
            ?>

            <nav>
                <lh class="title a"><span class="icon-home2"></span> MÓDULO ADMINISTRATIVO</lh>
                <li class="submenu a"><a href="#"><span class="icon-circle-right"></span> DATOS Y VARIABLES </a>
                    <nav>
                        <li class="submenu a"><a href="#"><span class="icon-arrow-right2"></span> PUC</a>
                            <nav>
                                <li><a class="link" href="#" data-url="/app/view/html/administracion/contabilidad/puc/cuenta_auxiliar/form.html" data-name="Form Cuenta Auxiliar">Agregar cuenta auxiliar</a></li>
                                <li><a class="link" href="#" data-url="/app/view/html/administracion/contabilidad/puc/busqueda.html" data-name="Busqueda PUC">Buscar cuenta</a></li>
                            </nav>
                        </li>
                        <!--<li class=""><a href="#"><span class="icon-arrow-right2"></span> NOMINA</a></li>-->
                    </nav>
                </li>
            </nav>

            <?php
            
            $operation['result'] .= ob_get_clean();
            $operation['ejecution'] = true;
            
            echo json_encode($operation);
        
        }else{
            
            $operation['ejecution'] = false;
            
            echo json_encode($operation);
            
        }
        
    }

/*

<nav>
    <lh class="title a"><span class="icon-home2"></span> INICIO</lh>
    <li><a class="link" href="#" data-url="/app/view/html/administracion/inicio.html" data-name="Administrativo"><span class="icon-earth"></span> Modulo Administrativo</a></li>
    <li class="submenu a"><a href="#"><span class="icon-circle-right"></span> DATOS Y VARIABLES </a>
        <nav>
            <li class="submenu a"><a href="#"><span class="icon-arrow-right2"></span> PUC</a>
                <nav>
                    <li><a class="link" href="#" data-url="/app/view/html/administracion/contabilidad/puc/cuenta_auxiliar/form.html" data-name="Form Cuenta Auxiliar">Agregar cuenta auxiliar</a></li>
                    <li><a class="link" href="#" data-url="/app/view/html/administracion/contabilidad/puc/busqueda.html" data-name="Busqueda PUC">Buscar cuenta</a></li>
                </nav>
            </li>
            <!--<li class=""><a href="#"><span class="icon-arrow-right2"></span> NOMINA</a></li>-->
        </nav>
    </li>
    <lh class="title b"> ACCESOS</lh>
    <li class="submenu b">
        <a href="#"><span class="icon-spinner10"></span> Terceros</a>
        <div class="submenu float">
            <nav>
                <lh class="title a"><span class="icon-home2"></span> Terceros</lh>
                <li><a href="#">Agregar</a></li>
                <li><a href="#">Buscar</a></li>
                <li class="volver">VOLVER</li>
            </nav>
        </div>
    </li>
    <li class="submenu b">
        <a href="#"><span class="icon-spinner10"></span> Sucursal</a>
        <div class="submenu float">
            <nav>
                <lh class="title a"><span class="icon-home2"></span> Sucursal</lh>
                <li><a href="#">Agregar</a></li>
                <li><a href="#">Buscar</a></li>
                <li class="volver">VOLVER</li>
            </nav>
        </div>
    </li>
</nav>

*/

?>