<?php
// *************************************************************************
// *                                                                       *
// * DEPRIXA PRO -  Integrated Web Shipping System                         *
// * Copyright (c) JAOMWEB. All Rights Reserved                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: support@jaom.info                                              *
// * Website: http://www.jaom.info                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************



$userData = $user->cdp_getUserData();

$db = new Conexion;

// Obtener el mes y el año actual
$month = date('m');
$year = date('Y');

// Obtener el número del mes actual
$currentMonth = date('n');

// Obtener el nombre del mes actual
$monthName = obtenerNombreMes($currentMonth);

?>
<!DOCTYPE html>
<html dir="<?php echo $direction_layout; ?>" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Courier DEPRIXA-Integral Web System" />
    <meta name="author" content="Jaomweb">
    <title><?php echo $lang['left-menu-sidebar-19'] ?> | <?php echo $core->site_name ?></title>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    <link href="assets/template/assets/libs/morris.js/morris.css" rel="stylesheet">
    <?php include 'views/inc/head_scripts.php'; ?>
</head>

<body>

    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->

        <?php include 'views/inc/preloader.php'; ?>

        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->

        <?php include 'views/inc/topbar.php'; ?>

        <!-- End Topbar header -->


        <!-- Left Sidebar - style you can find in sidebar.scss  -->

        <?php include 'views/inc/left_sidebar.php'; ?>


        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->

        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title"><?php echo $lang['left-menu-sidebar-19'] ?></h4>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header-title d-flex justify-content-between">
                                    <div class="card-title mb-6">
                                        <h5 class="m-0 me-2"><?php echo $lang['dash-general-9'] ?></h5>
                                        <small class="text-muted"><?php echo $lang['dash-general-24'] ?></small>
                                    </div>
                                </div>
                                <div><br></div>

                                <div class="col-lg-12 col-md-12">
                                    <!-- Primer elemento contador de envios -->
                                    <div class="col-lg-12 col-md-12 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10">
                                                <a href="pickup_list.php">
                                                    <span class="text-secondary display-7">
                                                        <i class="mdi mdi-star-circlemdi mdi-clock-fast"></i>
                                                    </span>
                                                </a>
                                            </div>

                                            <div class="card-info-statics">
                                              <h5 class="mb-0">
                                                <?php
                                                    $db->cdp_query('SELECT COUNT(*) as total FROM cdb_add_order WHERE  is_pickup=1');
                                                    $db->cdp_execute();
                                                    $count = $db->cdp_registro();
                                                    echo $count->total;
                                                    ?>            
                                              </h5>
                                              <small><?php echo $lang['dash-general-2'] ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-12">

                                    <!-- Segundo elemento contador de envios -->
                                    <div class="col-lg-12 col-md-12 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10">
                                                <a href="pickup_list.php">
                                                    <span class="text-secondary display-7">
                                                        <i class="mdi mdi-backspace"></i>
                                                    </span>
                                                </a>
                                            </div>

                                            <div class="card-info-statics">
                                              <h5 class="mb-0">
                                                <?php
                                                    $db->cdp_query('SELECT COUNT(*) as total FROM cdb_add_order WHERE  is_pickup=1 and status_courier=12');
                                                    $db->cdp_execute();
                                                    $count = $db->cdp_registro();
                                                    echo $count->total;
                                                    ?>            
                                              </h5>
                                              <small><?php echo $lang['dash-general-221'] ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-12">
                                    <!-- Tercero elemento contador de envios -->
                                    <div class="col-lg-12 col-md-12 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10">
                                                <a href="pickup_list.php">
                                                    <span class="text-secondary display-7">
                                                        <i class="mdi mdi-close-circle"></i>
                                                    </span>
                                                </a>
                                            </div>

                                            <div class="card-info-statics">
                                              <h5 class="mb-0">
                                                <?php
                                                    $db->cdp_query('SELECT COUNT(*) as total FROM cdb_add_order WHERE  is_pickup=1 and status_courier=21');
                                                    $db->cdp_execute();
                                                    $count = $db->cdp_registro();
                                                    echo $count->total;
                                                    ?>            
                                              </h5>
                                              <small><?php echo $lang['dash-general-222'] ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 col-lg-12">
                                    <!-- Tercero elemento contador de envios -->
                                    <div class="col-lg-12 col-md-12 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10">
                                                <a href="pickup_list.php">
                                                    <span class="text-secondary display-7">
                                                        <i class="mdi mdi-package-down"></i>
                                                    </span>
                                                </a>
                                            </div>

                                            <div class="card-info-statics">
                                              <h5 class="mb-0">
                                                <?php
                                                    $db->cdp_query('SELECT COUNT(*) as total FROM cdb_add_order WHERE  status_courier=8 and  is_pickup=1');
                                                    $db->cdp_execute();
                                                    $count = $db->cdp_registro();
                                                    echo $count->total;
                                                    ?>            
                                              </h5>
                                              <small><?php echo $lang['dash-general-220'] ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-12">
                                    <!-- Cuarto elemento contador de envios -->
                                    <div class="col-lg-12 col-md-12 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10">
                                                <a href="#">
                                                    <span class="text-info display-7">
                                                        <i class="mdi mdi-currency-usd"></i>
                                                    </span>
                                                </a>
                                            </div>

                                            <div class="card-info-statics">
                                              <h5 class="mb-0">
                                                <?php echo $core->currency; ?>
                                                <?php
                                                $month = date('m');
                                                $year = date('Y');

                                                $db->cdp_query("SELECT IFNULL(SUM(total_order), 0) as total FROM cdb_add_order WHERE status_courier!=21 and is_pickup=1");
                                                $db->cdp_execute();
                                                $count = $db->cdp_registro();
                                                echo cdb_money_format($count->total);
                                                ?>                      
                                              </h5>
                                              <small><?php echo $lang['dash-general-27'] ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $lang['messagesform101'] ?></h4>
                                <div class="table-responsive">
                                    <div id="sales-packages-chart-container" class="morris-chart-container">
                                        <div id="morris-sales-chart-pickup"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Table -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title"><?php echo $lang['dash-general-28'] ?></h4>
                                        <h5 class="card-subtitle"><?php echo $lang['dash-general-244'] ?></h5>
                                    </div>

                                </div>
                                <div class="outer_div">

                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Table -->
                <!-- ============================================================== -->

            </div>
            <?php include 'views/inc/footer.php'; ?>
        </div>
    </div>
    <?php include('helpers/languages/translate_to_js.php'); ?>

        <!--Morris JavaScript -->
    <script src="assets/template/assets/libs/raphael/raphael.min.js"></script>
    <script src="assets/template/assets/libs/morris.js/morris.min.js"></script>

    <script src="dataJs/dashboard_pickup.js"></script>
