<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Validators of the authenticate
use App\Contracts\AuthValidatorInterface;
use App\Validators\AuthValidator;
// Validators of the book
use App\Contracts\BookValidatorInterface;
use App\Validators\BookValidator;
// Validators of the reviews
use App\Contracts\ReviewValidatorInterface;
use App\Validators\ReviewValidator;

use App\Rules\ForbiddenWordsRule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthValidatorInterface::class,
            AuthValidator::class,
            BookValidatorInterface::class,
            BookValidator::class,
            ReviewValidatorInterface::class,
            ReviewValidator::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Validator::extend('forbidden_words', function ($attribute, $value, $parameters, $validator) {
            $rule = new ForbiddenWordsRule();
            return $rule->passes($attribute, $value);
        });
    }
}
