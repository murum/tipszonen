<?php

class Coupon extends Eloquent {
    protected $fillable = [];

    public  function createCouponRows($rows)
    {
        foreach($rows as $row_to_add)
        {
            $coupon_row = new CouponRow;
            $coupon_row->coupon_id = $this->id;
            $coupon_row->row = $row_to_add;
            $coupon_row->save();
        }
    }

    public function getRowsFromFile($file)
    {
        $txt_file = file_get_contents($file);
        $rows = explode("\n", $txt_file);
        $rows_to_return = [];
        array_shift($rows);

        foreach($rows as $row => $data)
        {
            //get row data
            $row_data = explode(',', $data);
            $row_value = "";
            for( $i = 0; $i < count($row_data); $i++)
            {
                if($i > 0)
                {
                    if($i == count($row_data) - 1)
                    {
                        $row_value .= $row_data[$i];
                    } else
                    {
                        $row_value .= $row_data[$i] . ',';
                    }
                }
            }
            if($row_value != "")
            {
                $rows_to_return[] = $row_value;
            }
        }

        return $rows_to_return;
    }

    public static function _create_new($product_id, $round = null)
    {
        $file = "https://svenskaspel.se/xternal/XMLkupong.asp";
        $xml = new DOMDocument();
        if(isset($round))
        {
            if(!$xml->load($file."?produktid=".$product_id."&omgang=".$round))
            {
            }
        }
        else
        {
            if(!$xml->load($file."?produktid=".$product_id))
            {
            }
        }

        $data['product_name'] = $xml->getElementsByTagName("produktnamn")->item(0)->nodeValue;
        $round  = $xml->getElementsByTagName("omgang")->item(0)->nodeValue;
        $game_start = $xml->getElementsByTagName("spelstart")->item(0)->nodeValue;
        $game_stop = $xml->getElementsByTagName("spelstopp")->item(0)->nodeValue;
        $game_week = $xml->getElementsByTagName("spelvecka")->item(0)->nodeValue;

        if( ! self::CheckIfCouponDetailExists($product_id, $round))
        {
            $matches = $xml->getElementsByTagName("match");
            $coupon_detail = new CouponDetail;
            $coupon_detail->product_id = Product::whereProduct($product_id)->first()->id;
            $coupon_detail->round = $round;
            $coupon_detail->game_week = $game_week;
            $coupon_detail->game_start = $game_start;
            $coupon_detail->game_stop = $game_stop;
            if( $coupon_detail->save() )
            {
                foreach ($matches as $match_data) {
                    $match = new Match;
                    $match->coupon_detail_id = $coupon_detail->id;
                    $match->matchnumber = $match_data->getElementsByTagName("matchnummer")->item(0)->nodeValue;
                    $match->home_team = $match_data->getElementsByTagName("hemmalag")->item(0)->nodeValue;
                    $match->away_team = $match_data->getElementsByTagName("bortalag")->item(0)->nodeValue;
                    $match->start = $match_data->getElementsByTagName("matchstart")->item(0)->nodeValue;

                    $match->save();
                }

                return true;
            } else
            {
                return false;
            }
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
            }
        }
        else
        {
            if(!$xml->load($file."?produktid=".$product_id))
            {
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

    public static function CheckIfCouponDetailExists($product_id, $round)
    {
        try
        {
            CouponDetail::whereProductId(Product::whereProduct($product_id)->first()->id)->whereRound($round)->firstOrFail();

        } catch(Exception $ex)
        {
            return false;
        }

        return true;
    }
}