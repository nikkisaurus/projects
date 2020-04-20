<?php

if (current_user() and isset($data['uid']) and (current_user()->user_id == $data['uid'] or current_user()->is_mod)) {
	$post = db()->prepare("UPDATE `shoutbox` SET `approved` = '2' WHERE `id` = :id")->execute(array(':id' => $data['id']));
} elseif (current_user() and current_user()->is_mod) {
	$post = db()->prepare("UPDATE `shoutbox` SET `approved` = '2' WHERE `id` = :id")->execute(array(':id' => $data['id']));
} else {
	relativeInclude('errors/denied');
	return;
}

