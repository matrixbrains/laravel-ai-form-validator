# Laravel AI Form Validator

🚀 Use AI to validate free-text form inputs beyond normal Laravel validation rules.  
Powered by [matrixbrains/laravel-ai](https://github.com/matrixbrains/laravel-ai).

---

## Installation

```bash
composer require matrixbrains/laravel-ai-form-validator
```

This package depends on [matrixbrains/laravel-ai](https://github.com/matrixbrains/laravel-ai), which acts as the AI wrapper.

---

## Configuration

Publish the config:

```bash
php artisan vendor:publish --provider="Matrixbrains\\LaravelAiFormValidator\\LaravelAiFormValidatorServiceProvider" --tag=config
```

### AI Environment Setup

Make sure you have configured **Laravel AI** correctly in your `.env` file.  
You need to define which AI driver to use and provide its API key.

Example `.env`:

```env
# Choose AI driver (openai, gemini, claude)
AI_DRIVER=openai

# OpenAI
OPENAI_API_KEY=your-openai-key

# Google Gemini
GEMINI_API_KEY=your-gemini-key

# Anthropic Claude
ANTHROPIC_API_KEY=your-claude-key
```

By default, `AI_DRIVER=openai` will be used.  
You can switch drivers at any time.

---

## Usage

```php
$request->validate([
    'feedback' => 'required|ai_appropriate',
    'company_name' => 'required|ai_custom:"Check if this looks like a real company name"',
]);
```

---

## Built-in AI Rules

- `ai_appropriate` → checks if input is polite/respectful
- `ai_professional` → checks if input is written professionally
- `ai_topic:laravel` → checks if input is about a topic
- `ai_custom:"instruction"` → custom instruction for AI

---

## Example

```php
$data = ['feedback' => 'This product is trash!!!'];

$rules = [
    'feedback' => 'required|ai_appropriate',
];

$validator = Validator::make($data, $rules);

if ($validator->fails()) {
    dd($validator->errors()); 
}
```

✅ Output example:

```php
[
    "feedback" => [
        "The feedback failed AI appropriate validation."
    ]
]
```

---

## Roadmap

- [ ] Add multilingual validation prompts
- [ ] Support for streaming AI responses
- [ ] Configurable strictness levels (lenient, medium, strict)
- [ ] Fallback AI driver (e.g., use Gemini if OpenAI quota exceeded)

---

## License

MIT © [MatrixBrains](https://github.com/matrixbrains)
