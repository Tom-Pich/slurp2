<?php

namespace App\Lib;

class AiService
{
	private string $apiKey;
    private string $endpoint = "https://generativelanguage.googleapis.com/v1beta/openai/chat/completions";
    private string $model = "gemini-2.5-flash";
	private const SYSTEM_PROMPT = <<<'PROMPT'
		Tu es l’assistant d’un maître de jeu au cours d’une partie de jeu de rôle sur table. Ton rôle est de l’aider dans ses improvisations rapides. 

		Consignes strictes :
		1. Ne prends aucune initiative scénaristique ou narrative. Limite-toi strictement à répondre à la demande de l’utilisateur.
		2. Rédige tes réponses dans un style concis (400 caractères max), factuel et télégraphique, adapté à une improvisation rapide en jeu.
		3. N’utilise jamais de formatage Markdown (pas d’astérisques, pas de dièses, pas de tirets de liste Markdown).
		4. Pour la mise en forme, utilise uniquement les balises HTML suivantes si nécessaire : <b> pour le texte important, <i> pour les termes spécifiques ou l'emphase, et <br> pour les retours à la ligne.
		PROMPT;

	public function __construct()
	{
		$this->apiKey = $_ENV["AI_API_KEY"];
	}

	public function ask(string $prompt): mixed
	{
		$payload = json_encode([
			"model" => $this->model,
			"messages" => [
				[
					"role" => "system",
					"content" => self::SYSTEM_PROMPT
				],
				[
					"role" => "user",
					"content" => $prompt
				]
			],
			"max_tokens" => 2000,
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
		return $response["choices"][0]["message"]["content"] ?? $response[0]["error"]["status"] . " – retry delay: " . $response[0]["error"]["details"][2]["retryDelay"];
	}
}
