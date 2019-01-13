<?php
/**
 * Created by PhpStorm.
 * User: php-slim
 * Date: 13/01/19
 * Time: 17:19
 */

class MessagesModel
{
    private $database_handle;
    private $sql_wrapper;
    private $sql_queries;

    /**
     * MessageModel constructor. - the __construct method is used to pass in parameters when you
     * first create an object - called 'defining constructor method'.
     * __construct is always called when creating new objects or they are invoked when
     * the initialization takes place. it is suitable for any of the initializations that
     * the object may need before it is used.
     * __construct method is the first method executed.
     */
    public function __construct()
    {
        $this->database_handle = null;
        $this->sql_wrapper = null;
        $this->sql_queries = null;
    }

    /**
     * the destruct will be called as soon as there are no other references to a particular
     * object, or in any order during a shutdown sequence.
     * The destructor being called will happen even if the script execution is stopped.
     * Calling for a function to stop the script will prevent the remaining shutdown
     * routines from being executed.
     */
    public function __destruct() { }

    /**
     * @param $p_obj_db_handle - sets the underlying databases handle.
     * also, optionally environment handle if the environment has been changed.
     * Users can change the containers object's underlying database while the object
     * is alive. db will verify that the handles set conforms to the concrete container's
     * requirements to db.
     */
    public function set_database_handle($database_handle)
    {
        $this->database_handle = $database_handle;
    }

    /**
     * telling the mysql wrapper what the db information to use when its accessed.
     * @param $p_obj_wrapper_db - a wrapper is data that precedes or frames the main
     * data or a program that sets up another program so it can run successfully.
     */
    public function set_sql_wrapper($sql_wrapper)
    {
        $this->sql_wrapper = $sql_wrapper;
    }

    /**
     * @param $p_obj_sql_queries - sets the objects for the SQL queries.
     */
    public function set_sql_queries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    public function parse_messages($peeked_messages) {
        $parsed_messages = [];
        libxml_use_internal_errors(true);

        foreach($peeked_messages as $message) {
            $message_xml          = simplexml_load_string($message);
            $message_json         = json_encode($message_xml);
            $message_json_decoded = json_decode($message_json);

            array_push($parsed_messages, $message_json_decoded);
        }

        return $parsed_messages;
    }

    /**Filters through an array of peeked messages, and returns only the messages of the correct group ID.
     * @param $peeked_messages - the array of peeked messages to be filtered
     * @return array - returns an array of peeked messages that have the correct group ID
     */
    public function filter_messages($peeked_messages) {
        $filtered_messages_array = [];

        foreach($peeked_messages as $message) {
            if(array_key_exists('id', $message['message'])) {
                if($message['message']['id'] === '18-3110-AJ') {
                    array_push($filtered_messages_array, $message);
                }
            }
        }

        return $filtered_messages_array;
    }

    public function select_messages_table() {
        $messages_table_data = false;

        $this->sql_wrapper->set_database_handle( $this->database_handle);
        $this->sql_wrapper->set_sql_queries( $this->sql_queries);

        $messages_table_data = $this->sql_wrapper->select_messages_table();
        return $messages_table_data;
    }

    public function store_message_data($message){
        $storage_result = false;

        $timestamp  = $message['receivedtime'];
        $switches   =[$message['message']['s1'],
                      $message['message']['s2'],
                      $message['message']['s3'],
                      $message['message']['s4']];
        $fan        = $message['message']['fan'];
        $temp       = $message['message']['temp'];
        $keypad     = $message['message']['kp'];

        $this->sql_wrapper->set_database_handle( $this->database_handle);
        $this->sql_wrapper->set_sql_queries( $this->sql_queries);

        $storage_result = $this->sql_wrapper->insert_message_details($timestamp, $switches, $fan, $temp, $keypad);

        return $storage_result;
    }

}

//TODO this function has been updated - remove if all works
/**
 * @return bool boolean for storing or not storing the data.
 * in this case, the result is set to false.
 */
/*public function store_message_data($msg_timestamp, $msg_switches, $msg_fan, $msg_temp, $msg_keypad){
    $m_store_result = false;

    $this->sql_wrapper->set_database_handle( $this->database_handle);
    $this->sql_wrapper->set_sql_queries( $this->sql_queries);

    $m_store_result = $this->sql_wrapper->insert_message_details($msg_timestamp, $msg_switches, $msg_fan, $msg_temp, $msg_keypad);

    return $m_store_result;
}*/


/*public function store_peeked_messages($p_decoded_json_array) {
    $this->c_obj_wrapper_message_db->set_database_handle( $this->c_obj_db_handle);
    $this->c_obj_wrapper_message_db->set_sql_queries( $this->c_obj_sql_queries);

    foreach($p_decoded_json_array as $decoded_json_message) {
        if (array_key_exists('id', $decoded_json_message['message'])) {
            if ($decoded_json_message['message']['id'] === '18-3110-AJ') {
                $msg_to_insert = $decoded_json_message['message'];
                $msg_timestamp = $decoded_json_message['receivedtime'];

                $msg_switches = [$msg_to_insert['s1'], $msg_to_insert['s2'], $msg_to_insert['s3'], $msg_to_insert['s4']];
                $msg_fan = $msg_to_insert['fan'];
                $msg_temp = $msg_to_insert['temp'];
                $msg_keypad = $msg_to_insert['kp'];


                $this->c_obj_wrapper_message_db->insert_message_details($msg_timestamp, $msg_switches, $msg_fan, $msg_temp, $msg_keypad);
            }

        }
    }
}*/

//TODO LEGACY FUNCTIONS - parse_messages SHOULD replace these
/*public function parseMessages($messagesArray) {
    $parsedMessages = [];

    foreach($messagesArray as $message) {
        $message = simplexml_load_string($message);
        array_push($parsedMessages, $message);
    }

    return $parsedMessages;
}

/**
 * @param  formatted xml messages are converted to JSON from parse.
 * @return array - the parse xml messages will be returned.
 */
/*public function convertMessagesToJSON($xmlMessages) {
    $messagesJSON = [];

    foreach($xmlMessages as $xmlMessage) {
        $xml = simplexml_load_string($xmlMessage);
        $json = json_encode($xml);
        array_push($messagesJSON, $json);
    }

    return $messagesJSON;
}

public function decodeJSON($p_encoded_json) {
    $decoded_json_array = [];
    foreach($p_encoded_json as $encoded_json_string) {
        $decoded_json_object = json_decode($encoded_json_string, true);
        array_push($decoded_json_array, $decoded_json_object);
    }
    return $decoded_json_array;
}*/