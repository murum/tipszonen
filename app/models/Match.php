<?php

use Carbon\Carbon;

class Match extends Eloquent
{
    protected $fillable = [];

    public function product()
    {
        return $this->belongsTo('Product');
    }

    public function coupon_detail()
    {
        return $this->belongsTo('CouponDetail');
    }

    public function formated_start()
    {
        setlocale(LC_ALL, 'sv_SE');
        return strftime('%A %H:%M', strtotime($this->start));
    }

    public function get_result()
    {
        if($this->home_score > $this->away_score)
        {
            return "1";
        }
        else if($this->home_score == $this->away_score)
        {
            return "X";
        }
        else
        {
            return "2";
        }
    }
}