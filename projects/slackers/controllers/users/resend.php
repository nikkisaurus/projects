<?php

$user = current_user();
$verification_code = $user->verification_code;

$to = $user->email;
$subject = "Niketa's Slackers: Account Verification"; 

$message = file_get_contents(__DIR__ . '/template2.php');
$find = array(':user', ':verification_code');
$replace = array(ucwords($user->username), $verification_code);
$message = str_replace($find, $replace, $message);

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Niketa <webmaster@niketa.net>' . "\r\n";

if (mail($to, $subject, $message, $headers)) {
	$_SESSION['resend_verification'] = "An email was resent to " . $user->email . " to validate your account.";

	Router::redirect_to('users/resent');
} else {
	echo 'We were unable to send verification to your email address.';
}
