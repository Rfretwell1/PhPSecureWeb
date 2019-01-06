<?php

class SQLQueries
{
	public function __construct() { }

	public function __destruct() { }

	public static function insert_message_details() {
	    $m_query_string =  "INSERT INTO messages (msg_timestamp, msg_switch1, msg_switch2, msg_switch3, msg_switch4, msg_fan, msg_temperature, msg_keypad)
                            VALUES(:msg_timestamp, :msg_switch1, :msg_switch2, :msg_switch3, :msg_switch4, :msg_fan, :msg_temperature, :msg_keypad)
                            ";

        return $m_query_string;
    }

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

    public static function check_if_user_exists() {
        $m_query_string =  "SELECT * FROM accounts WHERE acct_name = :acct_name";

        return $m_query_string;
    }

}