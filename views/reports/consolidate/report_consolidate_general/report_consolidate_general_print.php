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



require_once('helpers/querys.php');

$db = new Conexion;
$user = new User;
$core = new Core;
$userData = $user->cdp_getUserData();

$status_courier = intval($_REQUEST['status_courier']);
$agency = intval($_REQUEST['agency']);
$range = $_REQUEST['range'];
$customer_id = intval($_REQUEST['customer_id']);


$sWhere = "";


if ($status_courier > 0) {

    $sWhere .= " and  a.status_courier = '" . $status_courier . "'";
}

if ($customer_id > 0) {

    $sWhere .= " and a.sender_id = '" . $customer_id . "'";
}


if ($agency > 0) {

    $db->cdp_query("SELECT * FROM cdb_branchoffices where id= '" . $agency . "'");
    $agencys = $db->cdp_registro();

    $agencyFilter = $agencys->name_branch;

    $sWhere .= " and a.agency = '" . $agency . "'";
} else {

    $agencyFilter = $lang['report-text54'];
}

if ($userData->userlevel == 3) {

    $sWhere .= " and  a.driver_id = '" . $_SESSION['userid'] . "'";
}



if (!empty($range)) {

    $fecha =  explode(" - ", $range);
    $fecha = str_replace('/', '-', $fecha);

    $fecha_inicio = date('Y-m-d', strtotime($fecha[0]));
    $fecha_fin = date('Y-m-d', strtotime($fecha[1]));


    $sWhere .= " and  a.c_date between '" . $fecha_inicio . "'  and '" . $fecha_fin . "'";
}

$sql = "SELECT a.status_invoice, a.total_weight, a.total_tax_discount, a.sub_total, a.total_tax_insurance, a.total_tax_custom_tariffis, a.total_tax,   a.total_order, a.consolidate_id, a.c_prefix, a.c_no, a.c_date, a.sender_id, a.order_courier,a.status_courier,  b.mod_style, b.color FROM
             cdb_consolidate as a
             INNER JOIN cdb_styles as b ON a.status_courier = b.id
             $sWhere
              and a.status_courier!=14

             order by consolidate_id desc 
             ";


$query_count = $db->cdp_query($sql);
$db->cdp_execute();
$numrows = $db->cdp_rowCount();


$db->cdp_query($sql);
$data = $db->cdp_registros();

$fecha = str_replace('-', '/', $fecha);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="<?php echo $direction_layout; ?>">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/uploads/favicon.png">
    <link href="assets/custom_dependencies/print_report.css" rel="stylesheet">

    <title><?php echo $lang['report-text76'] ?></title>
    <link href="https://fonts.googleapis.com/css?family=Tajawal&subset=arabic" rel="stylesheet">
    <style>
        * {
            font-family: 'Tajawal';
        }
    </style>
    <style type="text/css">
        table {
            table-layout: fixed;
            width: 250px;
        }

        th,
        td {
            border: 1px solid black;
            width: 100px;
            word-wrap: break-word;
        }
    </style>

</head>

