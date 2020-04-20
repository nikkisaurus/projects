<?php

if (current_user() and current_user()->is_mod) {
	$result = db()->prepare("SELECT * FROM `shoutbox` WHERE `approved` = :approved ORDER BY `id` DESC");

	if ($result->execute(array(':approved' => 2)) and $result->rowCount() >= 1) {
		$denied = $result->fetchAll(PDO::FETCH_ASSOC);

		Router::renderView(array('protected' => true, 'denied' => $denied));
	} else {
		Router::renderView(array('protected' => true));
	}
} else {
	relativeInclude('errors/denied');
	return;
}
