<?php

use Laracasts\Validation\FormValidationException;
use Tipszonen\Forms\RegisterForm;

class UsersController extends \BaseController {

    protected $registrationForm;

    /**
     * @param RegisterForm $registrationForm
     */
    public function __construct(RegisterForm $registrationForm)
    {
        $this->registrationForm = $registrationForm;
    }

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

        $input = Input::all(); // TODO: Change to ::only()

        try {
            $this->registrationForm->validate($input);

            $user = new User;
            $user->fill($input);
            $user->save();

            Auth::login($user, true);

        } catch (FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        return Redirect::home();
    }

    /**
     * Display the specified User resource.
     *
     * @param  int
     *
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
     *
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
     *
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
     *
     * @return Response
     */
    public function destroy()
    {
        //
    }

}
