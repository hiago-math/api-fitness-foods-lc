<?php

namespace Shared\DTO\Product;

use Carbon\Carbon;
use Shared\DTO\DTOAbstract;
use Shared\Enums\StatusProductEnum;

class CreateProductDTO extends DTOAbstract
{
    /**
     * @var string|null
     */
    public ?string $code;

    /**
     * @var string|null
     */
    public ?string $status;

    /**
     * @var string
     */
    public string $imported_t;

    /**
     * @var string|null
     */
    public ?string $url;

    /**
     * @var string|null
     */
    public ?string $creator;

    /**
     * @var int|null
     */
    public ?int $created_t;

    /**
     * @var int|null
     */
    public ?int $last_modified_t;

    /**
     * @var string|null
     */
    public ?string $product_name;

    /**
     * @var string|null
     */
    public ?string $quantity;

    /**
     * @var string|null
     */
    public ?string $brands;

    /**
     * @var string|null
     */
    public ?string $categories;

    /**
     * @var string|null
     */
    public ?string $labels;

    /**
     * @var string|null
     */
    public ?string $cities;

    /**
     * @var string|null
     */
    public ?string $purchase_places;

    /**
     * @var string|null
     */
    public ?string $stores;

    /**
     * @var string|null
     */
    public ?string $ingredients_text;

    /**
     * @var string|null
     */
    public ?string $traces;

    /**
     * @var string|null
     */
    public ?string $serving_size;

    /**
     * @var float|null
     */
    public ?float $serving_quantity;

    /**
     * @var float|null
     */
    public ?float $nutriscore_score;

    /**
     * @var string|null
     */
    public ?string $nutriscore_grade;

    /**
     * @var string|null
     */
    public ?string $main_category;

    /**
     * @var string|null
     */
    public ?string $image_url;

    /**
     * @param string|null $url
     * @param string|null $creator
     * @param int|null $created_t
     * @param int|null $last_modified_t
     * @param string|null $product_name
     * @param string|null $quantity
     * @param string|null $brands
     * @param string|null $categories
     * @param string|null $labels
     * @param string|null $cities
     * @param string|null $purchase_places
     * @param string|null $stores
     * @param string|null $ingredients_text
     * @param string|null $traces
     * @param string|null $serving_size
     * @param string|null $serving_quantity
     * @param string|null $nutriscore_score
     * @param string|null $nutriscore_grade
     * @param string|null $main_category
     * @param string|null $image_url
     * @param string|null $code
     * @return CreateProductDTO
     */
    public function register(
        ?string $url,
        ?string $creator,
        ?int $created_t,
        ?int $last_modified_t,
        ?string $product_name,
        ?string $quantity,
        ?string $brands,
        ?string $categories,
        ?string $labels,
        ?string $cities,
        ?string $purchase_places,
        ?string $stores,
        ?string $ingredients_text,
        ?string $traces,
        ?string $serving_size,
        ?string $serving_quantity,
        ?string $nutriscore_score,
        ?string $nutriscore_grade,
        ?string $main_category,
        ?string $image_url,
        ?string $code,
    )
    {
        $this->code = str_replace(['\\', '"'], '',$code);
        $this->status = StatusProductEnum::PUBLISHED;
        $this->imported_t = Carbon::now()->format('Y-m-d H:i:s');
        $this->url = $url;
        $this->creator = $creator;
        $this->created_t = $created_t;
        $this->last_modified_t = $last_modified_t;
        $this->product_name = $product_name;
        $this->quantity = $quantity;
        $this->brands = $brands;
        $this->categories = $categories;
        $this->labels = $labels;
        $this->cities = $cities;
        $this->purchase_places = $purchase_places;
        $this->stores = $stores;
        $this->ingredients_text = $ingredients_text;
        $this->traces = $traces;
        $this->serving_size = $serving_size;
        $this->serving_quantity = empty($serving_quantity) ? 0 : (float)$serving_quantity;
        $this->nutriscore_score = empty($nutriscore_score) ? 0 : (float)$nutriscore_score;
        $this->nutriscore_grade = $nutriscore_grade;
        $this->main_category = $main_category;
        $this->image_url = $image_url;
        return $this;
    }
}