<body>
    <div id="page-wrap">

        <h2><?php echo $core->site_name; ?><br>
            <?php echo $lang['report-text76'] ?> <br>

            [<?php echo $fecha[0] . ' - ' . $fecha[1]; ?>]
            <br>

            <?php echo $lang['report-text58'] ?>: <?php echo $agencyFilter; ?>
        </h2>
        <table>
            <tr>
                <th class="text-center"><b></b></th>
                <th class="text-center"><b><?php echo $lang['ltracking']; ?></b></th>
                <th class="text-center"><b><?php echo $lang['ddate']; ?></b></th>
                <th class="text-center"><b><?php echo $lang['report-text37'] ?></b></th>
                <th class="text-center"><b><?php echo $lang['lorigin']; ?></b></th>
                <th class="text-center"><b><?php echo $lang['lstatusshipment']; ?></b></th>
                <th class="text-center"><b><?php echo $lang['report-text52'] ?></b></th>
                <th class="text-center"><b><?php echo $lang['report-text43'] ?></b></th>
                <th class="text-center"><b><?php echo $lang['report-text44'] ?></b></th>
                <th class="text-center"><b><?php echo $lang['report-text48'] ?></b></th>
                <th class="text-center"><b><?php echo $lang['report-text49'] ?></b></th>
                <th class="text-center"><b><?php echo $lang['report-text51'] ?></b></th>
                <th class="text-center"><b><?php echo $lang['report-text42'] ?></b></th>
                <th class="text-center"><b></b></th>

            </tr>

            <?php

            if ($numrows > 0) {

                $count = 0;
                $sumador_weight = 0;
                $sumador_subtotal = 0;
                $sumador_discount = 0;
                $sumador_insurance = 0;
                $sumador_c_tariff = 0;
                $sumador_tax = 0;
                $sumador_total = 0;

                foreach ($data as $row) {

                    $db->cdp_query("SELECT * FROM cdb_users where id= '" . $row->sender_id . "'");
                    $sender_data = $db->cdp_registro();


                    $db->cdp_query("SELECT * FROM cdb_courier_com where id= '" . $row->order_courier . "'");
                    $courier_com = $db->cdp_registro();

                    $db->cdp_query("SELECT * FROM cdb_address_shipments where order_track='" . $row->c_prefix . $row->c_no . "'");
                    $address_order = $db->cdp_registro();

                    $db->cdp_query("SELECT * FROM cdb_styles where id= '14'");
                    $status_style_pickup = $db->cdp_registro();

                    $db->cdp_query("SELECT * FROM cdb_styles where id= '13'");
                    $status_style_consolidate = $db->cdp_registro();

                    if ($row->status_invoice == 1) {
                        $text_status = $lang['invoice_paid'];
                        $label_class = "label-success";
                    } else if ($row->status_invoice == 2) {
                        $text_status = $lang['invoice_pending'];
                        $label_class = "label-warning";
                    } else if ($row->status_invoice == 3) {
                        $text_status = $lang['invoice_due'];
                        $label_class = "label-danger";
                    }



                    $weight = $row->total_weight;
                    $sub_total = $row->sub_total;
                    $discount = $row->total_tax_discount;
                    $insurance = $row->total_tax_insurance;
                    $custom_c = $row->total_tax_custom_tariffis;
                    $tax = $row->total_tax;
                    $total = $row->total_order;

                    $sumador_weight += $weight;
                    $sumador_subtotal += $sub_total;
                    $sumador_discount += $discount;
                    $sumador_insurance += $insurance;
                    $sumador_c_tariff += $custom_c;
                    $sumador_tax += $tax;
                    $sumador_total += $total;

                    $count++;


            ?>

                    <tr>
                        <td><b><?php echo $count; ?> </b></td>
                        <td><?php echo $row->c_prefix . $row->c_no; ?></td>
                        <td><?php echo $row->c_date; ?></td>
                        <td><?php echo $sender_data->fname . ' ' . $sender_data->lname; ?></td>
                        <td><?php echo $address_order->sender_country . ' ' . $address_order->sender_city; ?></td>
                        <td><?php echo $row->mod_style; ?></td>
                        <td><?php echo  $row->total_weight; ?></td>
                        <td><?php echo  cdb_money_format_bar($row->sub_total); ?></td>
                        <td><?php echo  cdb_money_format_bar($row->total_tax_discount); ?></td>
                        <td><?php echo  cdb_money_format_bar($row->total_tax_insurance); ?></td>
                        <td><?php echo  cdb_money_format_bar($row->total_tax_custom_tariffis); ?></td>
                        <td><?php echo  cdb_money_format_bar($row->total_tax); ?></td>
                        <td><?php echo  cdb_money_format($row->total_order); ?></td>
                        <td><?php echo $text_status; ?></td>

                    </tr>
                <?php
                }
                ?>

                <tr>
                    <td><b><?php echo $lang['report-text53'] ?></td> </b>
                    <td colspan="5"></td>
                    <td><b><?php echo  $sumador_weight; ?></b></td>
                    <td><b><?php echo  cdb_money_format($sumador_subtotal); ?></b></td>
                    <td><b><?php echo  cdb_money_format($sumador_discount); ?></b></td>
                    <td><b><?php echo  cdb_money_format($sumador_insurance); ?></b></td>
                    <td><b><?php echo  cdb_money_format($sumador_c_tariff); ?></b></td>
                    <td><b><?php echo  cdb_money_format($sumador_tax); ?></b></td>
                    <td><b><?php echo  cdb_money_format($sumador_total); ?></b></td>

                </tr>
            <?php
            }
            ?>


        </table>

        <button class='button -dark center no-print' onClick="window.print();" style="font-size:16px; margin-top: 20px;"><?php echo $lang['report-text5'] ?> &nbsp;&nbsp; <i class="fa fa-print"></i></button>
    </div>

</body>

</html>