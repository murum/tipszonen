<?php

use Carbon\Carbon;

/**
 * Class Match
 */
class Match extends Eloquent {

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return mixed
     */
    public function product()
    {
        return $this->belongsTo('Product');
    }

    /**
     * @return mixed
     */
    public function coupon_detail()
    {
        return $this->belongsTo('CouponDetail');
    }

    /**
     *
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
            return $model;
        });
    }

    /**
     * @return string
     */
    public function formated_start()
    {
        setlocale(LC_ALL, 'sv_SE.utf8');

        return ucfirst(strftime('%A %H:%M', strtotime($this->start)));
        //$start = new DateTime($this->start);
        //return Lang::get(sprintf('days.%s', date('l'))) . ', ' . $start->format('H:i');
    }

    /**
     * @return string
     */
    public function coupon_format_start()
    {
        $start = new DateTime($this->start);

        return $start->format('Y-m-d H:i');
    }

    /**
     * @return string
     */
    public function get_result()
    {
        if ((int) $this->home_score > (int) $this->away_score)
        {
            return "1";
        } else if ((int) $this->home_score == (int) $this->away_score)
        {
            return "X";
        } else
        {
            return "2";
        }
    }

    /**
     * @return bool
     */
    public function is_invalid()
    {
        $now = new DateTime();

        return ($this->start > $now->format('Y-m-d H:i:s') && !$this->ended);
    }

    /**
     * @return string
     */
    public function get_match_status()
    {
        if ($this->ended)
        {
            return 'ended';
        }

        if ($this->time == 45)
        {
            return 'pause';
        }

        if ($this->time == 0)
        {
            return 'not_started';
        }

        if ($this->time > 0 && $this->time < 90)
        {
            return 'on_going';
        }
    }

    /**
     * @return int
     */
    public function get_match_time()
    {
        $updated = isset($this->match_updated) ? strtotime($this->match_updated) : strtotime($this->updated_at);
        $now = new DateTime();
        $now_time = strtotime($now->format('Y-m-d H:i:s'));

        $calculated_time = round(($now_time - $updated) / 60, 0);
        if ($calculated_time > 90)
        {
            $calculated_time = 0;
        }
        if ($this->time == 45)
        {
            return 45;
        }
        if ($this->time == 90)
        {
            return 90;
        }
        if ($this->time == 0)
        {
            return 0;
        }
        if ($this->ended)
        {
            return 90;
        }

        return (int) ($calculated_time + $this->time);
    }
}