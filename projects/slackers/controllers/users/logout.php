<?php

if (isset($_SESSION['usersession'])) {
	unset($_SESSION['usersession']);
	Router::redirect_to('');
	return;
}
