<?php

if (!current_user() or !current_user()->is_admin) {
	relativeInclude('errors/denied');
	return;
} else {
	set_time_limit(0);
	$raids = array("ds", "fl", "soo", "t11", "t14", "tot", "uld");
	foreach ($raids as $raid) {

		// Clear row.
		db()->prepare("UPDATE `bonusrolls` SET `{$raid}` = NULL")->execute();

		// Query attendance table to get all raid weeks for current week.
		$attendance = db()->prepare("SELECT * FROM `attendance` WHERE `raid` = :raid AND `group` != :group ORDER BY `week` ASC");

		// If raids are found, execute code.
		if ($attendance->execute(array(':raid' => $raid, ':group' => 2)) and $attendance->rowCount() !== 0) {
			// Fetch raids.
			$raids = $attendance->fetchAll();

			// Loop over each raid.
			foreach ($raids as $current_raid) {
				$attendees = json_decode($current_raid['raiders'], true);
				$raid_date = $current_raid['date'];

				// Week numbers:
				$week = $current_raid['week'];
				$last_week = $week > 1 ? $week - 1 : null;

				// Get last week's attendees.
				$last_week_attendees = db()->prepare("SELECT `raiders` FROM `attendance` WHERE `raid` = :raid AND `week` = :last_week AND `group` != :group ");
				
				if ($last_week_attendees->execute(array(':raid' => $raid, ':last_week' => $last_week, ':group' => 2)) and $last_week_attendees->rowCount() === 1) {
					$last_week_attendees = json_decode($last_week_attendees->fetchAll()[0]['raiders'], true);
				}

				// Loop over each person who attended and update bonus.
				foreach ($attendees as $raider) {
					$bonus_rolls = db()->prepare("SELECT {$raid} FROM `bonusrolls` WHERE `raider_id` = :raider");
					// If raider is in bonus roll table, get new value and update.
					if ($bonus_rolls->execute(array(':raider' => $raider)) and $bonus_rolls->rowCount() === 1) {
						$bonus_rolls = json_decode($bonus_rolls->fetchAll()[0][$raid], true);

						if (count($bonus_rolls) <= 0) { // First time attending
							$new_bonus = array();
							// Set previous weeks to 0.
							for ($i = 1; $i < $week; $i++) {
								$new_bonus[$i] = "0";
							}

							// Set current week
							$new_bonus[$week] = "5";

							// Update row.
							krsort($new_bonus);
							$new_bonus = json_encode($new_bonus, true);
							db()->prepare("UPDATE `bonusrolls` SET `{$raid}` = :new_bonus WHERE `raider_id` = :raider")->execute(array(':new_bonus' => $new_bonus, ':raider' => $raider));
						} else { // Have attended before, get previous rolls.
							$spent = db()->prepare("SELECT * FROM `spent` WHERE `raider_id` = :raider AND `raid` = :raid AND `date` = :raid_date");
							if ($spent->execute(array(':raider' => $raider, ':raid' => $raid, ':raid_date' => $raid_date)) and $spent->rowCount() === 1) {
								$new_bonus = "5+";
							} else {
								$new_bonus = intval($bonus_rolls[$last_week]) + 5 > 100 ? "100+" : strval(intval($bonus_rolls[$last_week]) + 5);
							}
							$bonus_rolls[$week] = $new_bonus;
							krsort($bonus_rolls);
							$new_bonus = json_encode($bonus_rolls, true);

							db()->prepare("UPDATE `bonusrolls` SET `{$raid}` = :new_bonus WHERE `raider_id` = :raider")->execute(array(':new_bonus' => $new_bonus, ':raider' => $raider));
						}
					} else { // Add raider to bonus rolls table with initial bonus roll value.
						$insert = db()->prepare("INSERT INTO `bonusrolls` (`raider_id`) VALUES (:raider_id)")->execute(array(':raider_id' => $raider));
						
						$new_bonus = array();
						// Set previous weeks to 0.
						for ($i = 1; $i < $week; $i++) {
							$new_bonus[$i] = "0";
						}

						// Set current week
						$new_bonus[$week] = "5";

						// Update row.
						krsort($new_bonus);
						$new_bonus = json_encode($new_bonus, true);
						db()->prepare("UPDATE `bonusrolls` SET `{$raid}` = :new_bonus WHERE `raider_id` = :raider")->execute(array(':new_bonus' => $new_bonus, ':raider' => $raider));
					}
				}

				// Adjust everyone else.
				$all_raiders = db()->query("SELECT {$raid}, `raider_id` FROM `bonusrolls` WHERE `{$raid}` IS NOT NULL")->fetchAll();

				// Loop over each raider and adjust their bonus.
				foreach ($all_raiders as $raider) {
					$bonus_rolls = json_decode($raider[$raid], true);

					// If they are not at the current week, fix. This means they did not attend this week.
					if (!array_key_exists($week, $bonus_rolls)) {
						$last_bonus = $last_week ? $bonus_rolls[$last_week] : null;
						$attended_last_week = in_array($raider['raider_id'], $last_week_attendees);

						if ($attended_last_week) {
							$new_bonus = intval($last_bonus) != 100 ? $last_bonus : "100-";
						} else {
							$new_bonus = intval($bonus_rolls[$last_week]) - 5 < 0 ? "0" : strval(intval($bonus_rolls[$last_week]) - 5);
						}

						$bonus_rolls[$week] = $new_bonus;
						krsort($bonus_rolls);
						$new_bonus = json_encode($bonus_rolls, true);

						db()->prepare("UPDATE `bonusrolls` SET `{$raid}` = :new_bonus WHERE `raider_id` = :raider")->execute(array(':new_bonus' => $new_bonus, ':raider' => $raider['raider_id']));
					}
				}
			}
		}
	}
}
