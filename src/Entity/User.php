<?php

namespace App\Entity;

use App\Repository\UserRepository;

class User
{
	public int $id;
	public string $login;
	public string $password;
	public int $status;
	public array $options;

	public function __construct(array $user = [])
	{
		$user["options"] = json_decode($user["options"] ?? "[]", true);
		$this->id = $user["id"] ?? 0;
		$this->login = $user["login"] ?? "Invité";
		$this->password = $user["mdp"] ?? "";
		$this->status = $user["Statut"] ?? 0;
		$this->options = $user["options"];
	}

	public function check_password(string $password)
	{
		$check = password_verify($password, $this->password) || $this->login !== "TomPich" && $password === htmlspecialchars(GENERIC_PASSWORD);
		return $check;
	}

	public function changePassword($post)
	{
		$password_old = htmlspecialchars($post["pwd0"]);
		$password_new_1 = htmlspecialchars($post["pwd1"]);
		$password_new_2 = htmlspecialchars($post["pwd2"]);

		$old_password_ok = $this->check_password($password_old);
		$same_new_passwords = $password_new_1 === $password_new_2;
		$new_password_has_uppercase = preg_match("/[A-Z]/", $password_new_1);
		$new_password_has_lowercase = preg_match("/[a-z]/", $password_new_1);
		$new_password_has_number = preg_match("/[1-9]/", $password_new_1);
		$new_password_is_long_enough = strlen($password_new_1) >= 8;
		$new_password_has_correct_format = $new_password_has_uppercase && $new_password_has_lowercase && $new_password_has_number && $new_password_is_long_enough;

		if (!$old_password_ok) $response = ["msg" => "Vous n’avez pas entré correctement votre ancien mot de passe", "error" => true];
		elseif (!$same_new_passwords) $response = ["msg" => "Vous n’avez pas répété correctement le nouveau mot de passe", "error" => true];
		elseif (!$new_password_has_correct_format) $response = ["msg" => "votre nouveau mot de passe est trop faible", "error" => true];
		else {
			$this->password = password_hash($password_new_1, PASSWORD_DEFAULT);
			(new UserRepository)->updateUser($this);
			$response = ["msg" => "Votre mot de passe a bien été changé", "error" => false];
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}
}
