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

require_once("../../../loader.php");

$db = new Conexion;
$user = new User;
$core = new Core;
$userData = $user->cdp_getUserData();
$month = date('m');
$year = date('Y');

$swhere = "";

if ($userData->userlevel == 3) {

	$swhere .= " and  a.driver_id = '" . $_SESSION['userid'] . "'";
} else if ($userData->userlevel == 1) {

	$swhere .= " and  a.sender_id = '" . $_SESSION['userid'] . "'";
} else {

	$swhere .= "and month(order_date)='$month' AND year(order_date)='$year'";
}

if (isset($_REQUEST['search'])) {

	$search = trim($_REQUEST['search']);

	if ($search != null) {

		$swhere .= " and  CONCAT(a.order_prefix,a.order_no) LIKE '%" . $search . "%'";
	}
}


// // pagination variables
$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
$per_page = 10; //how much records you want to show
$adjacents  = 4; //gap between pages after number of adjacents
$offset = ($page - 1) * $per_page;


$sql = "SELECT a.status_invoice,  a.order_incomplete,  a.is_consolidate, a.is_pickup,  a.total_order, a.order_id, a.order_prefix, a.order_no, a.order_date, a.sender_id, a.receiver_id, a.order_courier, a.order_pay_mode, a.status_courier, a.driver_id, a.order_service_options,  b.mod_style, b.color FROM
			 cdb_add_order as a
			 INNER JOIN cdb_styles as b ON a.status_courier = b.id
			 and a.status_courier!=14
			 $swhere

			 order by order_id desc 
			 ";


$query_count = $db->cdp_query($sql);
$db->cdp_execute();
$numrows = $db->cdp_rowCount();


$db->cdp_query($sql . " limit $offset, $per_page");
$data = $db->cdp_registros();

$total_pages = ceil($numrows / $per_page);


