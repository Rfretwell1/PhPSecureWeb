<?php

class SQLQueries
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
     * @return string - returns a string of the message values details entered by user
     */
	public static function insert_message_details() {
	    $m_query_string =  "INSERT IGNORE INTO messages (msg_timestamp, msg_switch1, msg_switch2, msg_switch3, msg_switch4, msg_fan, msg_temperature, msg_keypad)
                            VALUES(:msg_timestamp, :msg_switch1, :msg_switch2, :msg_switch3, :msg_switch4, :msg_fan, :msg_temperature, :msg_keypad)
                            ";

        return $m_query_string;
    }

    /**
     * @return string - return query string of inserted account details by user
     */
    public static function insert_account_details() {
        $m_query_string =  "INSERT INTO accounts (acct_name, acct_password)
                            VALUES(:acct_name, :acct_password)
                            ";

        return $m_query_string;
    }

    /*public static function check_if_user_exists() {
        $m_query_string =  "SELECT acct_id, IF(acct_name =\":acct_name\", \"true\", \"false\") as does_user_exist
                            FROM accounts
                            ";

        return $m_query_string;
    }*/

    public static function select_messages_table() {
        $m_query_string = "SELECT * FROM messages";

        return $m_query_string;
    }

    /**
     * @return string - returns a string whether or not the user exists from accounts where acct_name is stored
     */
    public static function check_if_user_exists() {
        $m_query_string =  "SELECT * FROM accounts WHERE acct_name = :acct_name";

        return $m_query_string;
    }

}