<?php

namespace Application\Http\Validators\Products;

use Application\Http\Validators\BaseValidatorAbstract;

class GetProductByCodeValidator extends BaseValidatorAbstract
{
    public function __construct()
    {
        parent::$rules = [];
    }
}
