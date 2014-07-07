<?php

class AdminController extends BaseController {
    public function index()
    {
        return View::make('admin.index');
    }

    public function get_score()
    {
        return View::make('admin.coupons');
    }

    public function get_coupon_score($id)
    {
        $coupon = CouponDetail::with('matches')->whereId($id)->firstOrFail();
        return View::make('admin.update_coupon', compact('coupon'));
    }

    public function post_coupon_score($id)
    {
        $match = Match::find($id);
        $match->time = Input::get('time');
        $match->home_score = Input::get('home_score');
        $match->away_score = Input::get('away_score');
        $match->ended = Input::get('ended');

        if( $match->save() )
        {
            Flash::success('Matchen uppdaterades');
        } else
        {
            Flash::error('Någonting gick fel vid uppdateringen, vänligen försök igen');
        }

        return Redirect::back();
    }
}
