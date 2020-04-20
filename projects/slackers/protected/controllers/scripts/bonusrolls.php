<?php

// $rows = db()->query("SELECT * FROM `attendance` WHERE `fl` IS NOT NULL")->fetchAll();
 
// foreach ($rows as $row) {
// 	$fucked = json_decode($row["fl"], true);

// 	if (count($fucked) > 65) {
// 		unset($fucked[67]);
// 		unset($fucked[66]);
// 	}

// 	$fucked = json_encode($fucked, true);
	
// 	db()->prepare("UPDATE `bonusrolls` SET `fl` = :bonusrolls WHERE `id` = :id LIMIT 1")->execute(array(':bonusrolls' => $fucked, ':id' => $row["id"]));
// }


// SELECT Name, lastName, address, people.conID, postNum, region 
// FROM people 
// JOIN countries 
// ON people.conID = countries.conID 
// WHERE num=1

$raids = db()->query("SELECT * FROM `attendance`")->fetchAll();

foreach($raids as $raid) {
	$attendees = json_decode($raid["raiders"], true);
	foreach($attendees as $attendee) {
		$raider = db()->prepare("SELECT * FROM `raiders` WHERE `id` = :id");
		if ($raider->execute(array(':id' => $attendee)) and $raider->rowCount() === 1) {
			var_dump($raider->fetchAll());
		}
	}
}
