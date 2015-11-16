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
                    <lh class="title a"><i class="icon-home"></i> INICIO</lh>
                    <li><a class="link" href="#" data-url="/app/view/html/administracion/inicio.html" data-name="Administrativo"><span class="icon-earth"></span> MODULO ADMINISTRATIVO</a></li>
                    <lh class="title b"> ACCESOS</lh>
                    <li class="submenu b">
                        <a href="#"> TERCERO</a>
                        <div class="submenu float">
                            <nav>
                                <lh class="title a"><i class="icon-busqueda_tercero"></i> TERCERO</lh>
                                <li><a class="link" href="#" data-url="/app/view/html/tercero/form.html" data-name="Form Tercero">Agregar</a></li>
                                <li><a class="link" href="#" data-url="/app/view/html/tercero/busqueda.html" data-name="Busqueda Tercero">Buscar</a></li>
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
                <lh class="title a"><i class="icon-global"></i> MÓDULO ADMINISTRATIVO</lh>
                <li class="submenu a"><a href="#"><i class="icon-arrow1"></i> DATOS Y VARIABLES </a>
                    <nav>
                        <li class="submenu a"><a href="#"><i class="icon-arrow2"></i> PUC</a>
                            <nav>
                                <li><a class="link" href="#" data-url="/app/view/html/administracion/contabilidad/puc/cuenta_auxiliar/form.html" data-name="Form Cuenta Auxiliar">Agregar cuenta auxiliar</a></li>
                                <li><a class="link" href="#" data-url="/app/view/html/administracion/contabilidad/puc/subcuenta/form.html" data-name="Form SubCuenta">Agregar subcuenta</a></li>
                                <li><a class="link" href="#" data-url="/app/view/html/administracion/contabilidad/puc/busqueda.html" data-name="Busqueda PUC">Buscar cuenta</a></li>
                            </nav>
                        </li>
                        <!--<li class=""><a href="#"><span class="icon-arrow-right2"></span> NOMINA</a></li>-->
                    </nav>
                </li>
                <li class="submenu a"><a href="#"><i class="icon-arrow1"></i> TRANSACCIÓN</a>
                    <nav>
                        <li><a class="link" href="#" data-url="/app/view/html/administracion/contabilidad/transaccion/form.html" data-name="Form Transacción">Agregar transacción</a></li>
                        <li><a class="link" href="#" data-url="/app/view/html/administracion/contabilidad/transaccion/busqueda.html" data-name="Busqueda Transacción">Buscar transacción</a></li>
                    </nav>
                </li>
                <li class="submenu a"><a href="#"><i class="icon-arrow1"></i> SUCURSAL </a>
                        <nav>
                            <li><a class="link" href="#" data-url="/app/view/html/administracion/sucursal/form.html" data-name="Form Sucursal">Agregar sucursal</a></li>
                            <li><a class="link" href="#" data-url="/app/view/html/administracion/sucursal/busqueda.html" data-name="Busqueda Sucursal">Buscar sucursal</a></li>
                        </nav>
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