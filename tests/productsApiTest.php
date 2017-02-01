<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class productsApiTest extends TestCase
{
    use MakeproductsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateproducts()
    {
        $products = $this->fakeproductsData();
        $this->json('POST', '/api/v1/products', $products);

        $this->assertApiResponse($products);
    }

    /**
     * @test
     */
    public function testReadproducts()
    {
        $products = $this->makeproducts();
        $this->json('GET', '/api/v1/products/'.$products->id);

        $this->assertApiResponse($products->toArray());
    }

    /**
     * @test
     */
    public function testUpdateproducts()
    {
        $products = $this->makeproducts();
        $editedproducts = $this->fakeproductsData();

        $this->json('PUT', '/api/v1/products/'.$products->id, $editedproducts);

        $this->assertApiResponse($editedproducts);
    }

    /**
     * @test
     */
    public function testDeleteproducts()
    {
        $products = $this->makeproducts();
        $this->json('DELETE', '/api/v1/products/'.$products->iidd);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/products/'.$products->id);

        $this->assertResponseStatus(404);
    }
}
