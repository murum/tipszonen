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
}