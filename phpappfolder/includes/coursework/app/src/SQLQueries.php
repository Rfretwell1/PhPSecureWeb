<?php

/**
 * Class SQLQueries
 * A class to hold the SQL query strings that will later be prepared in MySQLWrapper.php
 */
class SQLQueries {

	public function __construct() { }

	public function __destruct() { }

    /**A query string for inserting the given message details into the messages table
     * @return string - the string for use in the query
     */
	public static function insert_message_details() {
	    $query_string =  "INSERT IGNORE INTO messages (msg_timestamp, msg_switch1, msg_switch2, msg_switch3, msg_switch4, msg_fan, msg_temperature, msg_keypad)
                            VALUES(:msg_timestamp, :msg_switch1, :msg_switch2, :msg_switch3, :msg_switch4, :msg_fan, :msg_temperature, :msg_keypad)
                            ";

        return $query_string;
    }

    /**A query string for inserting the given username and password into the accounts table
     * @return string - the string for use in the query
     */
    public static function insert_account_details() {
        $query_string =  "INSERT INTO accounts (acct_name, acct_password)
                            VALUES(:acct_name, :acct_password)
                            ";

        return $query_string;
    }

    /**A query string for selecting all data from the messages table
     * @return string - the string for use in the query
     */
    public static function select_messages_table() {
        $query_string = "SELECT * FROM messages";

        return $query_string;
    }

    /**A query string for selecting all columns from accounts, where the username matches the one supplied
     * @return string - the string for use in the query
     */
    public static function select_account_data() {
        $query_string =  "SELECT * FROM accounts WHERE acct_name = :acct_name";

        return $query_string;
    }
}