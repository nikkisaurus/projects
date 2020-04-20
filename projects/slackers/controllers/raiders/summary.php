<?php

if (isset($data['id'])) {

	$raider = db()->prepare("SELECT * FROM `raiders` WHERE `id` = :id LIMIT 1");

	if ($raider->execute(array(':id' => $data['id'])) and $raider->rowCount() === 1) {
		$raiders = $raider->fetch();

		$query = db()->prepare("SELECT * FROM `bonusrolls` WHERE `raider_id` = :id");

		if ($query->execute(array(':id' => $data['id'])) and $query->rowCount() === 1) {
			$results = $query->fetch(PDO::FETCH_ASSOC);
			$raids = $results;
		}

		$user = db()->prepare("SELECT * FROM `users` WHERE `raider_id` = :id LIMIT 1");

		if ($user->execute(array(':id' => $data['id'])) and $user->rowCount() === 1) {
			$users = $user->fetch();
			$users = (object) $users;
			Router::renderView(array('raider' =>$raiders, 'raids' => $raids, 'user' => $users));
			return;
		}

		if (isset($raids)) {
			Router::renderView(array('raider' =>$raiders, 'raids' => $raids));
		} else {
			Router::renderView(array('raider' =>$raiders));
		}
	}

} else {
	$raider = db()->query("SELECT * FROM `raiders` ORDER BY `raider` ASC");

	if ($raider->rowCount() >= 1) {
		$raiders = $raider->fetchAll();
		Router::renderView(array('raiders' =>$raiders));
	}
}
