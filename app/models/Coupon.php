<?php
use \Tipszonen\Repository\CouponRepository;
class Coupon extends BaseModel {
    use CouponRepository;

    protected $fillable = [];
    protected static $rules = [
        'name' => 'required|alpha_num_spaces|min:3',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            if($model->validate())
            {
                return $model;
            }

            return false;
        });
    }

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

    public static function customFindFile($id)
    {
        return static::with('coupon_detail')->find($id);
    }

    public function get_rights($results, $row)
    {
        $row = explode(',', $row);

        $rights = 0;
        for($i = 0; $i<count($row); $i++)
        {
            if($row[$i] == $results[$i])
                $rights++;
        }
        return $rights;
    }

    public function get_best_rows($count, $results)
    {
        $unsorted_rows = [];

        if( ! $this->is_file() )
        {
            foreach($this->coupon_rows as $row)
            {
                $unsorted_rows[] = [
                    'row' => $row->row,
                    'rights' => $row->get_rights($results)
                ];
            }
        } else
        {
            foreach($this->getRowsFromFile($this->file_url) as $row)
            {
                $unsorted_rows[] = [
                    'row' => $row['row'],
                    'rights' => self::get_rights($results, $row['row'])
                ];
            }
        }
        $sorted_rows = tz_array_sort($unsorted_rows, 'rights');

        return array_slice($sorted_rows, 0, $count);
    }

    public function get_best_row_rights()
    {
        return $this->get_best_rows(1, $this->coupon_detail->get_row_result())[0]['rights'];
    }

    public function createCouponRows($rows)
    {
        $rows_to_add = [];
        foreach($rows as $row_to_add)
        {
            $rows_to_add[] = [
                'coupon_id' => $this->id,
                'row' => trim($row_to_add)
            ];
        }

        DB::table('coupon_rows')->insert($rows_to_add);
    }

    public function getRowsFromFile($file)
    {
        $file_path = public_path();
        $file_path .= $file;
        $txt_file = file_get_contents($file_path);
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
                $rows_to_return[] = [
                    'system_type' => 'E',
                    'row' => $row_value
                ];
            }
        }

        return $rows_to_return;
    }

    public function getRowsFromCoupon($input)
    {
        dd($input);
    }

    public static function _create_new($product_id)
    {
        $file = "https://svenskaspel.se/xternal/XMLkupong.asp";
        $xml = new DOMDocument();
        if(!$xml->load($file."?produktid=".$product_id))
        {
            return false;
        }

        $product_name = $xml->getElementsByTagName("produktnamn")->item(0);

        if( isset( $product_name ) )
        {
            $data['product_name'] = $product_name->nodeValue;
        } else
        {
            return false;
        }

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
        $product_id = $this->coupon_detail->product->product;
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
        if( $this->is_file() )
        {
            $rows = $this->get_best_rows($this->getRowsFromFile($this->file_url), $results);
        } else
        {
            $rows = $this->get_best_rows($this->coupon_rows->count(), $results);
        }
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

    public function generateOwnFileXML($svs_card)
    {
        // TODO: Add exception controls.
        $progName = "Tipszonen";
        $ombud = Config::get('app.affiliate_id'); // TradedoublerID;
        $product = $this->coupon_detail()->first()->product->product;
        $product_name = $this->coupon_detail()->first()->product->name;

        $xml = '<egnarader klient="'.$progName.'" spelkort="'.$svs_card.'" ombud="'.$ombud.'">';
        $xml .= '<spel produkt="'.$product.'" produktnamn="'.$product_name.'">';

        if( ! $this->is_file() )
        {
            $xml .= $this->generateXMLRows($this->coupon_rows()->get());
        } else
        {

            $xml .= $this->generateXMLRows($this->getRowsFromFile($this->file_url));
        }


        $xml .= '</spel>';
        $xml .= '</egnarader>';

        return $xml;
    }
    public function generateXMLRows($rows)
    {
        $string = '';
        foreach($rows as $row)
        {
            if( ! $this->is_file() )
            {
                $string .= "<rad system='".$row->system_type."'>".$row->row."</rad>";
            } else
            {
                $string .= "<rad system='".$row['system_type']."'>".$row['row']."</rad>";
            }
        }
        return $string;
    }

    public function uploadFileToSVS($svs_card)
    {
        // TODO: Add exception controls.
        $url = 'https://svenskaspel.se/xternal/xmlegnarader.asp';

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => $this->generateOwnFileXML($svs_card),
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