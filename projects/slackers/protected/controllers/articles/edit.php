<?php

if (!current_user()->is_mod) {
	relativeInclude('errors/denied');
	return;
} else {
	if (isset($data['id'])) {
		if (strlen($_POST['new_title']) > 97) {
			$_POST['new_title'] = substr($_POST['new_title'], 0, 97) . '...';
		}
		db()->prepare("UPDATE `articles` SET `title` = :title, `post` = :post, `updated_at` = :updated_at, `last_edited_by` = :last_edited_by WHERE `id` = :id")->execute(array(':title' => $_POST['new_title'], ':post' => $_POST['new_post'], 'updated_at' => date("Y-m-d H:i:s", time()), 'last_edited_by' => current_user()->user_id, ':id' => $data['id']));
	}
}
