<?php

if ($user = User::login($_POST['username'], $_POST['password'])) {
	$_SESSION['usersession'] = $user['verification_code'];
	Router::redirect_to('');
	return;
}

$_SESSION['login_error'] = 'Invalid login. <a href="' . relativeLink('users/forgot') . '">Forgot your login?</a>';
$page = ($_POST['current_page'] != '/' ? $_POST['current_page'] : '');

Router::redirect_to($page);
