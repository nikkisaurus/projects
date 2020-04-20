<?php

if (current_user() and current_user()->is_admin) {
	if ($data['gid'] == 5) {
		$group_id = 5;
	} else {
		$group_id = $data['gid'] + 1;
	}
	
	db()->prepare("UPDATE `users` SET `group_id` = :group_id WHERE `id` = :id")->execute(array(':group_id' => $group_id, ':id' => $data['id']));
} else {
	relativeInclude('errors/denied');
	return;
}
