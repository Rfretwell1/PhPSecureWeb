<?php

class MessageValidator
{
    public function __construct() { }

    public function __destruct() { }

    public function sanitise_string($p_string_to_sanitise)
    {
        $m_sanitised_string = false;

        if (!empty($p_string_to_sanitise))
        {
            $m_sanitised_string = filter_var($p_string_to_sanitise, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $m_sanitised_string;
    }

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