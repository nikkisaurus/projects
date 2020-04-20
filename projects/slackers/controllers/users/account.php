<?php

if (!current_user()) {
	relativeInclude('errors/denied');
	return;
} elseif (sizeof($_POST) != 0) {

	$result = db()->prepare("SELECT * FROM `users` WHERE `email` = :email LIMIT 1");

	if ($result->execute(array(':email' => $_POST['new_email'])) and $result->rowCount() >= 1) {
		$error = "That email address is already in use.";
	}

	if (current_user()->password !== crypt($_POST['password'], current_user()->password)) {
		$error = "Your current password is incorrect.";
	} elseif ($_POST['new_password'] != $_POST['confirm_password']) {
		$error = "Your new passwords do not match.";
	} elseif ($_POST['new_email'] != '' and !filter_var($_POST['new_email'], FILTER_VALIDATE_EMAIL)) {
		$error = "You've entered an invalid email address.";
	} elseif ($_POST['new_email'] == current_user()->email) {
		$error = "You can't change your email address to your current email address.";
	} elseif ($_POST['new_password'] == '' and $_POST['confirm_password'] == '' and $_POST['new_email'] == '') {
		$error = "You haven't entered anything to update.";
	}

	if (isset($error)) {
		$_SESSION['update_error'] = $error;
		Router::redirect_to('users/account');
		return;
	} else {

		if ($_POST['new_password'] != '' and $_POST['new_email'] != '') {
			db()->prepare("UPDATE `users` SET `password` = :password, `email` = :email WHERE `id` = :user_id")->execute(array(':password' => crypt($_POST['new_password'], '$2a$10$' . sha1(microtime()) . '$'),':email' =>$_POST['new_email'], ':user_id' => current_user()->user_id));
		} elseif ($_POST['new_password'] != '') {
			db()->prepare("UPDATE `users` SET `password` = :password WHERE `id` = :user_id")->execute(array(':password' => crypt($_POST['new_password'], '$2a$10$' . sha1(microtime()) . '$'), ':user_id' => current_user()->user_id));
		} elseif ($_POST['new_email'] != '') {
			db()->prepare("UPDATE `users` SET `email` = :email WHERE `id` = :user_id")->execute(array(':email' =>$_POST['new_email'], ':user_id' => current_user()->user_id));
		}

		$_SESSION['update_success'] = "Your acount has successfully been updated.";

		Router::redirect_to('users/account');
		return;
	}
}

Router::renderView();
