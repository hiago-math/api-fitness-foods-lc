<?php

namespace Application\Http\Validators\Utils;

use Application\Http\Validators\BaseValidatorAbstract;

class PaginateValidator extends BaseValidatorAbstract
{
    public function __construct()
    {
        parent::$rules = [
            'page' => ['required', 'integer'],
            'per_page' => ['nullable', 'integer']
        ];

        parent::$messages = [
            'page.required' => "Campo 'page' é obrigatório",
            'page.integer' => "Campo 'page' precisa ser um inteiro!",
            'per_page.integer' => "Campo 'per_page' precisa ser um inteiro!"
        ];
    }
}
