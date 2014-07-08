<?php

function gravatar_url($email, $thumb = true)
{
    if($thumb) {
        return 'http://www.gravatar.com/avatar/' . md5($email) . '?s=34';
    }

    return 'http://www.gravatar.com/avatar/' . md5($email) . '?s=263';
}

function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (empty($text))
    {
        return 'n-a';
    }

    return $text;
}

function tz_array_sort($array, $on, $order=SORT_DESC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function get_ip()
{
    return Request::getClientIp();
}

function link_to_facebook($route, $title)
{
    return '
        <a href="'.route($route).'" class="btn btn-fb">
            <i class="fa fa-facebook-square"></i>
            '.$title.'
        </a>
    ';
}

define("SECOND", 1);
define("MINUTE", 60 * SECOND);
define("HOUR", 60 * MINUTE);
define("DAY", 24 * HOUR);
define("MONTH", 30 * DAY);
function relative_time($time)
{
    // If the param $time is not a string
    if(gettype($time) !== 'string') {
        $time = strtotime($time);
    }

    $delta = time() - $time;

    if ($delta < 1 * MINUTE)
    {
        return $delta == 1 ? "en sekund sen" : $delta . " sekunder sen";
    }
    if ($delta < 2 * MINUTE)
    {
        return "en minut sen";
    }
    if ($delta < 45 * MINUTE)
    {
        return floor($delta / MINUTE) . " minuter sen";
    }
    if ($delta < 90 * MINUTE)
    {
        return "en timme sen";
    }
    if ($delta < 24 * HOUR)
    {
        return floor($delta / HOUR) . " timmar sen";
    }
    if ($delta < 48 * HOUR)
    {
        return "igår";
    }
    if ($delta < 30 * DAY)
    {
        return floor($delta / DAY) . " dagar sen";
    }
    if ($delta < 12 * MONTH)
    {
        $months = floor($delta / DAY / 30);
        return $months <= 1 ? "en månad sen" : $months . " månader sen";
    }
    else
    {
        $years = floor($delta / DAY / 365);
        return $years <= 1 ? "ett år sen" : $years . " år sen";
    }
}

function time_to_string($time)
{
    // If the param $time is not a string
    if(gettype($time) !== 'string') {
        $time = strtotime($time);
    }

    if ($time < 1 * MINUTE)
    {
        return $time == 1 ? "en sekund" : $time . " sekunder";
    }
    if ($time < 2 * MINUTE)
    {
        return "en minut";
    }
    if ($time < 45 * MINUTE)
    {
        return floor($time / MINUTE) . " minuter";
    }
    if ($time < 90 * MINUTE)
    {
        return "en timme";
    }
    if ($time < 24 * HOUR)
    {
        return floor($time / HOUR) . " timmar";
    }
    if ($time < 48 * HOUR)
    {
        return "en dag";
    }
    if ($time < 30 * DAY)
    {
        return floor($time / DAY) . " dagar";
    }
    if ($time < 12 * MONTH)
    {
        $months = floor($time / DAY / 30);
        return $months <= 1 ? "en månad" : $months . " månader";
    }
    else
    {
        $years = floor($time / DAY / 365);
        return $years <= 1 ? "ett år" : $years . " år";
    }
}

function hyphenate($char, $str, $size) {
    return implode($char, str_split($str, $size));
}
