<?php

namespace App\Contracts;

use Illuminate\Contracts\Validation\Validator;

interface ReviewValidatorInterface
{
    public function validate( array $data ): Validator;
}
