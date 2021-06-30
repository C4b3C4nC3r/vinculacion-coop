<!--ESTE HEADER SE REPITE EN TODOS LAS VISTAS-->
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>COOPROTEXRI</title>

    <link rel="icon" href="<?php echo constant('URL'); ?>public/img/cooprotexri-logo.png">
    <!-- Custom fonts for this template-->
    <!--ICONO-->
    <link href="<?php echo constant('URL'); ?>libs/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!--iconos-->
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?php echo constant('URL'); ?>public/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo constant('URL'); ?>main">
                    <span>
                        <!--Icono rodante CSS2-->
                        <style media="screen">
                            #actualizar {
                                /*ICONOS */
                                border-radius: 50%;
                                border: 2px solid #fff;
                                animation: girar 1000s;
                            }

                            @keyframes girar {
                                from {
                                    transform: rotate(1000000deg);
                                }
                            }

                            #actualizar {
                                display: ruby-base;
                            }

                            /*B*/

                            .encabezado {
                                text-align: center;
                            }
                        </style>
                        <p class="encabezado">
                            <img style="width: 30px;" class="img-fluid rounded-circle" id="actualizar" src="<?php echo constant('URL') ?>public/img/cooprotexri-logo.png" alt="">
                            COOPROTEXRI
                        </p>
                    </span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <!--OPCIONES EN DESARROLLO-->
            <!-- Nav Item - Pedidos -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo constant('URL'); ?>" data-toggle="collapse" data-target="#pedidos" aria-expanded="true" aria-controls="collapseTwo">
                    <!--  <i class='fas fa-truck' style='font-size:24px'></i>-->
                    <i class="fas fa-th" style='font-size:24px'></i>
                    <span>Pedidos</span>
                </a>
                <div id="pedidos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Registros</h6>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>pedido">Nuevo Pedido</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>consultarpedido">Revisar Pedidos</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - PRODUCTOS -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo constant('URL'); ?>" data-toggle="collapse" data-target="#reportes" aria-expanded="true" aria-controls="collapseTwo">
                    <i class='fas fa-boxes' style='font-size:24px'></i>
                    <span>Reportes</span>
                </a>
                <div id="reportes" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Registros</h6>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>reporteinventario">Inventario</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>reportepedido">Pedidos</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>reporteganacias">Ganancias</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>reporteanticipio">Anticipios</a>

                        <!--<a class="collapse-item" href="// echo constant('URL'); ?>inventario">Inventario</a>-->
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <!-- Nav Item - MATERIALES -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo constant('URL'); ?>" data-toggle="collapse" data-target="#collapseMaterial" aria-expanded="true" aria-controls="collapseTwo">
                    <!--  <i class='fas fa-truck' style='font-size:24px'></i>-->
                    <i class="fas fa-th" style='font-size:24px'></i>
                    <span>Materiales</span>
                </a>
                <div id="collapseMaterial" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Registros</h6>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>ingresarmaterial">Ingresar Material</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>salidamaterial">Salida Material</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>material">Registrar Material</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>consultarmaterial">Revisar Materiales</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - PRODUCTOS -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo constant('URL'); ?>" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class='fas fa-boxes' style='font-size:24px'></i>
                    <span>Productos</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Registros</h6>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>producto">Nuevo Producto</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>consultarproducto">Revisar Productos</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item -Proveedor -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo constant('URL'); ?>" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class='fas fa-truck' style='font-size:24px'></i>
                    <span>Proveedores</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Registros</h6>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>proveedor">Registrar Proveedor</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>consultarproveedor">Consultar Proveedores</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->

            <!-- Nav Item - Locales -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo constant('URL'); ?>" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class='fas fa-building' style='font-size:24px'></i>
                    <span>Socios</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Registros</h6>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>socio">Registrar Socio</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>consultarsocio">Consultar Socios</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>tarea">Asignar Tareas</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>consultartarea">Consultar Tareas</a>
                        
                    </div>
                </div>
            </li>

            <!-- Nav Item - Clientes -->

            <li class="nav-item">
                <a href="#" class="nav-link collapsed" data-toggle="collapse" data-target="#clientes" aria-expanded="true" aria-controls="collapsePages">
                    <i class="material-icons" style="font-size:30px">group</i><span>Clientes</span>
                </a>
                <div id="clientes" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Registros</h6>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>cliente">Nuevo Clientes</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>consultarcliente">Revisar Clientes</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Usuario -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo constant('URL'); ?>" data-toggle="collapse" data-target="#usuarios" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class='fas fa-clipboard-list' style='font-size:24px'></i>
                    <span>Usuarios</span>
                </a>
                <div id="usuarios" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Registros</h6>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>usuario">Nuevo Usuario</a>
                        <a class="collapse-item" href="<?php echo constant('URL'); ?>consultarusuario">Consultar Usuarios</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message
            <div class="sidebar-card">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="">
                <p class="text-center mb-2"><strong>UFP</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div>
          -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">



                        <!-- Nav Item - Alerts -->
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <a class="navbar-brand">Bienvenido: <b>
                                            <?php echo $_SESSION['nombre_usuario']; ?>
                                        </b>
                                    </a>
                                </div>
                                <a class="nav-link dropdown-toggle" href="<?php echo constant('URL'); ?>" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">

                                    </span>
                                    <img class="img-profile rounded-circle" src="https://image.flaticon.com/icons/png/512/149/149071.png">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="<?php echo constant('URL'); ?>info">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Cambiar Clave
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Cerrar Session
                                    </a>
                                </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Bootstrap core JavaScript-->
                <script src="<?php echo constant('URL'); ?>libs/vendor/jquery/jquery.min.js"></script>
                <script src="<?php echo constant('URL'); ?>libs/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                <!-- Core plugin JavaScript-->
                <script src="<?php echo constant('URL'); ?>libs/vendor/jquery-easing/jquery.easing.min.js"></script>

                <!-- Custom scripts for all pages-->
                <script src="<?php echo constant('URL'); ?>libs/js/sb-admin-2.min.js"></script>

                <!-- Page level plugins -->
                <script src="<?php echo constant('URL'); ?>libs/vendor/chart.js/Chart.min.js"></script>

                <!-- Page level custom scripts -->
                <script src="<?php echo constant('URL'); ?>libs/js/demo/chart-area-demo.js"></script>
                <script src="<?php echo constant('URL'); ?>libs/js/demo/chart-pie-demo.js"></script>

                <!--SCRIPS ALERTS EN LOS CRUDS-->
                <script src="<?php echo constant('URL'); ?>libs/js/login.js"></script>
