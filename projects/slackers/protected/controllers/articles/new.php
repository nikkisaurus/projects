<?php

if (!current_user()->is_mod) {
	relativeInclude('errors/denied');
	return;
} else {
	if (isset($_POST['title']) and isset($_POST['post'])) {	
		if (strlen($_POST['title']) > 97) {
			$_POST['title'] = substr($_POST['title'], 0, 97) . '...';
		}
		db()->prepare("INSERT INTO `articles` (`created_at`, `updated_at`, `user_id`, `title`, `post`) VALUES (:created_at, :updated_at, :user_id, :title, :post)")->execute(array(':created_at' => date("Y-m-d H:i:s", time()), ':updated_at' => date("Y-m-d H:i:s", time()), ':user_id' => current_user()->user_id, ':title' => $_POST['title'], ':post' => $_POST['post']));
		$_SESSION['refresh_last_updated'] = true;
		Router::redirect_to('');
	} else {
		Router::renderView(array('protected' => true));
	}
}
