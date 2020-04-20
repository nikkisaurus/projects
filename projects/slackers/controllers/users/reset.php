<?php

if (sizeof($_POST) != 0 and isset($data['c'])) {
	$result = db()->prepare("UPDATE `users` SET `password` = :password, `reset_code` = :new_code WHERE `reset_code` = :reset_code LIMIT 1");

	if ($result->execute(array(':password' => crypt($_POST['password'], '$2a$10$' . sha1(microtime()) . '$'), ':new_code' => sha1(rand(time(),time()+30849)), ':reset_code' => $data['c'])) and $result->rowCount() === 1) {
		$_SESSION['reset_success'] = "Your password has been reset.";
		Router::redirect_to('users/reset');
	} else {
		$_SESSION['reset_error'] = "This is an invalid reset link.";
		Router::renderView();
	}
} elseif (isset($data['c'])) {
	Router::renderView();
} elseif (isset($_SESSION['reset_success'])) {
	Router::renderView();
} else {
	$_SESSION['reset_error'] = "This is an invalid reset link.";
	Router::renderView();
}
