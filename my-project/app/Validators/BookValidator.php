<?php

namespace App\Validators;

use App\Contracts\BookValidatorInterface;
use Illuminate\Contracts\Validation\Validator;



class BookValidator implements BookValidatorInterface
{
    public function validate(array $data): Validator
    {
        $rules = [
            'title' => ['required', 'max:100', 'string'],
            'publication_year' => ['required', 'between:1850,2023', 'integer'],
        ];

        $messages = [
            'title.required' => 'The title is required, please enter a title to continue',
            'title.max' => 'The title must have less than 100 characters.',
            'title.string' => 'The title must be a text.',
            'publication_year.required' => 'The year of publication is required, please enter a year of publication to continue',
            'publication_year.between' => 'The year of publication must be beween 1850 and 2023',
            'publication_year.number' => 'The year of publication must be a integer.',
            
        ];

        // Accedemos a la clase Validator en el espacio de nombres global, no es Illuminate\Contracts\Validation\Validator
        return \Validator::make($data, $rules, $messages);
    }
}