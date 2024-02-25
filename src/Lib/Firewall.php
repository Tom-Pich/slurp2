<?php

namespace App\Lib;

use App\Controller\Error404Controller;

abstract class Firewall
{
	static function redirect_to_404()
	{
		$page = new Error404Controller;
		$page->show();
		die();
	}

	static function filter(int $status)
	{
		$session_status = $_SESSION["Statut"] ?? 0;
		//$user_ip = $_SESSION["user_ip"] ?? "";
		if ($session_status < $status ||/*  $user_ip !== $_SERVER["REMOTE_ADDR"] || */ !isset($_SESSION["token"])) {
			self::redirect_to_404();
		}
	}

	static function check(bool $assert)
	{
		if (!$assert) {
			self::redirect_to_404();
		}
	}

	static function generateToken($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$range = strlen($characters)-1;
		$token = "";
		for ($i = 0; $i < $length; ++$i) {
			$position = random_int(0, $range);
			$token .= $characters[$position];
		}
		return $token;
	}

	static function checkToken(){
		if(!isset($_POST["token"]) || $_POST["token"] !== $_SESSION["token"] ){
			self::redirect_to_404();
		}
	}
}
