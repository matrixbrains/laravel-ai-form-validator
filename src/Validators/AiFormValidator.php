<?php

namespace Matrixbrains\LaravelAiFormValidator\Validators;

use Matrixbrains\LaravelAi\Facades\Ai;

class AiFormValidator
{
    /**
     * Generic validation handler.
     */
    public function validate($attribute, $value, $parameters): bool
    {
        $ruleType = $parameters[0] ?? 'generic';

        $prompt = match ($ruleType) {
            'email' => "Check if this is a valid email: {$value}. Reply only 'valid' or 'invalid'.",
            'username' => "Check if this username is clean and not offensive: {$value}. Reply only 'valid' or 'invalid'.",
            'toxic_check' => "Check if this text contains toxic or offensive content: {$value}. Reply only 'valid' or 'invalid'.",
            default => "Check if this input is acceptable: {$value}. Reply only 'valid' or 'invalid'.",
        };

        return $this->validateCustomPrompt($value, $prompt);
    }

    /**
     * ai_appropriate → polite/respectful
     */
    public function appropriate(string $value): bool
    {
        $prompt = "Is this input polite and respectful? {$value}. Reply with ONLY 'valid' or 'invalid'.";
        return $this->validateCustomPrompt($value, $prompt);
    }

    /**
     * ai_professional → professional tone
     */
    public function professional(string $value): bool
    {
        $prompt = "Is this text written in a professional and formal tone? {$value}. Reply with ONLY 'valid' or 'invalid'.";
        return $this->validateCustomPrompt($value, $prompt);
    }

    /**
     * ai_topic:topicName → about a specific topic
     */
    public function topic(string $value, string $topic): bool
    {
        $prompt = "Does this input relate to {$topic}? {$value}. Reply with ONLY 'valid' or 'invalid'.";
        return $this->validateCustomPrompt($value, $prompt);
    }

    /**
     * ai_custom:"instruction" → custom rule
     */
    public function custom(string $value, string $instruction): bool
    {
        $prompt = "{$instruction}: {$value}. Reply with ONLY 'valid' or 'invalid'.";
        return $this->validateCustomPrompt($value, $prompt);
    }

    /**
     * Shared AI call + strict normalization
     */
    public function validateCustomPrompt(string $value, string $prompt): bool
    {
        $response = Ai::ask($prompt);

        // Normalize: lowercase, trim, strip non-letters
        $normalized = strtolower(trim($response));
        $normalized = preg_replace('/[^a-z]/', '', $normalized);

        return $normalized === 'valid';
    }
}
