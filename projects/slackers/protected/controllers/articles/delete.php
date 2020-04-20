<?php

if (!current_user()->is_admin) {
	relativeInclude('errors/denied');
	return;
} else {
	if (isset($data['id'])) {
		db()->prepare("DELETE FROM `articles` WHERE `id` = :id")->execute(array(':id' => $data['id']));
	}
}
