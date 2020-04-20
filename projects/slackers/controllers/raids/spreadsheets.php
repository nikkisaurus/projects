<?php

if (sizeof($_POST) != 0) {
	$files = array();

	foreach (scandir('logs') as $file) {
		if (!in_array($file, array('.', '..')) and strpos($file, $_POST['raid']) !== false) {
			$files[] = $file;
		}
	}

	arsort($files);

	$valid = array('dragonsoul', 'firelands', 'siegeoforgrimmar', 'tier11', 'tier14', 'throneofthunder', 'ulduar');

	if (in_array($_POST['raid'], $valid)) {
		Router::renderView(array('recent_file' => reset($files), 'raid' => $_POST['raid']));
	}
} else {
	Router::renderView();
}


