<?php

if (sizeof($_POST) == 0) {
	Router::renderView();
} else {
	$result = db()->prepare("SELECT * FROM `users` WHERE `email` = :email LIMIT 1");

	if ($result->execute(array(':email' => $_POST['email'])) and $result->rowCount() === 1) {
		$user = $result->fetch(PDO::FETCH_ASSOC);
		$user = (object) $user;

		$reset_code = $user->reset_code;

		$to = $_POST['email'];
		$subject = "Niketa's Slackers: Reset Password"; 

		$message = file_get_contents(__DIR__ . '/template3.php');
		$find = array(':username', ':reset_code');
		$replace = array(ucwords($user->username), $reset_code);
		$message = str_replace($find, $replace, $message);

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Niketa <webmaster@niketa.net>' . "\r\n";

		if (mail($to, $subject, $message, $headers)) {
			$_SESSION['reset_sent'] = "An email was sent to " . $_POST['email'] . " to reset your password.";

			Router::redirect_to('users/forgot');
		} else {
			$error = 'We were unable to send a password reset to your email address.';
		}

	} elseif ($_POST['email'] == '') {
		$error = "Please enter an email address.";
	} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$error = "You've entered an invalid email address.";
	} else {
		$error = "There is no account associated with " . $_POST['email'] . ".";
	}

	if (isset($error)) {
		$_SESSION['forgot_error'] = $error;
		Router::redirect_to('users/forgot');
	}
	
}
