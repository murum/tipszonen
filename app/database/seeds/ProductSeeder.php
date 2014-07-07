<?php


class ProductSeeder extends Seeder{
    public function run()
    {
        DB::table('products')->delete();

        Product::create(
            array(
                'product' => 1,
                'name' => 'Stryktipset',
                'slug' => 'stryktips'
            )
        );

        Product::create(
            array(
                'product' => 2,
                'name' => 'Europatipset',
                'slug' => 'europatips'
            )
        );

        Product::create(
            array(
                'product' => 70,
                'name' => 'Topptipset Stryk',
                'slug' => 'topptips'
            )
        );

        Product::create(
            array(
                'product' => 71,
                'name' => 'Topptipset Europa',
                'slug' => 'topptips'
            )
        );
    }
} 