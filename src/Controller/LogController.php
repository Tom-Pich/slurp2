<?php

namespace App\Controller;

use App\Lib\Firewall;
use App\Repository\UserRepository;

class LogController
{
	public static function logout()
	{
		session_destroy();
		header('Location: /');
	}

	public static function login($post)
	{
		$login = $post["login"];
		$password = htmlspecialchars($post["password"]);
		$redirect_url = $post["redirect-url"];
		$user = (new UserRepository)->getUserByLogin($login);

		$user_exists = $user !== null;
		$too_many_attempts = $_SESSION["attempt"] > 3;
		$passwords_match = $user->check_password($password);

		if ($user_exists && $passwords_match && !$too_many_attempts) {
			$_SESSION["id"] = $user->id;
			$_SESSION["login"] = $user->login;
			$_SESSION["Statut"] = $user->status;
			$_SESSION["attempt"] = 0;
			$_SESSION["user_ip"] = $_SERVER["REMOTE_ADDR"];
			$_SESSION["token"] = Firewall::generateToken(16);
			$_SESSION["time"] = time();
		} else {
			$_SESSION["attempt"] += 1;
			$_SESSION["info"] = "Login ou mot de passe non valide&nbsp;!";
			$_SESSION["token"] = Firewall::generateToken(16);
		}

		header('Location: ' . $redirect_url);
	}
}