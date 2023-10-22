<?php

namespace Application\Http\Validators\Products;

use Application\Http\Validators\BaseValidatorAbstract;

class UpdateProductByCodeValidator extends BaseValidatorAbstract
{
    public function __construct()
    {
        parent::$rules = [
            'code' => ['required', 'string'],
            'url' => ['nullable', 'string'],
            'product_name' => ['nullable', 'string'],
            'quantity' => ['nullable', 'string'],
            'brands' => ['nullable', 'string'],
            'categories' => ['nullable', 'string'],
            'labels' => ['nullable', 'string'],
            'cities' => ['nullable', 'string'],
            'purchase_places' => ['nullable', 'string'],
            'stores' => ['nullable', 'string'],
            'ingredients_text' => ['nullable', 'string'],
            'traces' => ['nullable', 'string'],
            'serving_size' => ['nullable', 'string'],
            'serving_quantity' => ['nullable', 'numeric'],
            'nutriscore_score' => ['nullable', 'numeric'],
            'nutriscore_grade' => ['nullable', 'string'],
            'main_category' => ['nullable', 'string']
        ];
    }
}
