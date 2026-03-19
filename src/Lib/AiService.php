<?php

namespace App\Lib;
// Un service générique pour appeler Gemini
class AiService
{
	private string $apiKey;
	private string $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent';

	public function __construct(string $apiKey)
	{
		$this->apiKey = $apiKey;
	}

	public function ask(string $prompt): mixed
	{
		$payload = json_encode([
			'contents' => [['parts' => [['text' => $prompt]]]]
		]);

		$ch = curl_init("{$this->endpoint}?key={$this->apiKey}");
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_POST            => true,
			CURLOPT_POSTFIELDS      => $payload,
			CURLOPT_HTTPHEADER      => ['Content-Type: application/json'],
			CURLOPT_SSL_VERIFYPEER  => IS_ONLINE,
		]);

		$response = json_decode(curl_exec($ch), true);

		return $response["candidates"][0]["content"]["parts"][0]["text"];
	}
}
