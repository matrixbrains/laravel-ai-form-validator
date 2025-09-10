# Laravel AI Form Validator

🚀 Use AI to validate free-text form inputs beyond normal Laravel validation rules.  
Powered by [matrixbrains/laravel-ai](https://github.com/matrixbrains/laravel-ai).

## Installation

```bash
composer require matrixbrains/laravel-ai-form-validator
```

## Configuration

Publish the config:

```bash
php artisan vendor:publish --provider="Matrixbrains\\LaravelAiFormValidator\\LaravelAiFormValidatorServiceProvider" --tag=config
```

## Usage

```php
$request->validate([
    'feedback' => 'required|ai_appropriate',
    'company_name' => 'required|ai_custom:"Check if this looks like a real company name"',
]);
```

### Built-in AI Rules

- `ai_appropriate` → checks if input is polite/respectful  
- `ai_professional` → checks if input is written professionally  
- `ai_topic:laravel` → checks if input is about a topic  
- `ai_custom:"instruction"` → custom instruction for AI  

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
