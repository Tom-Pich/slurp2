<?php

namespace App\Controller;

abstract class AbstractGenerateController {

	// Convert HTML content to plain text suitable for Markdown.
	protected function toPlainText(string $html): string
	{
		// Normalize line endings
		$text = str_replace(["\r\n", "\r"], "\n", $html);

		// Convert list items to Markdown bullets before stripping
		$text = preg_replace('/<li[^>]*>/i', "\n- ", $text);
		$text = preg_replace('/<\/li>/i', "", $text);
		$text = preg_replace('/<\/?[ou]l[^>]*>/i', "", $text);

		// Convert inline formatting to Markdown equivalents
		$text = preg_replace('/<\/?(i|em)\b[^>]*>/i', "_", $text);
		$text = preg_replace('/<\/?(b|strong)\b[^>]*>/i', "**", $text);

		// Replace block-level tags with newlines before stripping
		$text = preg_replace('/<br\s*\/?>/i', "\n", $text);
		$text = preg_replace('/<\/p>/i', "\n", $text);
		$text = preg_replace('/<p[^>]*>/i', "", $text);

		$text = strip_tags($text);
		$text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

		// Tight list: collapse any excess newlines before list items to one
		$text = preg_replace("/\n{2,}(?=- )/", "\n", $text);
		// Blank line before the first item of a list (when preceded by non-list content)
		$text = preg_replace('/^(?!- )(.+)\n(?=- )/m', "$1\n\n", $text);
		// Collapse 3+ newlines to a blank line (preserves paragraph separation)
		$text = preg_replace("/\n{3,}/", "\n\n", trim($text));

		return $text;
	}
}