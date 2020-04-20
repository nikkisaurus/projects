<?php

function referencePath($page, $ext = 'php') {
	return directoriesFromHost(fullURL()) . getURI($page) . '.' . $ext;
}

function relativeLink($page) {
	return directoriesFromHost(fullURL()) . getURI($page);
}


function relativeInclude($page, $ext = 'php') {
	include(str_replace('\\', '/', dirname(dirname(dirname(__FILE__)))) . '/' . $page . '.' . $ext);
}

function fullURL() {
	return $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function getURI($page) {
	if (($pos = strpos($page, DOMAIN)) !== false) {
	   $uri = substr($page, $pos + strlen(DOMAIN));
	} elseif (($pos = strpos($page, LOCALHOST)) !== false) {
	   $uri = substr($page, $pos + strlen(LOCALHOST));
	} else {
		$uri = $page;
	}

	return $uri;
}

function directoriesFromHost($url) {
	if (strpos($url, LOCALHOST) !== false) {
		$url = str_replace(LOCALHOST, '', $url);
	} elseif (strpos($url, DOMAIN) !== false) {
		$url = str_replace(DOMAIN, '', $url);
	}

	if ($url == '/') {
		return '';
	}

	$i = substr_count($url, '/');
	$return = '';

	for ($x=1; $x<=$i; $x++) {
		if (strpos($return, '..') === 0) {
			$return = '../' . $return;
		} else {
	 		$return = '.' . $return;
		}
	}

	return $return . '/';
}

function db() {
	global $db;
	return $db;
}

function time_format($timestamp) {
	$time = strtotime($timestamp);
	$now = time();
	$difference = ($now - $time)/86400;

	if ($difference >= 1) {
		$result = date('m/d/y', strtotime($timestamp));
	} else {
		$result = date('h:i a', strtotime($timestamp));
	}

	echo $result;
}

function time_prefix($timestamp) {
	$time = strtotime($timestamp);
	$now = time();
	$difference = ($now - $time)/86400;

	if ($difference >= 1) {
		$result = "on";
	} else {
		$result = "at";
	}

	echo $result;
}

function raids($raid) {
	if (Raid::validate($raid)) {
		global $$raid;
		return $$raid;
	}
}

function session_message($session) {
	if (isset($_SESSION[$session])) {
		$msg = $_SESSION[$session];
		unset($_SESSION[$session]);
		echo $msg;
	}
	return false;
}

function current_user() {
	if (isset($_SESSION['usersession'])) {
		$result = db()->prepare("SELECT *, users.id as user_id FROM `users` JOIN `groups` ON (users.group_id = groups.id) WHERE `verification_code` = :verification_code LIMIT 1");

		if ($result->execute(array(':verification_code' => $_SESSION['usersession'])) and $result->rowCount() === 1) {
			$user = $result->fetch();
			$user['username'] = ucwords($user['username']);
			return (object) $user;
		}
	}

	return false;
}

function generate_security_question() {
	$result = db()->query("SELECT * FROM `security_questions` ORDER BY RAND() LIMIT 1");
	$results = $result->fetch();
	return (object) $results;
}

function userinfo($user_id) {
	$result = db()->prepare("SELECT * FROM `users` WHERE `id` = :user_id LIMIT 1");

	if ($result->execute(array(':user_id' => $user_id)) and $result->rowCount() === 1) {
		$user = $result->fetch();

		return (object) $user;
	} else {
		return false;
	}
}

function raiderinfo($raider_id) {
	$result = db()->prepare("SELECT * FROM `raiders` WHERE `id` = :raider_id LIMIT 1");

	if ($result->execute(array(':raider_id' => $raider_id)) and $result->rowCount() === 1) {
		$raider = $result->fetch(PDO::FETCH_ASSOC);
		return (object) $raider;
	} else {
		return false;
	}
}

function groupinfo($group_id) {
	$result = db()->prepare("SELECT * FROM `groups` WHERE `id` = :group_id LIMIT 1");

	if ($result->execute(array(':group_id' => $group_id)) and $result->rowCount() === 1) {
		$group = $result->fetch();

		return (object) $group;
	} else {
		return false;
	}
}

function process_tags($post) {
	return $post;
}

function post_count($type) {
	$count = db()->prepare("SELECT * FROM `shoutbox` WHERE `approved` = :approved ORDER BY `id` DESC");
	if ($count->execute(array(':approved' => $type)) and $count->rowCount() >= 1) {
		echo $count->rowCount();
	} else {
		echo 0;
	}
}
