<?php
$rows = db()->query("SELECT `spent`.*, `raiders`.`raider`, date_format(date,'%b %e, %Y') AS datef FROM `spent` JOIN `raiders` ON `spent`.`raider_id` = `raiders`.`id`");

$spent_ds = array();
$spent_fl = array();
$spent_t11 = array();
$spent_t14 = array();
$spent_tot = array();
$spent_uld = array();


foreach ($rows as $spent_info) {
	switch($spent_info['raid']) {
		case 'ds':
		$spent_ds[] = $spent_info;
		break;
		case 'fl':
		$spent_fl[] = $spent_info;
		break;
		case 't11':
		$spent_t11[] = $spent_info;
		break;
		case 't14':
		$spent_t14[] = $spent_info;
		break;
		case 'tot':
		$spent_tot[] = $spent_info;
		break;
		case 'uld':
		$spent_uld[] = $spent_info;
		break;
	}
}

Router::renderView(array('spent_ds' => $spent_ds, 'spent_fl' => $spent_fl, 'spent_t11' => $spent_t11, 'spent_t14' => $spent_t14, 'spent_tot' => $spent_tot, 'spent_uld' => $spent_uld));
