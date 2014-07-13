<?php

class HomeController extends BaseController {
	public function index()
	{
        if( ! Auth::guest() )
        {
		    return Redirect::route('coupon');
        } else
        {
            return View::make('hello');
        }
	}

}
