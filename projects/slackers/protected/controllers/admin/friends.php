<?php

if (!current_user() or !current_user()->is_admin) {
	relativeInclude('errors/denied');
	return;
}

if (sizeof($_POST) == 0) {
	$friends = db()->query("SELECT * FROM `raiders` WHERE `friends` = 'y' AND `exempt` = 'n' ORDER BY `raider` ASC")->fetchAll();


	// var_dump($friends); exit;

	Router::renderView(array('protected' => true, 'friends' => $friends));
} else {

	}
