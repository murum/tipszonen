<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the User resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new User resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('user.create');
	}

	/**
	 * Store a newly created User resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $user = new User(Input::all());

        if( ! $user->save() )
        {
            return Redirect::back()->withInput()->withErrors($user->getErrors());
        }
        return Redirect::home();
	}

	/**
	 * Display the specified User resource.
	 *
	 * @param  int  
	 * @return Response
	 */
	public function show()
	{
		//
	}

	/**
	 * Show the form for editing the specified User resource.
	 *
	 * @param  int  
	 * @return Response
	 */
	public function edit()
	{
		//
	}

	/**
	 * Update the specified User resource in storage.
	 *
	 * @param  int  
	 * @return Response
	 */
	public function update()
	{
		//
	}

	/**
	 * Remove the specified User resource from storage.
	 *
	 * @param  int  
	 * @return Response
	 */
	public function destroy()
	{
		//
	}

}