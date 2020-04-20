<?php

if (current_user() and current_user()->is_mod) {
	$post = db()->prepare("UPDATE `shoutbox` SET `approved` = '1' WHERE `id` = :id")->execute(array(':id' => $data['id']));
} else {
	relativeInclude('errors/denied');
	return;
}
