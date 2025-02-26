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
$statusrow = $core->cdp_getStatus();


?>
<!DOCTYPE html>
<html dir="<?php echo $direction_layout; ?>" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    <title><?php echo $lang['shiplist'] ?> | <?php echo $core->site_name ?></title>
    <!-- This Page CSS -->
    <!-- Custom CSS -->
    <?php include 'views/inc/head_scripts.php'; ?>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->


    <?php include 'views/inc/preloader.php'; ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->

        <?php include 'views/inc/topbar.php'; ?>

        <!-- End Topbar header -->


        <!-- Left Sidebar - style you can find in sidebar.scss  -->

        <?php include 'views/inc/left_sidebar.php'; ?>


        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title"> <?php echo $lang['shiplist']; ?></h4>

                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <!-- Column -->

                    <div class="col-lg-12 col-xl-12 col-md-12">

                        <div class="card">
                            <div class="card-body">
                                <div id="resultados_ajax"></div>

                            <div class="row mb-3">

                                <?php
                                    // Define la URL del enlace basándote en el nivel de usuario
                                    $add_courier_url = ($userData->userlevel == 9) ? "courier_add.php" : "courier_add_client.php";
                                ?>

                                <div class="col-sm-12 col-md-3 mb-2">
                                    <div class="form-group">
                                        <a href="<?php echo $add_courier_url; ?>">
                                            <button type="button" class="btn btn-outline-dark">
                                                <i class="ti-plus" aria-hidden="true"></i>
                                                <?php echo $lang['global-buttons-1'] ?>
                                            </button>
                                        </a>
                                    </div>
                                </div>

                                <div class=" col-sm-12 col-md-4 mb-2">
                                    <div class="input-group">
                                        <input type="text" name="search" id="search" class="form-control input-sm float-right" placeholder="<?php echo $lang['left21551'] ?>" onkeyup="cdp_load(1);">
                                        <div class="input-group-append input-sm">
                                            <button type="submit" class="btn btn-outline-dark"><i class="fa fa-search"></i></button>
                                        </div>

                                    </div>
                                </div><!-- /.col -->

                                <div class=" col-sm-12 col-md-3 mb-2">
                                    <div class="input-group">
                                        <select onchange="cdp_load(1);" class="form-control custom-select" id="status_courier" name="status_courier">
                                            <option value="0">--<?php echo $lang['left210'] ?>--</option>
                                            <?php foreach ($statusrow as $row) : ?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->mod_style; ?></option>

                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class=" col-sm-12 col-md-2 mb-2">
                                    <div class="input-group">
                                        <select onchange="cdp_load(1);" class="form-control custom-select" id="filterby" name="filterby">
                                            <option value="0"><?php echo $lang['leftorder128'] ?></option>
                                            <option value="1"><?php echo $lang['left1077'] ?></option>
                                            <option value="2"><?php echo $lang['leftorder129'] ?></option>
                                            <option value="3"><?php echo $lang['leftorder130'] ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12 hide" id="div-actions-checked">
                                        <!-- <div class="form-group"> -->
                                        <div class="btn-group mt-2">
                                            <span class="mt-2 mr-4"><strong> <?php echo $lang['global-2'] ?></strong> <strong id="countChecked"> 0</strong></span>
                                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php echo $lang['global-1'] ?>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalCheckboxStatus"><i style="color:#20c997" class="ti-reload"></i>&nbsp;<?php echo $lang['left21550'] ?></a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalDriverCheckbox"><i style="color:#ff0000" class="fas fa-car"></i>&nbsp;<?php echo $lang['left208'] ?></a>
                                                <a class="dropdown-item" onclick="cdp_printMultipleLabel();" target="_blank"> <i style="color:#343a40" class="ti-printer"></i>&nbsp;<?php echo $lang['toollabel'] ?> </a>
                                            </div>
                                        </div>
                                        <!-- </div> -->

                                    </div>
                                </div>

                            </div>


                            <div class="outer_divx"></div>


                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
        </div>

        <?php
        include('views/modals/modal_update_status_checked.php');
        ?>
        <?php include('views/modals/modal_send_email.php'); ?>

        <?php include('views/modals/modal_update_driver.php'); ?>
        <?php include('views/modals/modal_update_driver_checked.php'); ?>
        <?php include('views/modals/modal_verify_payment_packages.php'); ?>

        <?php include('views/modals/modal_cancel_pickup.php'); ?>

        <?php include('views/modals/modal_delete_pickup.php'); ?>


        <?php include('views/modals/modal_charges_list.php'); ?>
        <?php include('views/modals/modal_charges_add.php'); ?>
        <?php include('views/modals/modal_charges_edit.php'); ?>
        <?php include 'views/inc/footer.php'; ?>

    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <?php include('helpers/languages/translate_to_js.php'); ?>

    <script src="dataJs/courier.js"></script>
    <script src="dataJs/courier_ajax.js"></script>


</body>

</html>