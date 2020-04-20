<?php

if (isset($data['id']) and !userinfo($data['id'])) {
	relativeInclude('errors/404');
	return;
} elseif (!isset($data['id'])) {
	$users = db()->query("SELECT * FROM `users` WHERE `group_id` > 1 ORDER BY `username` ASC")->fetchAll();

	Router::renderView(array('users' => $users));
} else {
	$user = userinfo($data['id']);

	Router::renderView(array('user' => $user));
}
