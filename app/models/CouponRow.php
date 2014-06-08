<?php

class CouponRow extends Eloquent {
    protected $table = "coupon_rows";
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function product()
    {
        return $this->belongsTo('Product');
    }
}