if ($numrows > 0) { ?>
	<div class="table-responsive">
		<table id="zero_config" class="table table-condensed table-hover table-striped custom-table-checkbox">
			<thead>
				<tr>
					<th><b><?php echo $lang['ltracking'] ?></b></th>
					<th class="text-center"><b><?php echo $lang['ddate'] ?></b></th>
					<th class="text-center"><b><?php echo $lang['left499'] ?></b></th>
					<th class="text-center"><b><?php echo $lang['ldestination'] ?></b></th>
					<th class="text-center"><b><?php echo $lang['lpayment'] ?></b></th>
					<th class=""><b><?php echo $lang['ship-all5'] ?></b></th>
					<th class="text-center"></th>
					<th class="text-center"><b><?php echo $lang['lstatusshipment'] ?></b></th>
					<th class="text-center"><b><?php echo $lang['global-3'] ?></b></th>
				</tr>
			</thead>
			<tbody id="projects-tbl">


				<?php if (!$data) { ?>
					<tr>
						<td colspan="6">
							<?php echo "
				<i align='center' class='display-3 text-warning d-block'><img src='assets/images/alert/ohh_shipment.png' width='150' /></i>								
				", false; ?>
						</td>
					</tr>
				<?php } else { ?>

					<?php

					$count = 0;
					foreach ($data as $row) {

						$db->cdp_query("SELECT * FROM cdb_users where id= '" . $row->sender_id . "'");
						$sender_data = $db->cdp_registro();

						$db->cdp_query("SELECT * FROM cdb_recipients where id= '" . $row->receiver_id . "'");
						$receiver_data = $db->cdp_registro();

						$db->cdp_query("SELECT * FROM cdb_address_shipments where order_track='" . $row->order_prefix . $row->order_no . "'");
						$address_order = $db->cdp_registro();

						$db->cdp_query("SELECT * FROM cdb_users where id= '" . $row->driver_id . "'");
						$driver_data = $db->cdp_registro();

						$db->cdp_query("SELECT * FROM cdb_courier_com where id= '" . $row->order_courier . "'");
						$courier_com = $db->cdp_registro();

						$db->cdp_query("SELECT * FROM cdb_met_payment where id= '" . $row->order_pay_mode . "'");
						$met_payment = $db->cdp_registro();

						$db->cdp_query("SELECT * FROM cdb_shipping_mode where id= '" . $row->order_service_options . "'");
						$order_service_options = $db->cdp_registro();

						$db->cdp_query("SELECT * FROM cdb_styles where id= '14'");
						$status_style_pickup = $db->cdp_registro();

						$db->cdp_query("SELECT * FROM cdb_styles where id= '13'");
						$status_style_consolidate = $db->cdp_registro();


						if ($row->status_invoice == 1) {
							$text_status = $lang['invoice_paid'];
							$label_class = "label-success";
						} else if ($row->status_invoice == 0 || $row->status_invoice == 2) {
							$text_status = $lang['invoice_pending'];
							$label_class = "label-warning";
						} else if ($row->status_invoice == 3) {
							$text_status = $lang['invoice_due'];
							$label_class = "label-danger";
						}

					?>
						<tr class="card-hovera">

							<td><b><a href="courier_view.php?id=<?php echo $row->order_id; ?>"><?php echo $row->order_prefix . $row->order_no; ?></a></b></td>
							<td class="text-center">
								<?php echo $row->order_date; ?>
							</td>

							<td class="text-center">
								<?php echo $receiver_data->fname; ?> <?php echo $receiver_data->lname; ?>
							</td>

							<td class="text-center"><?php echo $address_order->recipient_country; ?>-<?php echo $address_order->recipient_city; ?></td>
							<td class="text-center"><?php echo $met_payment->name_pay; ?></td>

							<td class="text-center">
								<?php echo cdb_money_format($row->total_order); ?>
							</td>

							<td class="text-center">
								<?php if ($row->status_courier != 14) { ?>
									<?php if ($row->status_invoice == 2) { ?>
										<?php if ($userData->userlevel == 1) { ?>

											<a style="background: #34e89e;" class="label label" href="add_payment_gateways_courier.php?id_order=<?php echo $row->order_id; ?>">
												<i style="color:#343a40" class="fas fa-dollar-sign"></i>
												&nbsp;<?php echo $lang['leftorder32'] ?>
											</a>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							</td>

							<td class="">

								<span style="background: <?php echo $row->color; ?>;" class="label label-large"><?php echo $row->mod_style; ?></span>
								<br>

								<?php
								if ($row->is_pickup == true) { ?>

									<span style="background: <?php echo $status_style_pickup->color; ?>;" class="label label-large"><?php echo $status_style_pickup->mod_style; ?></span>
								<?php
								}
								?>

								<?php
								if ($row->is_consolidate == true) { ?>

									<span style="background: <?php echo $status_style_consolidate->color; ?>;" class="label label-large"><?php echo $status_style_consolidate->mod_style; ?></span>
								<?php
								}
								?>

								<?php if ($row->order_incomplete == 0) { ?>
									<?php if ($row->is_pickup == 0) { ?>
										<?php if ($userData->userlevel != 1) { ?>

											<span style="background: #5BE472;" class="label label-large">
												<?php echo $lang['leftorder34'] ?>
											</span>


										<?php } ?>
									<?php } ?>
								<?php } ?>

								<?php if ($row->order_incomplete == 0) { ?>
									<?php if ($row->is_pickup == 0) { ?>
										<?php if ($userData->userlevel != 9) { ?>
											<?php if ($userData->userlevel = 1) { ?>

												<span style="background: #FC5239;" class="label label-large">
													<?php echo $lang['left1018'] ?>
												</span>

											<?php } ?>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							</td>

							<td>
								<span class="label label-large <?php echo $label_class; ?>"><?php echo $text_status; ?></span>
						</tr>
					<?php $count++;
					} ?>

				<?php } ?>
			</tbody>

		</table>
		<div class="pull-right">
			<?php echo cdp_paginate($page, $total_pages, $adjacents, $lang);	?>
		</div>

	</div>
<?php } ?>