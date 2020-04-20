<?php

function abcsort($a, $b) {
	return strcmp($a['raider'], $b['raider']);
}

$raid = (isset($data['raid']) ? $data['raid'] : null);

if (!isset($raid) or !raids($raid)) {
	relativeInclude('errors/404');
	return;
}

$result = db()->prepare("SELECT *, date_format(date,'%a %b %e, %Y') AS datef FROM `attendance` WHERE `raid` = :raid ORDER BY `week` DESC");
$result->execute(array(':raid' => $raid));

$weeks = array();
foreach ($result->fetchAll() as $group) {
	$weeks[$group['week']][] = $group;
}

foreach ($weeks as $week) {
	if (sizeof($week) == 2) {
		$group = $week[0];
		$group2 = $week[1];

		$group['title'] = "Week {$group['week']}" . " & Week {$group2['group_week']}";
		$group['week'] = $group['week'] . '_' . $group2['group_week'];
		$group['dates'] = array($group['datef']);
		$group['links'] = array($group['openraid_id']);
		$group['dates'][] = $group2['datef'];
		$group['links'][] = $group2['openraid_id'];

		$raiders = json_decode($group['raiders'], true);
		$group['raiders'] = array();

		$raider = db()->prepare("SELECT `id`, `raider`, `server` FROM `raiders` WHERE `id` = :id LIMIT 1");

		if (is_array($raider)) {

			foreach ($raiders as $raider_id) {
				$raider->execute(array(':id' => $raider_id));
				$raider_info = $raider->fetch(PDO::FETCH_ASSOC);

				$group['raiders'][] = $raider_info;
			}

			usort($group['raiders'], "abcsort");
		}
		$attendance[] = $group;
	} else {
		$group = $week[0];

		$group['title'] = "Week {$group['week']}";
		$group['week'] = $group['week'];
		$group['dates'] = array($group['datef']);
		$group['links'] = array($group['openraid_id']);

		$raiders = json_decode($group['raiders'], true);
		$group['raiders'] = array();

		$raider = db()->prepare("SELECT `id`, `raider`, `server` FROM `raiders` WHERE `id` = :id LIMIT 1");

		foreach ($raiders as $raider_id) {
			$raider->execute(array(':id' => $raider_id));
			$raider_info = $raider->fetch(PDO::FETCH_ASSOC);

			$group['raiders'][] = $raider_info;
		}

		usort($group['raiders'], "abcsort");
		$attendance[] = $group;
	}
}

Router::renderView(array('title' => raids($raid)->abbreviated_proper, 'weeks' => $attendance));
