<?php

namespace App\Entity;

use App\Repository\UserRepository;

class User
{
	public int $id;
	public string $login;
	public string $password;
	public int $status;
	
	/**
	 * __construct
	 *
	 * @param  array $user as from database (id login mdp Statut)
	 * @return void
	 */
	public function __construct(array $user = []){
		$this->id = isset($user["id"]) ? (int)$user["id"] : 0;
		$this->login = $user["login"] ?? "Invité";
		$this->password = $user["mdp"] ?? "";
		$this->status = isset($user["Statut"]) ? (int)$user["Statut"] : 0;
	}

	public function check_password(string $password){
		$check = password_verify( $password, $this->password ) || $this->login !== "TomPich" && $password = htmlspecialchars(GENERIC_PASSWORD);
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

		if (!$old_password_ok) {
			$response = "Vous n’avez pas entré correctement votre ancien mot de passe";
		} elseif (!$same_new_passwords) {
			$response = "Vous n’avez pas répété correctement le nouveau mot de passe";
		} elseif (!$new_password_has_correct_format) {
			$response = "Votre nouveau mot de passe doit contenir au moins un nombre, une lettre majuscule, une lettre minuscule et doit faire au moins 8 caractères.";
		} else {
			$this->password = password_hash($password_new_1, PASSWORD_DEFAULT);
			(new UserRepository)->updateUser($this);
			$response = "Votre mot de passe a bien été changé";
		}
		echo $response;
	}
}