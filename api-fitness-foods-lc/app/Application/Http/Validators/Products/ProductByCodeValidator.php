<?php

namespace Application\Http\Validators\Products;

use Application\Http\Validators\BaseValidatorAbstract;

class ProductByCodeValidator extends BaseValidatorAbstract
{
    public function __construct()
    {
        parent::$rules = [
            'code' => ['required', 'string']
        ];
    }
}
