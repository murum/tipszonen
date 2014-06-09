<?php

class Product extends Eloquent {
    protected $fillable = [];

    public function matches()
    {
        return $this->hasMany('Match');
    }

    public static function getProductFromFile($file)
    {
        $txt_file = file_get_contents($file);
        $rows = explode("\n", $txt_file);
        $product_name = trim($rows[0]);

        return Product::whereName($product_name)->first();
    }

}