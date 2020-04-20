<?php

if (!current_user() or !current_user()->email_validated or !isset($_POST['shoutbox_comment']) or $_POST['shoutbox_comment'] == '' or current_user()->locked) {
	relativeInclude('errors/denied');
	return;
} elseif (!current_user()->manually_verified and isset($_POST['shoutbox_comment'])) {
	$lock = db()->prepare("SELECT * FROM `shoutbox` WHERE `user_id` = :user_id AND `created_at` > '" . date('Y-m-d H:i:s', time() - 300) . "'");

	if ($lock->execute(array(':user_id' => current_user()->user_id)) and $lock->rowCount() >= 4) {
		db()->prepare("UPDATE `users` SET `locked` = 1 WHERE `id` = :user_id")->execute(array(':user_id' => current_user()->user_id));
		echo "locked";
		return;
	}

	$wait = db()->prepare("SELECT * FROM `shoutbox` WHERE `user_id` = :user_id AND `created_at` > '" . date('Y-m-d H:i:s', time() - 60) . "'");

	if ($wait->execute(array(':user_id' => current_user()->user_id)) and $wait->rowCount() > 0) {
		echo "wait";
		return;
	}


	$comment = str_replace('>', '&gt;', str_replace('<', '&lt;', $_POST['shoutbox_comment']));
	$user_id = current_user()->user_id;

	db()->prepare("INSERT INTO `shoutbox` (created_at, updated_at, user_id, comment) VALUES (:created_at, :updated_at, :user_id, :comment)")->execute(array(
		':created_at' => date("Y-m-d H:i:s", time()),
		':updated_at' => date("Y-m-d H:i:s", time()),
		':user_id' => $user_id,
		':comment' => utf8_decode($comment)
	));
} else if (isset($_POST['shoutbox_comment'])) {
	$comment = str_replace('>', '&gt;', str_replace('<', '&lt;', $_POST['shoutbox_comment']));
	$user_id = current_user()->user_id;

	db()->prepare("INSERT INTO `shoutbox` (created_at, updated_at, user_id, comment, approved) VALUES (:created_at, :updated_at, :user_id, :comment, :approved)")->execute(array(
		':created_at' => date("Y-m-d H:i:s", time()),
		':updated_at' => date("Y-m-d H:i:s", time()),
		':user_id' => $user_id,
		':comment' => utf8_decode($comment),
		':approved' => 1
	));
} 
