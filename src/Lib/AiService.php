<?php

namespace App\Lib;

// Peut-être un jour...
class AiService
{
	private string $apiKey;
	private ?string $endpoint = NULL;

	public function __construct()
	{
		$this->apiKey = $_ENV["AI_API_KEY"];
	}

	public function ask(string $prompt): mixed
	{
		$payload = json_encode([
			"model" => NULL,
			"messages" => [
				["role" => "system", "content" => "Tu es l’assistant d’un maître de jeu au cours d’une partie de JdR sur table. Tu dois l’aider dans ses séquences d’improvisation. Ne prends pas d’initiative scénaristique, contente-toi de rédiger la description demandée."],
				["role" => "user", "content" => $prompt]
			],
			"max_tokens" => 300,
		]);

		$ch = curl_init($this->endpoint);
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_POST            => true,
			CURLOPT_POSTFIELDS      => $payload,
			CURLOPT_HTTPHEADER      => [
				"Authorization: Bearer $this->apiKey",
				"Content-Type: application/json",
			],
			CURLOPT_SSL_VERIFYPEER  => IS_ONLINE,
		]);

		$response = json_decode(curl_exec($ch), true);
		return $response;
		return $response["choices"][0]["message"]["content"] ?? "";
	}
}
