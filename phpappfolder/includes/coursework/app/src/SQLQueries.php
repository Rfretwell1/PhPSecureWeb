<?php

/**
	* SQLQueries.php
	*
	* hosts all SQL queries to be used by the Model
	*
	* Author: CF Ingrams
	* Email: <clinton@cfing.co.uk>
	* Date: 22/10/2017
	*
	* @author CF Ingrams <clinton@cfing.co.uk>
	* @copyright CFI
	*/

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
