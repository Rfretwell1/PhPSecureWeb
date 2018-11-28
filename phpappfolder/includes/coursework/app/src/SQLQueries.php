<?php

class SQLQueries
{
	public function __construct() { }

	public function __destruct() { }

	public static function insert_message_details() {
	    $m_query_string =  "INSERT INTO downloaded_messages (message_content, message_metadata)
                            VALUES(:message_content, :message_metadata)
                            ";

        return $m_query_string;
    }
}
