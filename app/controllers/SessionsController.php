<?php

use Artdarek\OAuth\OAuth;

class SessionsController extends BaseController {
    public $oauth;

    public function __construct( Oauth $oauth )
    {
        $this->oauth = $oauth;
        $this->oauth->setHttpClient('CurlClient');
    }

    public function create()
    {
        return View::make('session.create');
    }

    public function store()
    {
        $input = Input::only('email', 'password');
        $attempt = Auth::attempt([
            'email' => $input['email'],
            'password' => $input['password'],
        ]);

        if ( $attempt )
        {
            Flash::success('Du loggades in');
            return Redirect::intended('/');
        }

        Flash::error('Felaktiga inloggningsuppgifter, vänligen försök igen');
        return Redirect::route('login')->withInput();
    }

    public function destroy()
    {
        Flash::success('Du loggades ut.');
        Auth::logout();

        return Redirect::route('login');
    }

    /**
     * Login user with facebook
     *
     * @return void
     */

    public function loginWithFacebook() {

        // get data from input
        $code = Input::get( 'code' );

        // get fb service
        $fb = $this->oauth->consumer( 'Facebook' );

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );

            $user = User::whereFacebookId($result['id'])->first();

            if( $user )
            {
                Flash::success('Du loggades in.');
                Auth::login($user);
            } else
            {
                $user = new User;
                $user->username = slugify($result['name']);
                $user->email = $result['email'];
                $user->facebook_id = $result['id'];
                if( ! $user->save() )
                {
                    return Redirect::route('register')->withErrors($user->getErrors());
                } else
                {
                    Flash::success('Du loggades in och ett konto skapades.');
                    Auth::login($user);
                }
            }
            return Redirect::home();

        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }

    }

}
