<?php

if (current_user() and isset($data['uid']) and (current_user()->user_id == $data['uid'] or current_user()->is_admin)) {
	db()->prepare("DELETE FROM `shoutbox` WHERE `id` = :id")->execute(array(':id' => $data['id']));
} elseif (current_user() and current_user()->is_admin) {
	db()->prepare("DELETE FROM `shoutbox` WHERE `id` = :id")->execute(array(':id' => $data['id']));
} else {
	relativeInclude('errors/denied');
	return;
}

