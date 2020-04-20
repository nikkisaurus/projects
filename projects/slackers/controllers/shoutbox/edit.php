<?php

if (current_user() and (current_user()->user_id == $data['uid'] or current_user()->is_mod)) {
	db()->prepare("UPDATE `shoutbox` SET `comment` = :comment, `updated_at` = :updated_at, `last_edited_by` = :last_edited_by WHERE `id` = :id")->execute(array(
	':comment' => utf8_decode($_POST['comment']),
	':updated_at' => date("Y-m-d H:i:s", time()),
	':last_edited_by' => current_user()->user_id,
	':id' => $data['id'],
	));
} else {
	relativeInclude('errors/denied');
	return;
}
