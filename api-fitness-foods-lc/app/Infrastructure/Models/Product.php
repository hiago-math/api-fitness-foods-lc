<?php

namespace Infrastructure\Models;

use Jenssegers\Mongodb\Eloquent\Model as ModelMongo;

class Product extends ModelMongo
{
    protected $connection = 'mongodb';
    protected $collection = 'products';
    protected $guarded = ['created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'code',
        'status',
        'imported_t',
        'url',
        'creator',
        'created_t',
        'last_modified_t',
        'product_name',
        'quantity',
        'brands',
        'categories',
        'labels',
        'cities',
        'purchase_places',
        'stores',
        'ingredients_text',
        'traces',
        'serving_size',
        'serving_quantity',
        'nutriscore_score',
        'nutriscore_grade',
        'main_category',
        'image_url'
    ];

    public function getFillable()
    {
        return $this->fillable;
    }
}
