<?php

/**
 * Class CouponController
 */
class CouponController extends BaseController {
    /**
     *
     */
    public function __construct()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        CouponDetail::createDividends();
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $products = Product::all();

        $recent_coupons = Coupon::recent_coupons();
        $user = Auth::user();

        foreach($products as $product)
        {
            Coupon::_create_new($product->product);
        }

        return View::make('coupon.index', compact('products', 'recent_coupons', 'user'));
    }

    /**
     * @return mixed
     */
    public function search()
    {
        $query = Input::get('search');
        $coupons = Coupon::where('name', 'LIKE', '%'.$query.'%')->get();

        // If there's just one coupon show the coupon
        if( $coupons->count() == 1)
        {
            return Redirect::route('coupon.show', $coupons->first()->id);
        }
        // Else show the search result
        return View::make('coupon.search', compact('coupons', 'query'));
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $row_amount_to_show = 8;

        $coupon = Coupon::find($id);
        if( ! $coupon->is_file() )
        {
            $coupon = Coupon::customFind($id);
        } else
        {
            $coupon = Coupon::customFindFile($id);
        }
        $dividends = $coupon->set_dividends();
        $results = $coupon->coupon_detail->get_row_result();
        $array = $coupon->get_best_rows($row_amount_to_show, $results);
        $best_rows = $array[0];
        $win = $array[1];

        return  View::make('coupon.show', compact('coupon', 'dividends', 'best_rows', 'win'));
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show_update($id)
    {
        $row_amount_to_show = 8;

        $coupon = Coupon::find($id);
        if( ! $coupon->is_file() )
        {
            $coupon = Coupon::customFind($id);
        } else
        {
            $coupon = Coupon::customFindFile($id);
        }
        $dividends = $coupon->set_dividends();
        $results = $coupon->coupon_detail->get_row_result();
        $array = $coupon->get_best_rows($row_amount_to_show, $results);
        $best_rows = $array[0];
        $win = $array[1];

        return  View::make('coupon.show_update', compact('coupon', 'dividends', 'best_rows', 'win'));
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function create($id)
    {
        $coupon = CouponDetail::with('matches')->whereProductId($id)->get()->last();

        if( ! $coupon->is_active() )
        {
            Flash::error('Det finns ingen aktiv omgång att spela på för den här kupongtypen');
            return Redirect::back();
        }

        return View::make('coupon.create', compact('coupon'));
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function store($id)
    {
        $coupon = new Coupon;
        $coupon_detail = CouponDetail::with('matches')->find($id);

        if( ! $coupon_detail->is_active() )
        {
            Flash::error('Det finns ingen aktiv omgång att spela på för den här kupongtypen');
            return Redirect::back();
        }

        $user = Auth::user();

        $coupon->coupon_detail_id = $coupon_detail->id;
        if(isset($user)) 
        {
            $coupon->user_id = $user->id;
        }
        
        $coupon->name = Input::get('name');

        foreach($coupon_detail->matches as $match)
        {
            $match_input = Input::get('game'.$match->matchnumber);
            if(!isset($match_input))
            {
                Flash::error('Du måste fylla i alla matcher');
                return Redirect::back()->withInput();
            }
            $matches[$match->matchnumber] = Bet::get_bet_id($match_input);
        }
        foreach($matches as $match_number => $bet)
        {

            $match_bets[] = [
                'match_number' => $match_number,
                'bet' => Bet::get_bet($bet)
            ];
        }
        $rows = Bet::get_rows($match_bets, sizeof($match_bets));
        if(count($rows) > 12000)
        {
            Flash::error('Din kupong får vara max 12000 rader');
            return Redirect::back()->withInput();
        }

        if(count($rows) > 0)
        {
            if( ! $coupon->save() )
            {
                return Redirect::back()->withErrors($coupon->getErrors())->withInput();
            } else
            {
                $coupon->createCouponRows($rows);
            }
        }

        $input_svs_card = Input::get('svs_card') === "" ? null : Input::get('svs_card');
        $card_number = isset($user->svs_card) ? $user->svs_card : $input_svs_card;
        $svs_activated = false;
        if(isset($card_number) && ($coupon_detail->product_id != 3 && $coupon_detail->product_id != 4))
        {
            if($coupon->uploadFileToSVS($card_number))
            {
                $svs_activated = true;
            } else {
                Flash::error('Någonting gick fel med skapandet av kupongen, vänligen försök igen.');
                return Redirect::back();
            }
        }

        Flash::success('Din kupong skapades.');
        return View::make('coupon.completed_from_file')
            ->with('coupon', $coupon)
            ->with('svs_button', $svs_activated);
    }

    /**
     * @return mixed
     */
    public function create_own_file()
    {
        foreach(Product::all() as $product)
        {
            Coupon::_create_new($product->product);
        }

        return View::make('coupon.create_from_file');
    }

    /**
     * @return mixed
     */
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
                if($user)
                {
                    $coupon->user_id = $user->id;
                }
                $coupon->name = Input::get('name');

                // Set tile file url and move the file.
                $file_path = Input::file('own_file')->move('coupons', uniqid('_tmp') . '.' . Input::file('own_file')->getClientOriginalExtension());
                $coupon->file_url = '/'.$file_path;

                if( ! $coupon->save() )
                {
                    return Redirect::back()->withErrors($coupon->getErrors())->withInput();
                }

                $input_svs_card = Input::get('svs_card') === "" ? null : Input::get('svs_card');

                $card_number = isset($user->svs_card) ? $user->svs_card : $input_svs_card;
                $svs_activated = false;
                if(isset($card_number))
                {
                    if($coupon->uploadFileToSVS($card_number))
                    {
                        $svs_activated = true;
                    } else {
                        Flash::error('Någonting gick fel med skapandet av kupongen, vänligen försök igen.');
                        return Redirect::back()->withInput();
                    }
                }

                Flash::success('Din kupong skapades.');
                return View::make('coupon.completed_from_file')
                    ->with('coupon', $coupon)
                    ->with('svs_button', $svs_activated);
            } else
            {
                Flash::error('Filtypen är ogiltig, vänligen ladda upp en .txt fil.');
                return Redirect::back()->withInput();
            }
        } else
        {
            Flash::error('Ingen fil var vald');
            return Redirect::back()->withInput();
        }
    }

    /**
     * @return mixed
     */
    public function create_own_file_completed()
    {
        return View::make('coupon.completed_from_file');
    }

    /**
     * @return mixed
     */
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
}