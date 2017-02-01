<?php

use Faker\Factory as Faker;
use App\Models\products;
use App\Repositories\productsRepository;

trait MakeproductsTrait
{
    /**
     * Create fake instance of products and save it in database
     *
     * @param array $productsFields
     * @return products
     */
    public function makeproducts($productsFields = [])
    {
        /** @var productsRepository $productsRepo */
        $productsRepo = App::make(productsRepository::class);
        $theme = $this->fakeproductsData($productsFields);
        return $productsRepo->create($theme);
    }

    /**
     * Get fake instance of products
     *
     * @param array $productsFields
     * @return products
     */
    public function fakeproducts($productsFields = [])
    {
        return new products($this->fakeproductsData($productsFields));
    }

    /**
     * Get fake data of products
     *
     * @param array $postFields
     * @return array
     */
    public function fakeproductsData($productsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'description' => $fake->word,
            'expired_at' => $fake->word,
            'price' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $productsFields);
    }
}
