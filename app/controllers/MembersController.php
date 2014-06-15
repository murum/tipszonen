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
	public function edit($id)
	{
        $member = User::findOrFail($id);
        if($member->id === Auth::user()->id )
        {
            return View::make('members.edit')
                ->withMember($member);
        } else {
            Flash::error('Du kan ej redigera den givna användaren.');
            return Redirect::home();
        }
	}

	/**
	 * Update the specified Member resource in storage.
	 *
	 * @param  int  
	 * @return Response
	 */
	public function update($id)
	{
		$member = User::findOrFail($id);

        if($member->id !== Auth::user()->id )
        {
            Flash::error('Du kan ej redigera den givna användaren.');
            return Redirect::back();
        } else {
            $svs_card = Input::get('svs_card') === "" ? null : Input::get('svs_card');

            // If the card number is anything else than 7 numbers
            if(isset($svs_card) && strlen($svs_card) !== 7)
            {
                Flash::error('Ditt spelkortsnummer måste vara 7 siffror.');
                return Redirect::back()
                    ->withInput();
            }

            $member->svs_card = $svs_card;
            $member->save();
            Flash::success('Ditt spelkortsnummer uppdaterades.');
            return Redirect::back();
        }
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