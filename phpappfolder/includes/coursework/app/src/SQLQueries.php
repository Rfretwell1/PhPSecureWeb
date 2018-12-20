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
}