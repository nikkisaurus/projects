<?php

if (current_user()->email_validated and !isset($_SESSION['validation_success'])) {
	$error = "You've already validated your account.";
	$_SESSION['validation_error'] = $error;
} elseif (!isset($data['c'])) {
	if (!isset($_SESSION['validation_error']) and !isset($_SESSION['validation_success'])) {
		$_SESSION['validation_error'] = "You have not entered a validation code.";
	}
} else {
	$result = db()->prepare("SELECT * FROM `users` WHERE `verification_code` = :verification_code LIMIT 1");

	if ($result->execute(array(':verification_code' => $data['c'])) and $result->rowCount() === 1) {
		$user = $result->fetch();
		$user = (object) $user;

		if ($user->group_id > 1) {
			$error = "You've already validated your account.";
		} else {
			db()->prepare("UPDATE `users` SET `group_id` = :group_id WHERE `verification_code` = :verification_code LIMIT 1")->execute(array(':group_id' => 2, ':verification_code' => $data['c']));
		}
	} else {
		$error = "You've entered an invalid validation code.";
	}


	if (isset($error)) {
		$_SESSION['validation_error'] = $error;
	} else {
		$_SESSION['validation_success'] = "You've successfully validated your account.";
	}


	Router::redirect_to('users/validate');
	return;
}

Router::renderView();

