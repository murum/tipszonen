<?php

class CouponController extends BaseController {
    public function index()
    {
        $coupon = new Coupon;
        if (!$coupon->_create_new(1))
        {
            $dividend = $coupon->_get_dividends(1);
            dd($dividend);

            $coupons = $this->couponlib->get_coupons();
            foreach ($coupons as $coupon) {
                $coupon['author'] = $this->couponlib->get_user($coupon['user_id']);
                $coupon['product'] = $this->couponlib->get_productname_from_id($coupon['product_id']);
                $data['main_content_data']['coupons'][] = $coupon;
            }

            $data['main_content'] = "coupon/index";

            $this->load->view("templates/defaultBig", $data);

            return View::make('hello');
        } else
        {
            return Redirect::route('home');
        }
    }

    public function test()
    {
        $txt_file    = file_get_contents(URL::asset('tmp/egnarader_example.txt'));
        $rows        = explode("\n", $txt_file);
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

        foreach($rows_to_return as $row_to_add)
        {
            $coupon_row = new CouponRow;
            $coupon_row->product_id = 1;
            $coupon_row->user_id = 1;
            $coupon_row->row = $row_to_add;
            $coupon_row->round = '4444';
            $coupon_row->game_start = new DateTime;
            $coupon_row->game_end = new DateTime;
            $coupon_row->game_week = '201424';
            $coupon_row->save();
        }
    }
}