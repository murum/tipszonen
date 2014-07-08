<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    "accepted"         => ":attribute måste vara accepterat.",
    "active_url"       => ":attribute är inte en giltig URL.",
    "after"            => ":attribute måste vara ett datum efter :date.",
    "alpha"            => ":attribute får endast innehålla bokstäver.",
    "alpha_dash"       => ":attribute får endast innehålla bokstäver, siffror och streck.",
    "alpha_num"        => ":attribute får endast innehålla bokstäver, siffror.",
    "before"           => ":attribute måste vara ett datum före :date.",
    "between"          => array(
        "numeric" => ":attribute måste vara mellan :min - :max.",
        "file"    => ":attribute måste vara mellan :min - :max kilobytes.",
        "string"  => ":attribute måste vara mellan :min - :max tecken.",
    ),
    "confirmed"        => ":attribute bekräftelsen stämmer inte överens.",
    "date"             => ":attribute är inte ett giltigt datumformat.",
    "date_format"      => ":attribute matchar inte formatet :format.",
    "different"        => ":attribute och :other måsta vara olika.",
    "digits"           => ":attribute måste vara :digits siffror.",
    "digits_between"   => ":attribute måste vara mellan :min och :max siffror.",
    "email"            => ":attribute formatet är inte giltigt.",
    "exists"           => ":attribute finns redan.",
    "image"            => ":attribute måste vara en bild.",
    "in"               => "Det valda :attribute är ogiltigt.",
    "integer"          => ":attribute måste vara ett nummer.",
    "ip"               => ":attribute måste vara en giltig IP-adress.",
    "max"              => array(
        "numeric" => ":attribute måste vara mindre än :max tecken.",
        "file"    => ":attribute måste vara mindre än  :max kilobytes.",
        "string"  => ":attribute måste vara mindre än :max characters.",
    ),
    "mimes"            => "The :attribute must be a file of type: :values.",
    "min"              => array(
        "numeric" => ":attribute måste innehålla mer än :min tecken.",
        "file"    => ":attribute måste innehålla mer än:min kilobytes.",
        "string"  => ":attribute måste innehålla mer än :min tecken.",
    ),
    "not_in"           => "Det valda :attribute är ogiltigt.",
    "numeric"          => ":attribute måste vara en siffra.",
    "regex"            => ":attribute är av ogilitgt format.",
    "required"         => ":attribute fältet är obligatoriskt.",
    "required_if"      => ":attribute krävs när :other är :value.",
    "required_with"    => ":attribute krävs när :values är aktiva.",
    "required_without" => ":attribute krävs när :values är inaktiva.",
    "same"             => ":attribute och :other måste stämma överens.",
    "size"             => array(
        "numeric" => ":attribute måste vara :size.",
        "file"    => ":attribute måste vara :size kilobytes.",
        "string"  => ":attribute måste vara :size characters.",
    ),
    "unique"           => ":attribute har redan blivit använt.",
    "url"              => ":attribute är en ogiltig url.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => array(),


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Rules
    |--------------------------------------------------------------------------
    |
    | Custom rules created in app/validators.php
    |
    */
    "alpha_spaces"     => ":attribute får endast innehålla bokstäver och mellanrum.",
    "alpha_num_spaces"     => ":attribute får endast innehålla bokstäver, siffror och mellanrum.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => array(
        'username' => 'Användarnamn',
        'email' => 'E-post',
        'email_confirmation' => 'Emailbekräftelse',
        'password' => 'Lösenord',
        'password_confirmation' => 'Lösenordsbekräftelse',
        'firstname' => 'Förnamn',
        'lastname' => 'Efternamn',
        'city' => 'Ort',
        'zipcode' => 'Postnr',
        'adress' => 'Address',
        'name' => 'Namn'
    ),

);
