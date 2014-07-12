<?php namespace Tipszonen\Repository;

use Symfony\Component\Process\Exception\InvalidArgumentException;
use DateTime;

/**
 * Class CouponDetailRepository
 * @package Tipszonen\Repository
 */
trait CouponDetailRepository
{
    /**
     * @return array
     */
    public static function ongoingCoupons()
    {
        return self::getCoupons('ongoing');;
    }

    /**
     * @return array
     */
    public static function comingCoupons()
    {
        return self::getCoupons('coming');
    }

    /**
     * @return array
     */
    public static function endedCoupons()
    {
        return self::getCoupons('ended');
    }

    /**
     * @param $file
     *
     * @return mixed
     */
    public static function getCouponDetailFromFile($file)
    {
        $txt_file = file_get_contents($file);
        $rows = explode("\n", $txt_file);
        $product_name = trim($rows[0]);

        return parent::whereProductId(\Product::whereName($product_name)->firstOrFail()->id)->firstOrFail();
    }

    /**
     * @param null $status
     *
     * @return array
     */
    private static function getCoupons($status = null)
    {
        $coupons = [];
        $added_coupons = [];

        foreach(parent::orderBy('id', 'DESC')->get() as $coupon)
        {
            $now = new DateTime();

            foreach($coupon->matches as $match) {
                if($status == 'ongoing')
                {
                    // If gamestart is earlier than current date and game is not ended
                    if($match->start < $now->format('Y-m-d H:i:s') && !$match->ended) {
                        // If the coupon ain't already added
                        if( !in_array($coupon->id, $added_coupons))
                        {
                            $added_coupons[] = $coupon->id;
                            $coupons[] = $coupon;
                        }
                    }
                } else if($status == 'ended')
                {
                    // If the count of ended matches is the same as all matches from the coupon
                    if($coupon->matches()->where('ended', 1)->count() == $coupon->matches()->count()) {
                        // If the coupon ain't already added
                        if( !in_array($coupon->id, $added_coupons))
                        {
                            $added_coupons[] = $coupon->id;
                            $coupons[] = $coupon;
                        }
                    }
                } else if ($status == 'coming')
                {
                    // If gamestart is later than current date and game is not ended
                    if($match->start > $now->format('Y-m-d H:i:s') && !$match->ended) {
                        // If the coupon ain't already added
                        if( !in_array($coupon->id, $added_coupons))
                        {
                            $added_coupons[] = $coupon->id;
                            $coupons[] = $coupon;
                        }
                    }
                } else
                {
                    $coupons[] = $coupon;
                }
            }
        }
        return $coupons;
    }

    /**
     * @return string
     */
    public function game_stop_formatted()
    {
        setlocale(LC_ALL, 'sv_SE.utf8');
        return ucfirst(strftime('%A %H:%M', strtotime($this->game_stop)));
    }

    /**
     * @return bool
     */
    public function is_active()
    {
        $now = new DateTime();
        return ($this->game_stop > $now->format('Y-m-d H:i:s'));
    }
}
