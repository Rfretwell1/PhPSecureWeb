<?php

class Validator
{
    /**
     * MessageModel constructor. - the __construct method is used to pass in parameters when you
     * first create an object - called 'defining constructor method'.
     * __construct is always called when creating new objects or they are invoked when
     * the initialization takes place. it is suitable for any of the initializations that
     * the object may need before it is used.
     * __construct method is the first method executed.
     */
    public function __construct() { }

    /**
     * the destruct will be called as soon as there are no other references to a particular
     * object, or in any order during a shutdown sequence.
     * The destructor being called will happen even if the script execution is stopped.
     * Calling for a function to stop the script will prevent the remaining shutdown
     * routines from being executed.
     */
    public function __destruct() { }

    /**
     * @param $string_to_sanitise - removes tags and remove or encode special characters from a string.
     * @return bool|mixed returns the true or false value depending on if the string has been sanitized
     */
    public function sanitise_string($string_to_sanitise)
    {
        $sanitised_string = false;

        if (!empty($string_to_sanitise))
        {
            $sanitised_string = filter_var($string_to_sanitise, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $sanitised_string;
    }

    public function validate_fan($tainted_fan) {
        $validated_fan = false;

        if($tainted_fan === 'fwd' || $tainted_fan === 'rev') {
            $validated_fan = $tainted_fan;
        }

        return $validated_fan;
    }

    /**Validates the temperature input, ensuring that it is a number between -9999 and 9999
     * @param $tainted_temperature - the temperature value to validate
     * @return string - the validated temperature, OR false if it is invalid
     */
    public function validate_temperature($tainted_temperature) {

        if(is_numeric($tainted_temperature)) {
            if($tainted_temperature < 9999 || $tainted_temperature > -9999) {
                $validated_temperature = $tainted_temperature;
            }
            else {
                $validated_temperature = false;
            }
        }
        else {
            $validated_temperature = false;
        }

        return $validated_temperature;
    }

    /**Validates the keypad value input, ensuring that it is a 4 digit number
     * @param $tainted_keypad - the keypad value to validate
     * @return int|string - the validated keypad value, OR a reason as for why the keypad value is invalid
     */
    public function validate_keypad($tainted_keypad) {

        if(is_numeric($tainted_keypad)) {
            if(strlen($tainted_keypad) === 4) {
                $validated_keypad = $tainted_keypad;
            }
            else {
                $validated_keypad = false;
            }
        }
        else {
            $validated_keypad = false;
        }

        return $validated_keypad;
    }

    /**
     * @param $email_to_sanitise - removes all characters except letters, digits and !"£$%^&*()-_+={}[]@'.
     * @return bool|mixed returns either true or false depending on the characters entered
     */
    public function sanitise_email($email_to_sanitise)
    {
        $cleaned_email = false;

        if (!empty($email_to_sanitise))
        {
            $sanitised_email = filter_var($email_to_sanitise, FILTER_SANITIZE_EMAIL);
            $cleaned_email = filter_var($sanitised_email, FILTER_VALIDATE_EMAIL);
        }
        return $cleaned_email;
    }
}