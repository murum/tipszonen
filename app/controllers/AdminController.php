<?php

class AdminController extends BaseController {
    public function index()
    {
        $ongoing_coupons = CouponDetail::ongoingCoupons();

        return View::make(
            'admin.index',
            compact(
                'ongoing_coupons'
            )
        );
    }

    public function get_users()
    {
        $users = User::with('roles')->get();

        return View::make(
            'admin.users',
            compact(
                'users'
            )
        );
    }

    public function get_user($id)
    {
        $user = User::with('roles')->find($id);

        return View::make(
            'admin.user',
            compact(
                'user'
            )
        );
    }

    public function get_remove_user($id)
    {
        $user = User::find($id);
        $user->detachRoles(Role::all());

        if(User::destroy($id))
        {
            Flash::success('Användaren togs bort');
        } else
        {
            Flash::error('Någonting gick fel, Användaren togs inte bort');
        }

        return Redirect::back();
    }

    public function post_user($id)
    {
        $user = User::with('roles')->find($id);
        $input = Input::only('roles');

        $user->detachRoles(Role::all());
        $user->attachRoles($input['roles']);

        Flash::success('Användarens roller uppdaterades');
        return Redirect::back();
    }

    public function get_score()
    {
        $ongoing_coupons = CouponDetail::ongoingCoupons();
        $coming_coupons = CouponDetail::comingCoupons();
        $ended_coupons = CouponDetail::endedCoupons();

        return View::make(
            'admin.coupons',
            compact(
                'ongoing_coupons',
                'coming_coupons',
                'ended_coupons'
            )
        );
    }

    public function get_coupon_score($id)
    {
        $coupon = CouponDetail::with('matches', 'dividends')->whereId($id)->firstOrFail();
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

    public function post_coupon_dividend($id)
    {
        $dividend = CouponDividend::find($id);
        $dividend->win = Input::get('win');
        $dividend->amount = Input::get('amount');

        if( $dividend->save() )
        {
            Flash::success('Utdelningen uppdaterades');
        } else
        {
            Flash::error('Någonting gick fel vid uppdateringen, vänligen försök igen');
        }

        return Redirect::back();
    }
}
