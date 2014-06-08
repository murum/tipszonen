<?php

class Coupon extends Eloquent {
    protected $fillable = [];

    public function _create_new($product_id, $round = null)
    {
        $file = "https://svenskaspel.se/xternal/XMLkupong.asp";
        $xml = new DOMDocument();
        if(isset($round))
        {
            if(!$xml->load($file."?produktid=".$product_id."&omgang=".$round))
            {
                $this->_show_message($this->ci->lang->line('xml_open_error'));
            }
        }
        else
        {
            if(!$xml->load($file."?produktid=".$product_id))
            {
                $this->_show_message($this->ci->lang->line('xml_open_error'));
            }
        }

        $data['product_name'] = $xml->getElementsByTagName("produktnamn")->item(0)->nodeValue;
        $data['round'] = $xml->getElementsByTagName("omgang")->item(0)->nodeValue;
        $round = $data['round'];
        $data['start'] = $xml->getElementsByTagName("spelstart")->item(0)->nodeValue;
        $data['end'] = $xml->getElementsByTagName("spelstopp")->item(0)->nodeValue;
        $data['game_week'] = $xml->getElementsByTagName("spelvecka")->item(0)->nodeValue;

        if( ! $this->_check_if_coupon_exists($product_id, $round))
        {
            $matches = $xml->getElementsByTagName("match");
            foreach ($matches as $match_data) {
                $match = new Match;
                $match->product_id = $product_id;
                $match->round = $round;
                $match->matchnumber = $match_data->getElementsByTagName("matchnummer")->item(0)->nodeValue;
                $match->home_team = $match_data->getElementsByTagName("hemmalag")->item(0)->nodeValue;
                $match->away_team = $match_data->getElementsByTagName("bortalag")->item(0)->nodeValue;
                $match->start = $match_data->getElementsByTagName("matchstart")->item(0)->nodeValue;

                $match->save();
            }

            return true;
        }
        else
        {
            return false;
        }
    }

    public function _get_dividends($product_id, $round = null)
    {
        $file = "https://svenskaspel.se/xternal/XMLresultat.asp";
        $xml = new DOMDocument();
        if(isset($round))
        {
            if(!$xml->load($file."?produktid=".$product_id."&omgang=".$round))
            {
                $this->_show_message($this->ci->lang->line('xml_open_error'));
            }
        }
        else
        {
            if(!$xml->load($file."?produktid=".$product_id))
            {
                $this->_show_message($this->ci->lang->line('xml_open_error'));
            }
        }

        $data['product_id'] = $xml->getElementsByTagName("produktid")->item(0)->nodeValue;
        $data['round'] = $xml->getElementsByTagName("omgang")->item(0)->nodeValue;
        $winGroups = $xml->getElementsByTagName("vinstgrupp");
        foreach ($winGroups as $winGroup) {
            $rights = $winGroup->getElementsByTagName("beteckning")->item(0)->nodeValue;
            $amount = $winGroup->getElementsByTagName("antal")->item(0)->nodeValue;
            $price = $winGroup->getElementsByTagName("vinst")->item(0)->nodeValue;

            $data['win_groups'][] = array(
                'rights' => $rights,
                'amount' => $amount,
                'price' => $price
            );
        }
        return $data;
    }

    public function _check_if_coupon_exists($product_id, $round)
    {
        try
        {
            Match::whereProductId($product_id)->whereRound($round)->firstOrFail();
            return true;
        } catch(Exception $ex)
        {
            return false;
        }
    }
}