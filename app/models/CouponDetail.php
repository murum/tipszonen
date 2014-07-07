<?php

use \Tipszonen\Repository\CouponDetailRepository;

class CouponDetail extends Eloquent {
    use CouponDetailRepository;

    protected $table = 'coupon_details';
    protected $fillable = [];

    public function product()
    {
        return $this->belongsTo('Product');
    }

    public function coupons()
    {
        return $this->hasMany('Coupon');
    }

    public function matches()
    {
        return $this->hasMany('Match');
    }

    public function get_row_result()
    {
        $results = array();

        foreach($this->matches as $match) {
            $results[] = $match->get_result();
        }

        return $results;
    }

    public static function getCouponDetailFromFile($file)
    {
        $txt_file = file_get_contents($file);
        $rows = explode("\n", $txt_file);
        $product_name = trim($rows[0]);

        return CouponDetail::whereProductId(Product::whereName($product_name)->first()->id)->first();
    }

}