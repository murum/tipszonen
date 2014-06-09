<?php

class CouponDetail extends Eloquent {
    protected $table = 'coupon_details';
    protected $fillable = [];

    public static function getCouponDetailFromFile($file)
    {
        $txt_file = file_get_contents($file);
        $rows = explode("\n", $txt_file);
        $product_name = trim($rows[0]);

        return CouponDetail::whereProductId(Product::whereName($product_name)->first()->id)->first();
    }

}