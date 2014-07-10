<?php namespace Tipszonen\Repository;

/**
 * Class CouponRepository
 * @package Tipszonen\Repository
 */
trait CouponRepository
{
    public static function recent_coupons($amount = 10)
    {
        return parent::with('coupon_detail')->orderBy('id', 'DESC')->take($amount)->get();
    }

    public static function user_coupons($amount = 10)
    {
        return parent::with('coupon_detail')->whereUserId(\Auth::user()->id)->orderBy('id', 'DESC')->take($amount)->get();
    }

    public function is_file()
    {
        return isset($this->file_url);
    }
}
