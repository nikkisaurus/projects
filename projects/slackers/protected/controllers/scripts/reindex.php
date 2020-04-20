<?php

if (!current_user() or !current_user()->is_admin) {
	relativeInclude('errors/denied');
	return;
} else {
	$error = false;
	$success = false;
	$tables = false;
	$successful = array();
	$database = 'slackers';
	$tables = db()->query("SELECT * FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '{$database}' AND `TABLE_NAME` != 'raiders' AND `TABLE_NAME` != 'users'")->fetchAll(PDO::FETCH_ASSOC);

	if (isset($_POST['table'])) {
		$table = $_POST['table'];

		if ($table == 'all') {
			foreach ($tables as $table_name) {
				$table_name = $table_name['TABLE_NAME'];
				$result = db()->query("SELECT `id` FROM `{$table_name}`")->fetchAll(PDO::FETCH_ASSOC);

				$i = 1;
				foreach ($result as $row) {
					if (db()->prepare("UPDATE `{$table_name}` SET `id` = :i WHERE `id` = :id")->execute(array(':i' => $i, ':id' => $row['id']))) {
						$i++;
					} else {
						$error = "<h2>Error</h2>There was a problem reinxdexing {$table_name}.";
						exit;
					}
				}

				$query = db()->prepare("ALTER TABLE `{$table_name}` AUTO_INCREMENT = {$i}")->execute();

				$count = db()->query("SELECT COUNT(id) FROM `{$table_name}`")->fetch(PDO::FETCH_ASSOC);
				$increment = db()->query("SELECT `AUTO_INCREMENT` FROM `information_schema`.`TABLES` WHERE `TABLE_NAME` = '{$table_name}' AND `TABLE_SCHEMA` = '{$database}'")->fetch(PDO::FETCH_ASSOC);

				$successful[$table_name] = "<h2>Success</h2>There are " . $count['COUNT(id)'] . " rows in the <strong>$table_name</strong> table_name and the next auto increment number is " . $increment['AUTO_INCREMENT'] . ".";
			}
		} else {
			$result = db()->query("SELECT `id` FROM `{$table}`")->fetchAll(PDO::FETCH_ASSOC);

			$i = 1;
			foreach ($result as $row) {
				if (db()->prepare("UPDATE `{$table}` SET `id` = :i WHERE `id` = :id")->execute(array(':i' => $i, ':id' => $row['id']))) {
					$i++;
				} else {
					$error = "<h2>Error</h2>There was a problem reinxdexing {$table}.";
					exit;
				}
			}

			$query = db()->prepare("ALTER TABLE `{$table}` AUTO_INCREMENT = {$i}")->execute();

			$count = db()->query("SELECT COUNT(id) FROM `{$table}`")->fetch(PDO::FETCH_ASSOC);
			$increment = db()->query("SELECT `AUTO_INCREMENT` FROM `information_schema`.`TABLES` WHERE `TABLE_NAME` = '{$table}' AND `TABLE_SCHEMA` = '{$database}'")->fetch(PDO::FETCH_ASSOC);

			$success = "<h2>Success</h2>There are " . $count['COUNT(id)'] . " rows in the <strong>$table</strong> table and the next auto increment number is " . $increment['AUTO_INCREMENT'] . ".";
		}
	}

	Router::renderView(array('protected' => true, 'error' => $error, 'success' => $success, 'tables' => $tables, 'successful' => $successful));
}
