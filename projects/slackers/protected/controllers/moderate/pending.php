<?php

if (current_user() and current_user()->is_mod) {
	$result = db()->prepare("SELECT * FROM `shoutbox` WHERE `approved` = :approved ORDER BY `id` DESC");

	if ($result->execute(array(':approved' => 0)) and $result->rowCount() >= 1) {
		$pending = $result->fetchAll(PDO::FETCH_ASSOC);

		Router::renderView(array('protected' =>true, 'pending' => $pending));
	} else {
		Router::renderView(array('protected' => true));
	}
} else {
	relativeInclude('errors/denied');
	return;
}
