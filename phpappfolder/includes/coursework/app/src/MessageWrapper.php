<?php

/**
 * SessionWrapper.php
 *
 * create a wrapper for the SESSION global array
 *
 * Author: CF Ingrams
 * Email: <clinton@cfing.co.uk>
 * Date: 22/10/2017
 *
 *
 * @author CF Ingrams <clinton@cfing.co.uk>
 * @copyright CFI
 *
 */

class MessageWrapper
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
    public function __destruct() {
    }

    /**
     * @param $p_session_key -
     * @param $p_message_value_to_set -
     * @return bool - success or fail depending if the value is set successfully.
     */
    public static function set_message($p_session_key, $p_message_value_to_set)
    {
        $m_session_value_set_successfully = false;
        if (!empty($p_message_value_to_set))
        {
            $_SESSION[$p_session_key] = $p_message_value_to_set;
            if (strcmp($_SESSION[$p_session_key], $p_message_value_to_set) == 0)
            {
                $m_session_value_set_successfully = true;
            }
        }
        return $m_session_value_set_successfully;
    }

    /**
     * @param $p_session_key
     * @return bool
     */
    public static function get_message($p_session_key)
    {
        $m_session_value = false;

        if (isset($_SESSION[$p_session_key]))
        {
            $m_session_value = $_SESSION[$p_session_key];
        }
        return $m_session_value;
    }

    /**
     * @param $p_session_key
     * @return bool
     */
    public static function get_session($p_session_key)
    {
        $m_unset_session = false;
        if (isset($_SESSION[$p_session_key]))
        {
            unset($_SESSION[$p_session_key]);
        }
        if (!isset($_SESSION[$p_session_key]))
        {
            $m_unset_session = true;
        }
        return $m_unset_session;
    }
}
