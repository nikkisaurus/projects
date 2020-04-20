<?php

if (!current_user() or !current_user()->is_admin) {
	relativeInclude('errors/denied');
	return;
}

if (sizeof($_POST) == 0) {
	$raiders = db()->query("SELECT * FROM `raiders` ORDER BY `raider` ASC")->fetchAll();

	Router::renderView(array('protected' => true, 'raiders' => $raiders));
} else {
	$doublepost = db()->prepare("SELECT * FROM `attendance` WHERE `openraid_id` = :orid LIMIT 1");

	if ($doublepost->execute(array(':orid' => $_POST['orid'])) and $doublepost->rowCount() === 1) {
		Router::redirect_to('admin/update');
	} else {

		$group = $_POST['group'];
		$multgroups = (isset($_POST['multgroups']) ? $_POST['multgroups'] : null);
		$raid = $_POST['raid'];
		$orid = $_POST['orid'];
		$date = $_POST['date'];
		$raiders = (isset($_POST['raiders']) ? $_POST['raiders'] : null);
		$new_raiders = (isset($_POST['new_raiders']) ? $_POST['new_raiders'] : null);
		$ids = array();
		$spent = array();
		$summary = array();

		$lastweek = db()->prepare("SELECT `week`, `group` FROM `attendance` WHERE `raid` = :raid ORDER BY `week` DESC LIMIT 1");

		if ($lastweek->execute(array(':raid' => $raid)) and $lastweek->rowCount() === 1) {
			$last_week = $lastweek->fetch(PDO::FETCH_ASSOC);
			if (isset($multgroups) and $last_week['group'] == $group) {
				$_SESSION['update_error'] = "You've already posted this group for the week.";
				Router::redirect_to('admin/update');
				return;
			}
			$last_week = $last_week['week'];
		}

		$lastgroupweek = db()->prepare("SELECT `group_week` FROM `attendance` WHERE `raid` = :raid AND `group` = :group ORDER BY `group_week` DESC LIMIT 1");

		if ($lastgroupweek->execute(array(':raid' => $raid, ':group' => $group)) and $lastgroupweek->rowCount() === 1) {
			$last_group_week = $lastgroupweek->fetch(PDO::FETCH_ASSOC);
			$last_group_week = $last_group_week['group_week'];
		} else {
			$last_group_week = 0;
		}

		$week = (isset($multgroups) ? $last_week : $last_week + 1);

		if (isset($raiders)) {
			$update = db()->prepare("UPDATE `raiders` SET `raider` = :raider, `server` = :server, `btag` = :btag, `friends` = :friends, `exempt` = :exempt WHERE `id` = :raider_id");

			foreach ($raiders as $id => $info) {
				$raiders[$id]['raider'] = utf8_decode($info['raider']);
				$raiders[$id]['btag'] = utf8_decode($info['btag']);
				$ids[] = strval($id);

				if ($info['spent'] != '') {
					$spent[$info['id']] = $info['spent'];
				}

				$update->execute(array(
					':raider' => $raiders[$id]['raider'],
					':server' => $raiders[$id]['server'],
					':btag' => $raiders[$id]['btag'],
					':friends' => $raiders[$id]['friends'],
					':exempt' => $raiders[$id]['exempt'],
					':raider_id' => $id
				));
			}
		}

		if (isset($new_raiders)) {
			$insert = db()->prepare("INSERT INTO `raiders` (`raider`, `server`, `btag`, `friends`, `exempt`, `claim_code`) VALUES (:raider, :server, :btag, :friends, :exempt, :claim_code)");
			$bonusinsert = db()->prepare("INSERT INTO `bonusrolls` (`raider_id`) VALUES (:raider_id)");

			foreach ($new_raiders as $id => $info) {
				$new_raiders[$id]['raider'] = utf8_decode($info['raider']);
				$new_raiders[$id]['btag'] = utf8_decode($info['btag']);

				$insert->execute(array(
					':raider' => $new_raiders[$id]['raider'],
					':server' => $info['server'],
					':btag' => $new_raiders[$id]['btag'],
					':friends' => $info['friends'],
					':exempt' => $info['exempt'],
					':claim_code' => sha1(rand(time(),time()+16985))
				));

				$id = db()->insert_id();

				if ($raid != 'soo') {
					$bonusinsert->execute(array(':raider_id' => $id));
				}

				$ids[] = $id;
			}
		}

		foreach ($ids as $raider) {
			$bonusrolls = db()->prepare("SELECT {$raid} FROM `bonusrolls` WHERE `raider_id` = :raider_id LIMIT 1");

			if (!$bonusrolls->execute(array(':raider_id' => $raider)) or $bonusrolls->rowCount() !== 1) {
				db()->prepare("INSERT INTO `bonusrolls` (`raider_id`) VALUES (:raider_id)")->execute(array(':raider_id' => $raider));
			}
		}

		$bonusrolls = db()->query("SELECT {$raid}, `raider_id` FROM `bonusrolls`")->fetchAll(PDO::FETCH_ASSOC);

		foreach ($bonusrolls as $raider) {
			$bonus = json_decode($raider[$raid], true);
			$raider_id = $raider['raider_id'];

			if ($bonus or in_array($raider_id, $ids)) {
				if (!$bonus) {
					$i = $week - 1;
					while ($i > 0) {
						$bonus[$i] = '0';
						$i--;
					}
				}

				$last_week = $week - 1;
				$two_weeks_ago = $week - 2;

				$last_bonus_roll = $bonus[$last_week];
				$prev_bonus_roll = $bonus[$two_weeks_ago];

				if ($two_weeks_ago > 0) {
					$attended_last_week = (intval($last_bonus_roll) > intval($prev_bonus_roll) or strpos($last_bonus_roll, '+') !== false);
				} else {
					$attended_last_week = ($last_bonus_roll == 5);
				}

				if (array_key_exists($raider_id, $spent)) {
					$bonus_roll = '5+';

					db()->prepare("INSERT INTO `spent` (`raider_id`, `raid`, `date`, `spent_amount`, `spent_on`) VALUES (:raider_id, :raid, :date, :spent_amount, :spent_on)")->execute(array(
						'raider_id' => $raider_id,
						'raid' => $raid,
						'date' => $date,
						'spent_amount' => $last_bonus_roll,
						'spent_on' => $spent[$raider_id]
					));
				} elseif ($attended_last_week and in_array($raider_id, $ids)) { // Attended last week and this week (+5 unless capped).
					if ($last_bonus_roll == '100+' or $last_bonus_roll == '100') {
						$bonus_roll = '100+';
					} elseif ($last_bonus_roll == '5+') {
						$bonus_roll = 10;
					} else {
						$bonus_roll = intval($last_bonus_roll) + 5;
					}
				} elseif (in_array($raider_id, $ids)) { // Didn't show up last week but did this week (+5 unless capped).
					if ($last_bonus_roll == '100-') {
						$bonus_roll = '100+';
					} else {
						$bonus_roll = intval($last_bonus_roll) + 5;
					}
				} elseif ($attended_last_week) { // Attended last week but not this week (bonus roll stays the same).
					if ($last_bonus_roll == '100+' or $last_bonus_roll == '100') {
						$bonus_roll = '100-';
					} elseif ($last_bonus_roll == '5+') {
						$bonus_roll = '5';
					} else {
						$bonus_roll = $last_bonus_roll;
					}
				} else { // Hasn't attended last week and didn't attend this week either (subtract 5 unless 0).
					if ($last_bonus_roll == '100-') {
						$bonus_roll = 95;
					} elseif ($last_bonus_roll == '0') {
						$bonus_roll = 0;
					} else {
						$bonus_roll = intval($last_bonus_roll) - 5;
					}
				}

				$bonus = array($week => strval($bonus_roll)) + $bonus;
				$bonus_rolls = json_encode($bonus, true);

				db()->prepare("UPDATE `bonusrolls` SET `{$raid}` = :bonus_rolls WHERE `raider_id` = :raider_id")->execute(array(':bonus_rolls' => $bonus_rolls, ':raider_id' => $raider_id));

				if (in_array($raider_id, $ids)) {
					$summary[$raider_id] = array('last_bonus_roll' => $last_bonus_roll, 'prev_bonus_roll' => $prev_bonus_roll, 'new_bonus' => $bonus_roll);
				}
			}
		}

		db()->prepare("
			INSERT INTO `attendance` (`raid`, `week`, `group`, `group_week`, `date`, `openraid_id`, `raiders`) VALUES (:raid, :week, :group, :group_week, :date, :openraid_id, :raiders)
		")->execute(array(
			':raid' => $raid,
			':week' => $week,
			':group' => $group,
			':group_week' => $last_group_week + 1,
			':date' => $date,
			':openraid_id' => $orid,
			':raiders' => json_encode($ids)
		));
		
		$_SESSION['update_summary'] = $summary;
		Router::redirect_to('admin/update');
	}
}
