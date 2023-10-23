<?php

namespace Application\Http\Validators\Logs;

use Application\Http\Validators\BaseValidatorAbstract;

class LogsElasticsearchValidator extends BaseValidatorAbstract
{
    public function __construct()
    {
        parent::$rules = [
            'index' => ['required', 'string']
        ];

        parent::$messages = [
            'index.required' => "o campo index é obrigatório para buscar os logs!"
        ];
    }
}
