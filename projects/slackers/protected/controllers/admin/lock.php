<?php

if (current_user() and current_user()->is_admin) {
	(userinfo($data['id'])->locked == 1 ? db()->prepare("UPDATE `users` SET `locked` = null WHERE `id` = :id")->execute(array(':id' => $data['id'])) : db()->prepare("UPDATE `users` SET `locked` = :locked WHERE `id` = :id")->execute(array(':locked' => 1, ':id' => $data['id'])));
} else {
	relativeInclude('errors/denied');
	return;
}
