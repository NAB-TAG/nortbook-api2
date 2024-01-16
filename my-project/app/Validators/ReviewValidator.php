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
            'review_text.required' => 'Este comentario es requerido.',
            'review_text.max' => 'Este comentario no debe tener mas de 625 caracteres.',
            'review_text.string' => 'Este comentario debe ser un string',
            'rating.required' => 'La puntuacion es requerida',
            'rating.integer' => 'La puntuacion debe ser un entero',
            'rating.between' => 'La puntuacion debe tener entre 1 y 5',
        ];

        // Accedemos a la clase Validator en el espacio de nombres global, no es Illuminate\Contracts\Validation\Validator
        return \Validator::make($data, $rules, $messages);
    }
}