<?php

class Bet {
    public static $bet_types = [
        '1' => '1',
        '2' => 'X',
        '3' => '2',
        '4' => '1,X',
        '5' => '1,X,2',
        '6' => '1,2',
        '7' => 'X,2'
    ];

    private static $rows = [];

    public static function get_bet_id($bet)
    {
        $bet = implode(',', $bet);
        if($bet == self::$bet_types['1'])
        {
            return 1;
        }

        if($bet == self::$bet_types['2'])
        {
            return 2;
        }

        if($bet == self::$bet_types['3'])
        {
            return 3;
        }

        if($bet == self::$bet_types['4'])
        {
            return 4;
        }

        if($bet == self::$bet_types['5'])
        {
            return 5;
        }

        if($bet == self::$bet_types['6'])
        {
            return 6;
        }

        if($bet == self::$bet_types['7'])
        {
            return 7;
        }
    }

    public static function get_bet($bet)
    {
        return explode(',', self::$bet_types[$bet]);
    }

    public static function get_rows($match_bets, $row_length, $current_bet = null, $current_row = null)
    {
        $cur = array_shift($match_bets);
        $result = array();

        if(!isset($current_row))
            $current_row = $current_bet;
        else
            $current_row .= $current_bet;

        if(!count($match_bets)) {
            foreach($cur['bet'] as $bet) {
                $current_row .= $bet;
                if(strlen($current_row) == $row_length)
                {
                    $current_row = hyphenate(',', $current_row, 1);
                    self::$rows[] = $current_row;
                }
            }
            return self::$rows;
        }

        foreach($cur['bet'] as $bet) {
            $result[$bet] = self::get_rows($match_bets, $row_length, $bet, $current_row);
        }
        return self::$rows;
    }

}