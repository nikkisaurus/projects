<?php
foreach($_POST as $name => $value) {
	if ($value == '') {
		$error = 'Please fill in all of the required information.';
	} elseif ($name != 'password' and $name != 'password2') {
		$_POST[$name] = strtolower($value);
	}
}

$result = db()->prepare("SELECT * FROM `users` WHERE `username` = :username OR `email` = :email");

if ($result->execute(array(':username' => $_POST['username'], ':email' => $_POST['email'])) and $result->rowCount() === 1) {
	$results = $result->fetch();
	foreach($results as $name => $value) {
		$results[$name] = strtolower($value);
	}
}

$security_answer = db()->prepare("SELECT `answer` FROM `security_questions` WHERE `id` = :id LIMIT 1");

if ($security_answer->execute(array(':id' => $_POST['question_id'])) and $security_answer->rowCount() === 1) {
	$security_answer = $security_answer->fetch();	
	$security_answer = json_decode($security_answer['answer'], true);
}

if (isset($results)) {
	if ($results['username'] == $_POST['username']) {
		$error = 'The username ' . $_POST['username'] . ' has already been taken.';
	} elseif ($results['email'] == $_POST['email']) {
		$error = 'The email ' . $results['email'] . ' has already been taken.';
	} 
} elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $_POST['username'])) {
	$error = "Usernames may only contain letters, numbers and underscores.";
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$error = "You've entered an invalid email address.";
} elseif (!in_array($_POST['security_question'], $security_answer)) {
	$error = "You've incorrectly answered the security question.";
} elseif ($_POST['password'] != $_POST['password2']) {
	$error = "The passwords you entered do not match.";
}

if (isset($error)) {
	$_SESSION['register_error'] = $error;
	$page = ($_POST['current_page'] != '/' ? $_POST['current_page'] : '');

	Router::redirect_to($page);
	exit;
}

$verification_code = sha1(rand(time(),time()+78779));
$reset_code = sha1(rand(time(),time()+30849));

$to = $_POST['email'];
$subject = "Niketa's Slackers: Account Verification"; 

$message = file_get_contents(__DIR__ . '/template.php');
$find = array(':user', ':verification_code');
$replace = array(ucwords($_POST['username']), $verification_code);
$message = str_replace($find, $replace, $message);

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Niketa <webmaster@niketa.net>' . "\r\n";

if (mail($to, $subject, $message, $headers)) {
	db()->prepare("
		INSERT INTO
			`users` (`updated_at`, `username`, `password`, `email`, `group_id`, `verification_code`, `reset_code`, `tracker`)
		VALUES (:updated_at, :username, :password, :email, :group_id, :verification_code, :reset_code, :tracker)
	")->execute(array(
		':updated_at' => date('Y-m-d H:i:s'),
		':username' => $_POST['username'],
		':password' => crypt($_POST['password'], '$2a$10$' . sha1(microtime()) . '$'),
		':email' => $_POST['email'],
		':group_id' => 1,
		':verification_code' => $verification_code, 
		':reset_code' => $reset_code,
		':tracker' => getenv('REMOTE_ADDR')
	));

	$_SESSION['register_success'] = "An email was sent to " . $_POST['email'] . " to verify your account. Be sure to check your junk folder (and mark it as not junk) if you can't find it in your inbox.";
	$_SESSION['usersession'] = $verification_code;

	// Send email to webmaster to alert new account.
	mail('webmaster@niketa.net', "New Account", "<strong>New Account</strong><br /><br />Username: " . $_POST['username'] . "<br />Email: " . $_POST['email'] . "<br />Created at " . date('m/d/Y h:i a') . ".", 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . 'From: Niketa <webmaster@niketa.net>' . "\r\n");

	Router::redirect_to('welcome');
} else {
	$error = 'We were unable to send a verification to your email address and as such your account has not been created.';
	$_SESSION['register_error'] = $error;
	$page = ($_POST['current_page'] != '/' ? $_POST['current_page'] : '');

	Router::redirect_to($page);
	exit;
}
