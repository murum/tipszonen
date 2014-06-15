<?php

class CouponRow extends Eloquent {
    protected $table = "coupon_rows";
    protected $fillable = [];

    public function coupon()
    {
        return $this->belongsTo('Coupon');
    }

    public function get_rights($results)
    {
        $row = explode(',', $this->row);

        $rights = 0;
        for($i = 0; $i<count($row); $i++)
        {
            if($row[$i] == $results[$i])
                $rights++;
        }
        return $rights;
    }
}