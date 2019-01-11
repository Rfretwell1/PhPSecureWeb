<?php

/**
 * Class MessageValidator - Validating data is essential when it comes to saving data in the database, users will
 * input all the necessary information and then submit that information. Validating that data can be done on the
 * server and on the clients web browser. Server side validation
 */
class MessageValidator
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
     * filter_var function will filter a variable with the specified filter. this function is used to both validate
     * and sanitise the data.
     * Sanitizing means that a string will be rewritten in a way so that nothing will be executed upon displaying that
     * string. The reasoning for sanitizing is that if a user's profile and first name field, malicious users will test
     * for cross site scripting exploits of the site. Sanitize the string by removing all illegal characters from
     * the string that could possibly break the string.
     * @param $p_string_to_sanitise
     * @return bool|mixed
     */
    public function sanitise_string($p_string_to_sanitise)
    {
        $m_sanitised_string = false;

        if (!empty($p_string_to_sanitise))
        {
            $m_sanitised_string = filter_var($p_string_to_sanitise, FILTER_SANITIZE_STRING,
                FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $m_sanitised_string;
    }

    /**
     * The validate integer is used to validate values as integers.
     *
     * @param $p_value_to_check - the inputted integer, return value 1 if fails, otherwise will show inputted value
     * @return bool|mixed - checked value to be returned, either 1 for fail or any other value if successful.
     */
    public function validate_integer($p_value_to_check)
    {
        $m_checked_value = false;
        $options = array(
            'options' => array(
                'default' => -1, // value to return if the filter fails
                'min_range' => 0
            )
        );

        if (isset($p_value_to_check))
        {
            $m_checked_value = filter_var($p_value_to_check, FILTER_VALIDATE_INT, $options);
        }

        return $m_checked_value;
    }
}