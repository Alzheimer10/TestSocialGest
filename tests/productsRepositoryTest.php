<?php

use App\Models\products;
use App\Repositories\productsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class productsRepositoryTest extends TestCase
{
    use MakeproductsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var productsRepository
     */
    protected $productsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->productsRepo = App::make(productsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateproducts()
    {
        $products = $this->fakeproductsData();
        $createdproducts = $this->productsRepo->create($products);
        $createdproducts = $createdproducts->toArray();
        $this->assertArrayHasKey('id', $createdproducts);
        $this->assertNotNull($createdproducts['id'], 'Created products must have id specified');
        $this->assertNotNull(products::find($createdproducts['id']), 'products with given id must be in DB');
        $this->assertModelData($products, $createdproducts);
    }

    /**
     * @test read
     */
    public function testReadproducts()
    {
        $products = $this->makeproducts();
        $dbproducts = $this->productsRepo->find($products->id);
        $dbproducts = $dbproducts->toArray();
        $this->assertModelData($products->toArray(), $dbproducts);
    }

    /**
     * @test update
     */
    public function testUpdateproducts()
    {
        $products = $this->makeproducts();
        $fakeproducts = $this->fakeproductsData();
        $updatedproducts = $this->productsRepo->update($fakeproducts, $products->id);
        $this->assertModelData($fakeproducts, $updatedproducts->toArray());
        $dbproducts = $this->productsRepo->find($products->id);
        $this->assertModelData($fakeproducts, $dbproducts->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteproducts()
    {
        $products = $this->makeproducts();
        $resp = $this->productsRepo->delete($products->id);
        $this->assertTrue($resp);
        $this->assertNull(products::find($products->id), 'products should not exist in DB');
    }
}
