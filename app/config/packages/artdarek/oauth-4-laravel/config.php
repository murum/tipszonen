<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => getenv('FB_CLIENT_ID'),
            'client_secret' => getenv('FB_CLIENT_SECRET'),
            'scope'         => array('email','user_friends'),
        ),		

	)

);