<?php

class Validator {

    public function __construct() { }

    public function __destruct() { }

    /**
     * @param $string_to_sanitise - removes tags and remove or encode special characters from a string.
     * @return bool|mixed returns the true or false value depending on if the string has been sanitized
     */
    public function sanitise_string($string_to_sanitise) {
        $sanitised_string = false;

        if (!empty($string_to_sanitise))
        {
            $sanitised_string = filter_var($string_to_sanitise, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $sanitised_string;
    }

    /**Validates a sanitised username, ensuring that it is not an empty string, and that it is less than 10 characters long
     * @param $username - The username to be validated
     * @return bool|string - Returns the username if valid, otherwise returns 'false' */
    public function validate_username($username) {
        $validated_username = false;

        if(strlen($username) !== 0 || strlen($username) < 10) {
            $validated_username = $username;
        }

        return $validated_username;
    }

    /**Validates the output of the fan field, ensuring that it remains one of two predetermined values, in order to hinder tampering attempts
     * @param $fan - The fan value to be validated
     * @return bool|string - Returns the fan value if valid, otherwise returns 'false' */
    public function validate_fan($fan) {
        $validated_fan = false;

        if($fan === 'fwd' || $fan === 'rev') {
            $validated_fan = $fan;
        }

        return $validated_fan;
    }

    /**Validates the temperature input, ensuring that it is a number between -9999 and 9999
     * @param $tainted_temperature - the temperature value to validate
     * @return string - the validated temperature, otherwise 'false' if it is invalid
     */
    public function validate_temperature($temperature) {
        $validated_temperature = false;

        if(is_numeric($temperature) && ($temperature < 9999 || $temperature > -9999)) {
            $validated_temperature = $temperature;
        }

        return $validated_temperature;
    }

    /**Validates the keypad value input, ensuring that it is a 4 digit number
     * @param $tainted_keypad - the keypad value to validate
     * @return int|bool - the validated keypad value, otherwise 'false' if it is invalid
     */
    public function validate_keypad($tainted_keypad) {
        $validated_keypad = false;

        if(is_numeric($tainted_keypad) && strlen($tainted_keypad) === 4) {
            $validated_keypad = $tainted_keypad;
        }

        return $validated_keypad;
    }
}