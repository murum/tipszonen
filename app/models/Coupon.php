<?php

class Coupon extends Eloquent {

    protected $fillable = [];

    public function coupon_detail()
    {
        return $this->belongsTo('CouponDetail');
    }

    public function coupon_rows()
    {
        return $this->hasMany('CouponRow');
    }

    public static function customFind($id)
    {
        return static::with('coupon_detail', 'coupon_rows')->find($id);
    }

    public function get_best_rows($count, $results)
    {
        $unsorted_rows = [];
        foreach($this->coupon_rows as $row)
        {
            $unsorted_rows[] = [
                'row' => $row->row,
                'rights' => $row->get_rights($results)
            ];
        }
        $sorted_rows = tz_array_sort($unsorted_rows, 'rights');

        return array_slice($sorted_rows, 0, $count);
    }

    public function createCouponRows($rows)
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

    public static function _create_new($product_id)
    {
        $file = "https://svenskaspel.se/xternal/XMLkupong.asp";
        $xml = new DOMDocument();
        if(!$xml->load($file."?produktid=".$product_id))
        {
            return false;
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

    public function get_dividends()
    {
        $product_id = $this->coupon_detail->product_id;
        $round = $this->coupon_detail->round;
        $data = [];
        $file = "https://svenskaspel.se/xternal/XMLresultat.asp";
        $xml = new DOMDocument();

        $xml->load($file . "?produktid=" . $product_id . "&omgang=" . $round);

        if($xml->getElementsByTagName("fel")->item(0))
        {
            return false;
        }

        $winGroups = $xml->getElementsByTagName("vinstgrupp");

        foreach ($winGroups as $winGroup) {
            $rights = $winGroup->getElementsByTagName("beteckning")->item(0)->nodeValue;
            $amount = $winGroup->getElementsByTagName("antal")->item(0)->nodeValue;
            $price = $winGroup->getElementsByTagName("vinst")->item(0)->nodeValue;

            $data[] = array(
                'rights' => $rights,
                'amount' => $amount,
                'price' => $price
            );
        }
        return $data;
    }

    public function get_win($dividends)
    {
        $results = $this->coupon_detail->get_row_result();
        $rows = $this->get_best_rows($this->coupon_rows->count(), $results);
        $rights = [];

        foreach( $dividends as $dividend )
        {
            $rights[(int)$dividend['rights']] = (int)str_replace(' ', '', $dividend['price']);
        }

        $sum = 0 - (int)$this->cost;
        foreach ($rows as $row)
        {
            if(array_key_exists($row['rights'], $rights))
            {
                $sum += $rights[$row['rights']];
            }
        }
        return $sum;
    }

    public function generateOwnFileXML()
    {
        // TODO: Add exception controls.
        $progName = "Tipszonen";
        $ombud = Config::get('app.affiliate_id'); // TradedoublerID;
        $cardNumber = '1752943'; // TODO: Change this to a user specific card number.
        $product = $this->coupon_detail()->first()->product->product;
        $product_name = $this->coupon_detail()->first()->product->name;

        $xml = '<egnarader klient="'.$progName.'" spelkort="'.$cardNumber.'" ombud="'.$ombud.'">';
        $xml .= '<spel produkt="'.$product.'" produktnamn="'.$product_name.'">';

        foreach($this->coupon_rows()->get() as $row)
        {
            $xml .= "<rad system='".$row->system_type."'>".$row->row."</rad>";
        }

        $xml .= '</spel>';
        $xml .= '</egnarader>';

        return $xml;
    }

    public function uploadFileToSVS()
    {
        // TODO: Add exception controls.
        $url = 'https://svenskaspel.se/xternal/xmlegnarader.asp';
        $data = array('xml' => $this->generateOwnFileXML());

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => $this->generateOwnFileXML(),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $this->parseXMLResultAfterUpload($result);
    }

    public function parseXMLResultAfterUpload($xml)
    {
        // TODO: Add exception controls.
        $dom = new DOMDocument();
        $dom->loadXML($xml);
        $url = $dom->getElementsByTagName("url")->item(0)->nodeValue;
        $cost = $dom->getElementsByTagName("kostnad")->item(0)->nodeValue;
        $this->play_url = $url;
        $this->cost = $cost;
        if( $this->save() ) {
            return true;
        } else
        {
            return false;
        }
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