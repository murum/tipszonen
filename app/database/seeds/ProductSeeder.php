<?php


class ProductSeeder extends Seeder{
    public function run()
    {
        DB::table('products')->delete();

        Product::create(
            array(
                'product' => 1,
                'name' => 'Stryktipset'
            )
        );

        Product::create(
            array(
                'product' => 2,
                'name' => 'Europatipset'
            )
        );

        Product::create(
            array(
                'product' => 4,
                'name' => 'Måltipset'
            )
        );
    }
} 