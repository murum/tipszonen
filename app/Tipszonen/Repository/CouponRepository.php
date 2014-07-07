<?php namespace Tipszonen\Repository;

/**
 * Class CouponRepository
 * @package Tipszonen\Repository
 */
trait CouponRepository
{
    public static function recent_coupons($amount = 10)
    {
        return parent::with('coupon_detail', 'coupon_rows')->orderBy('id', 'DESC')->take($amount)->get();
    }
}
