<?php

function gravatar_url($email)
{
    return 'http://www.gravatar.com/avatar/' . md5($email) . '?s=34';
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
