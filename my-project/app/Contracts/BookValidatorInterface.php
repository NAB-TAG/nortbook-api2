<?php

namespace App\Contracts;

use Illuminate\Contracts\Validation\Validator;

interface BookValidatorInterface
{
    public function validate( array $data ): Validator;
}
