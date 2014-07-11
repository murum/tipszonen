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
        setlocale(LC_ALL, 'sv_SE.utf8');
        return ucfirst(strftime('%A %H:%M', strtotime($this->start)));
        //$start = new DateTime($this->start);
        //return Lang::get(sprintf('days.%s', date('l'))) . ', ' . $start->format('H:i');
    }

    public function coupon_format_start()
    {
        $start = new DateTime($this->start);
        return $start->format('Y-m-d H:i');
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

    public function get_match_status()
    {
        if($this->ended)
        {
            return 'ended';
        }

        if( $this->time == 45 )
        {
            return 'pause';
        }

        if( $this->time == 0 )
        {
            return 'not_started';
        }

        if( $this->time > 0 && $this->time < 90 )
        {
            return 'on_going';
        }
    }
}