<?php

namespace Matrixbrains\LaravelAiFormValidator\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Matrixbrains\LaravelAiFormValidator\Validators\AiFormValidator;

class AiFormValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $validator = new AiFormValidator();

        // ai_validate (generic + types like email, toxic_check, etc.)
        Validator::extend('ai_validate', function ($attribute, $value, $parameters, $validatorInstance) use ($validator) {
            return $validator->validate($attribute, $value, $parameters);
        }, 'The :attribute failed AI validation.');

        Validator::extend('ai_appropriate', function ($attribute, $value) use ($validator) {
            return $validator->appropriate($value);
        }, 'The :attribute must be polite and respectful.');

        Validator::extend('ai_professional', function ($attribute, $value) use ($validator) {
            return $validator->professional($value);
        }, 'The :attribute must be written professionally.');

        Validator::extend('ai_topic', function ($attribute, $value, $parameters) use ($validator) {
            $topic = $parameters[0] ?? 'general';
            return $validator->topic($value, $topic);
        }, 'The :attribute must be about the specified topic.');

        Validator::extend('ai_custom', function ($attribute, $value, $parameters) use ($validator) {
            $instruction = $parameters[0] ?? 'Check if this input is acceptable';
            return $validator->custom($value, $instruction);
        }, 'The :attribute failed custom AI validation.');
    }

    public function register()
    {
        //
    }
}
