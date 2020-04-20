<?php

$raid = (isset($data['raid']) ? $data['raid'] : null);

if (!isset($raid) or !raids($raid)) {
	relativeInclude('errors/404');
	return;
}

$result = db()->query("SELECT * FROM `bonusrolls` JOIN `raiders` ON `raiders`.`id` = `bonusrolls`.`raider_id` ORDER BY `raiders`.`raider`")->fetchAll(PDO::FETCH_ASSOC);
$raider = array();
$bonusrolls = array();
$weeks = array();
$rolls = array();

foreach ($result as $result) {
	$bonusrolls = json_decode($result[$raid], true);
	if (is_array($bonusrolls)) {
		$week_min = sizeof($bonusrolls) - 5;
		$week_max = sizeof($bonusrolls);
		if ($bonusrolls[$week_max] > 0) {
			foreach ($bonusrolls as $week => $roll) {
				if ($week > $week_min) {
					$date_result = db()->prepare("SELECT `date` FROM `attendance` WHERE `raid` = :raid AND `group_week` = :week");
					if ($date_result->execute(array(':raid' => $raid, ':week' => $week)) and $date_result->rowCount() === 1) {
						$date_results = $date_result->fetch(PDO::FETCH_ASSOC);
						$weeks[$week] = $date_results;
					}
					$rolls[$week] = intval($roll);
				}
			}
			$rolls['raider_id'] = $result['raider_id'];
			$raider[raiderinfo($result['raider_id'])->raider] = $rolls;
		}
	}
}

function mysort($a, $b) {
    if (reset($a) != reset($b)) {
        return reset($a) < reset($b) ? 1 : -1;
    } else {
        // reset($a) == $b[0], sort on key
        return raiderinfo($a['raider_id'])->raider < raiderinfo($b['raider_id'])->raider ? -1 : 1; // ASC
    }
}

uasort($raider, "mysort");

Router::renderView(array('weeks' => $weeks, 'raider' => $raider, 'raid' => $raid));
