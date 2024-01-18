<?php

namespace App\Validators;

use App\Contracts\ReviewValidatorInterface;
use Illuminate\Contracts\Validation\Validator;



class ReviewValidator implements ReviewValidatorInterface
{
    public function validate(array $data): Validator
    {
        $rules = [
            'review_text' => ['required', 'max:625', 'string'],
            'rating' => ['required', 'integer', 'between:1,5'],
        ];

        $messages = [
            'review_text.required' => 'Review is required, please enter one to continue.',
            'review_text.max' => 'This comment should not be more than 625 characters.',
            'review_text.string' => 'This comment must be a string.',
            'rating.required' => 'Rating is required.',
            'rating.integer' => 'The rating must be an integer.',
            'rating.between' => 'The rating must be between 1 and 5.',
        ];

        // Accedemos a la clase Validator en el espacio de nombres global, no es Illuminate\Contracts\Validation\Validator
        return \Validator::make($data, $rules, $messages);
    }
}