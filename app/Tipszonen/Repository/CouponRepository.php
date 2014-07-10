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
}
