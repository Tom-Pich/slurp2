<?php

namespace App\Controller;

use App\Lib\Firewall;
use App\Repository\UserRepository;

class LogController
{
	public static function logout()
	{
		session_regenerate_id(true);
		session_destroy();
		header('Location: /');
	}

	public static function login($post)
	{
		$login = $post["login"];
		$password = htmlspecialchars($post["password"] ?? "");
		$redirect_url = $post["redirect-url"] ?? "/";

		$user = (new UserRepository)->getUserByLogin($login);
		$user_is_guest = $user->id === 0;
		$user_exists = $user !== null;
		$too_many_attempts = $_SESSION["attempt"] > 3;
		$passwords_match = $user->check_password($password);

		if ($user_is_guest || $user_exists && $passwords_match && !$too_many_attempts) {
			if (!$user_is_guest) session_regenerate_id(true);
			$_SESSION["id"] = $user->id;
			$_SESSION["login"] = $user->login;
			$_SESSION["Statut"] = $user->status;
			$_SESSION["attempt"] = 0;
			$_SESSION["token"] = Firewall::generateToken(16);
			$_SESSION["time"] = time();
			$_SESSION["user-options"] = $user->options;
			$_SESSION["browser_fingerprint"] = self::generateBrowserFingerprint();
		} else {
			$_SESSION["attempt"] += 1;
			$_SESSION["info"] = "Login ou mot de passe non valide !";
			$_SESSION["token"] = Firewall::generateToken(16);
		}

		header('Location: ' . $redirect_url);
	}

	public static function generateBrowserFingerprint()
	{
		$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
		$acceptLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
		$ipSegments = explode('.', $_SERVER['REMOTE_ADDR']);
		$partialIP = implode('.', array_slice($ipSegments, 0, 2)); // First 2 octets only
		$fingerprintData = $userAgent . $acceptLang . $partialIP;
		return hash('sha256', $fingerprintData);
	}

	public static function checkSessionValidity()
	{
		if (!isset($_SESSION["id"]) || !DB_ACTIVE) {
			// set guest profile if no session
			self::login(["login" => "Invité"]);
		} else {
			// handle session validity if session exists
			$user_is_guest = $_SESSION["id"] === 0;
			$session_expired = $_SESSION["time"] < (time() - SESSION_DURATION);
			$invalid_browser_fingerprint = empty($_SESSION["browser_fingerprint"]) || $_SESSION["browser_fingerprint"] !== LogController::generateBrowserFingerprint();

			if ($user_is_guest || !$session_expired) $_SESSION["time"] = time();
			if ($session_expired || $invalid_browser_fingerprint) LogController::logout();
		}
	}
}
