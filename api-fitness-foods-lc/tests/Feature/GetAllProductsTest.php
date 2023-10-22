<?php

namespace Tests\Feature;

use Infrastructure\Models\Product;
use Tests\TestCase;

class GetAllProductsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_products()
    {
        $response = $this->get('/api/products?page=1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }

    private function createFakeProduct()
    {
        $product = new Product();

        $code = 'code_test' . rand(100000, 999999);

        // Preencha os campos com dados falsos
        $product->code = $code;
        $product->status = 'published';
        $product->imported_t = now();
        $product->url = 'https://example.com';
        $product->creator = 'securita';
        $product->created_t = now();
        $product->last_modified_t = now();
        $product->product_name = 'Nome do Produto';
        $product->quantity = '380 g (6 x 2 u.)';
        $product->brands = 'Nome da Marca';
        $product->categories = 'Categorias Separadas por Vírgula';
        $product->labels = 'Rótulos Separados por Vírgula';
        $product->cities = 'Cidades Separadas por Vírgula';
        $product->purchase_places = 'Locais de Compra Separados por Vírgula';
        $product->stores = 'Lojas Separadas por Vírgula';
        $product->ingredients_text = 'Lista de Ingredientes';
        $product->traces = 'Traços Separados por Vírgula';
        $product->serving_size = 'Tamanho da Porção';
        $product->serving_quantity = 31.7;
        $product->nutriscore_score = 17;
        $product->nutriscore_grade = 'd';
        $product->main_category = 'Categoria Principal';
        $product->image_url = 'https://example.com/imagem.jpg';

        // Salve o registro no MongoDB
        $product->save();

        return $code;
    }
}
