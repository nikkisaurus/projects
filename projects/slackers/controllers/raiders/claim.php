<?php

if (current_user() and !current_user()->manually_verified) {
	if (sizeof($_POST) != 0) {
		if ($_POST['claim_code'] == '') {
			$error = "You didn't enter a code.";
		} else {
			$result = db()->prepare("SELECT * FROM `raiders` WHERE `claim_code` = :claim_code LIMIT 1");

			if ($result->execute(array(':claim_code' => $_POST['claim_code'])) and $result->rowCount() === 1) {
				$results = $result->fetch();

				$user = db()->prepare("SELECT * FROM `users` WHERE `raider_id` = :raider_id LIMIT 1");

				if ($user->execute(array(':raider_id' => $results['id'])) and $user->rowCount() === 1) {
					$error = "The character associated with that code has already been claimed.";
				} else {
					db()->prepare("UPDATE `users` SET `raider_id` = :raider_id, `group_id` = :group_id WHERE `id` = :user_id")->execute(array(':raider_id' => $results['id'], ':group_id' => 3, ':user_id' => current_user()->user_id));
					$_SESSION['claim_success'] = "You have successfully claimed " . $results['raider'] . ".";
				}
			} else {
				$error = "The claim code you entered is invalid.";
			}
		}

		if (isset($error)) {
			$_SESSION['claim_error'] = $error;
		}
		Router::redirect_to('raiders/claim');
	}
} elseif (current_user() and !isset($_SESSION['claim_success'])) {
	$error = "You have already claimed a toon.";
} elseif (!current_user()) {
	$error = "You must be logged in to claim a toon.";
}

if (isset($error)) {
	Router::renderView(array('error' => $error));
} elseif (sizeof($_POST) == 0) {
	Router::renderView();
}
