<?php

class MembersController extends \BaseController {

	/**
	 * Display a listing of the Member resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $members = User::all();

		return View::make('members.index', compact('members'));
	}

	/**
	 * Show the form for creating a new Member resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created Member resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified Member resource.
	 *
	 * @param  int  
	 * @return Response
	 */
	public function show($id)
	{
		$member = User::findOrFail($id);

        return View::make('members.show')
            ->withMember($member);
	}

	/**
	 * Show the form for editing the specified Member resource.
	 *
	 * @param  int  
	 * @return Response
	 */
	public function edit()
	{
		//
	}

	/**
	 * Update the specified Member resource in storage.
	 *
	 * @param  int  
	 * @return Response
	 */
	public function update()
	{
		//
	}

	/**
	 * Remove the specified Member resource from storage.
	 *
	 * @param  int  
	 * @return Response
	 */
	public function destroy()
	{
		//
	}

}