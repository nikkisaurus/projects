<?php
class User
{
	public static function login($username, $password) {

		$result = db()->prepare("SELECT * FROM `users` WHERE `username` = :username LIMIT 1 ");

		if ($result->execute(array(':username' => $username)) and $result->rowCount() === 1) {
			$user = $result->fetch();

			if ($user['password'] === crypt($password, $user['password'])) {
				return $user;
			}
		}

		return false;
	}
}
