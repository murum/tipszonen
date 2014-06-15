<?php

class CouponController extends BaseController {
    public function __construct()
    {
        foreach(Product::all() as $product)
        {
            Coupon::_create_new($product->product);
        }
    }

    public function index()
    {
        $products = Product::all();
        return View::make('coupon.index', compact('products'));
    }

    public function show($id)
    {
        $row_amount_to_show = 4;

        $coupon = Coupon::customFind($id);
        $rows = $coupon->coupon_rows;
        $matches = $coupon->coupon_detail->matches;
        $dividends = $coupon->get_dividends();
        $has_dividends = $dividends ? true : false;
        $results = $coupon->coupon_detail->get_row_result();

        if($has_dividends)
        {
            $win = $coupon->get_win($dividends);
        } else
        {
            $win = ($coupon->cost) * -1;
        }

        $best_rows = $coupon->get_best_rows($row_amount_to_show, $results);

        return  View::make('coupon.show', compact('coupon', 'rows', 'best_rows', 'matches', 'dividends', 'has_dividends', 'results', 'win'));
    }

    public function create($id)
    {
        $matches = Product::whereProductId($id)->whereRound();
        return View::make('coupon.create')->withMatches($matches);
    }

    public function create_own_file()
    {
        return View::make('coupon.create_from_file');
    }

    public function store_own_file()
    {
        if (Input::hasFile('own_file') && Input::file('own_file')->isValid())
        {
            if(Input::file('own_file')->getMimeType() === 'text/plain')
            {
                $file = Input::file('own_file');
                $coupon = new Coupon;
                $coupon_detail = CouponDetail::getCouponDetailFromFile($file);
                $user = Auth::user();

                $coupon->coupon_detail_id = $coupon_detail->id;
                $coupon->user_id = $user->id;
                $coupon->name = Input::get('name'); // TODO: Add validator

                $rows = $coupon->getRowsFromFile($file);

                if(count($rows) > 0)
                {
                    $coupon->save();

                    $coupon->createCouponRows($rows);
                }

                $file_path = Input::file('own_file')->move('/tmp', uniqid('_tmp') . '.' . Input::file('own_file')->getClientOriginalExtension());

                $input_svs_card = Input::get('svs_card') === "" ? null : Input::get('svs_card');
                if( isset($input_svs_card) && strlen($input_svs_card !== 7) )
                {
                    return Redirect::back()->withInput();
                }

                $card_number = isset($user->svs_card) ? $user->svs_card : $input_svs_card;
                $svs_activated = false;
                if(isset($card_number))
                {
                    $coupon->uploadFileToSVS($card_number);
                    $svs_activated = true;
                }

                return View::make('coupon.completed_from_file')
                    ->with('coupon', $coupon)
                    ->with('svs_button', $svs_activated);
            } else
            {
                Flash::error('Filtypen är ogiltig, vänligen ladda upp en .txt fil.');
                return Redirect::back();
            }
        } else
        {
            Flash::error('Ingen fil var vald');
            return Redirect::back();
        }
    }

    public function create_own_file_completed()
    {
        return View::make('coupon.completed_from_file');
    }

    public function deletedOne()
    {
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

            return View::make('coupon.index');
        } else
        {
            return Redirect::route('home');
        }
    }


    public function test()
    {
        $txt_file    = file_get_contents(URL::asset('tmp/egnarader_example.txt'));

    }
}