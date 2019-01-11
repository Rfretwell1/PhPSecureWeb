<?php

/**
 * Class MessageModel - it described the type of data (string, int, boolean) and it can
 * have value constraints which place limits on the values of any simple elements based on
 * that type.
 * in this instance for the 'MessageModel' wrappers are
 */
class MessageModel
{
    private $c_arr_storage_result;
    private $c_obj_wrapper_message_file;
    private $c_obj_wrapper_message_db;
    private $c_obj_db_handle;
    private $c_obj_sql_queries;

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
        $this->c_content = null;
        $this->c_metadata = null;
        $this->c_arr_storage_result = null;
        $this->c_obj_wrapper_message_file = null;
        $this->c_obj_wrapper_message_db = null;
        $this->c_obj_db_handle = null;
        $this->c_obj_sql_queries = null;
    }

    /**
     * the destruct will be called as soon as there are no other references to a particular
     * object, or in any order during a shutdown sequence.
     * The destructor being called will happen even if the script execution is stopped.
     * Calling for a function to stop the script will prevent the remaining shutdown
     * routines from being executed.
     */
    public function __destruct() { }


    public function set_wrapper_message_file($p_obj_wrapper_message)
    {
        $this->c_obj_wrapper_message_file = $p_obj_wrapper_message;
    }

    /**
     * telling the mysql wrapper what the db information to use when its accessed.
     * @param $p_obj_wrapper_db - a wrapper is data that precedes or frames the main
     * data or a program that sets up another program so it can run successfully.
     */
    public function set_wrapper_message_db($p_obj_wrapper_db)
    {
        $this->c_obj_wrapper_message_db = $p_obj_wrapper_db;
    }

    /**
     * @param $p_obj_db_handle - sets the underlying databases handle.
     * also, optionally environment handle if the environment has been changed.
     * Users can change the containers object's underlying database while the object
     * is alive. db will verify that the handles set conforms to the concrete container's
     * requirements to db.
     */
    public function set_db_handle($p_obj_db_handle)
    {
        $this->c_obj_db_handle = $p_obj_db_handle;
    }

    /**
     * @param $p_obj_sql_queries - sets the objects for the SQL queries.
     */
    public function set_sql_queries($p_obj_sql_queries)
    {
        $this->c_obj_sql_queries = $p_obj_sql_queries;
    }

    /**
     * SoapClient - creates a soap client to talk to the EE server. allows the user to communicate with the EE server
     * enables the receiving and sending of messages with the EE server
     * and get messages back from server.
     */
    public function createSoapClient()
    {
        $obj_soap_client_handle = false;
        $wsdl = WSDL;
        $arr_soapclient = ['trace' => true, 'exceptions' => true];

        try
        {
            $obj_soap_client_handle = new SoapClient($wsdl, $arr_soapclient);
            var_dump($obj_soap_client_handle->__getFunctions());
            var_dump($obj_soap_client_handle->__getTypes());
        }
        catch (SoapFault $obj_exception)
        {
            trigger_error($obj_exception);
        }

        return $obj_soap_client_handle;
    }

    /*
    //Old function to send an inputted message to any number
    public function sendMessage($soapClient, $number, $message) {
        try {
            $soapClient->sendMessage('18JoshDavis', 'Greggs123', $number, $message, false, 'SMS');
        }
        catch (SoapFault $obj_exception) {
            trigger_error($obj_exception);
        }
        return $soapClient->__getLastRequest();
    }*/

    /** Takes the state of the circuit board and encodes it as an XML string, to be later sent to the EE server. */
    // MOVED TO CircuitboardModel - keeping this just in case (for now)
    /*public function encodeMessage($circuitBoard) {
        $switches       = $circuitBoard['switches'];
        $fan            = $circuitBoard['fan'];
        $temperature    = $circuitBoard['temperature'];
        $keypad         = $circuitBoard['keypad'];
        $encodedMessage = '{"id":"18-3110-AJ",';

        $i = -1;
        foreach($switches as $switch) {
            $i++;
            if($switch == true) {
                $encodedMessage .= "\"s$i\":\"on\",";
            }
            else {
                $encodedMessage .= "\"s$i\":\"off\",";
            }
        }

        if($fan == true) {
            $encodedMessage .= "\"fan\":\"on\",";
        }
        else {
            $encodedMessage .= "\"fan\":\"off\",";
        }

        $encodedMessage .= "\"temp\":\"$temperature\",";
        $encodedMessage .= "\"keypad\":\"$keypad\"}";




        var_dump($encodedMessage);

        $stripSlashed = stripslashes($encodedMessage);
        var_dump($stripSlashed);

        return $stripSlashed;
    }*/
    /**
     * @param $soapClient -soap client of the sending message function allows data to be sent
     * @param $encodedMessage -
     * @return mixed the return tells you the last thing to be requested from the soap client, which was to send the
     * message
     */
    public function sendMessage($soapClient, $encodedMessage) {
        try {
            $soapClient->sendMessage('18JoshDavis', 'Greggs123', '+447817814149', $encodedMessage, false, 'SMS');
        }
        catch (SoapFault $obj_exception) {
            trigger_error($obj_exception);
        }
        return $soapClient->__getLastRequest();
    }


    /**
     * @param $soapClient soap client downloads the messages from the EE server.
     *
     * @return mixed - returns mixed variables - string, integer from the server.
     */
    public function peekMessages($soapClient)
    {
        try {
            $messagesArray = $soapClient->peekMessages('18JoshDavis', 'Greggs123', 100, '+447817814149');
        } catch (SoapFault $obj_exception) {
            trigger_error($obj_exception);
        }
        return $messagesArray;
    }

    //TODO - VALIDATE XML (in MessageValidator.php)

    //TODO - fix this broke ass simpleXML stuff (works on uni pcs but not on vm? simplexml_load_string is undefined
    /**
     * @param $messagesArray - parse will put it into nicely formatted xml for when they are converted to JSON.
     * @return array - xml messages from parse.
     * parse will put it into nicely formatted xml for when they are converted to JSON.
     */
    public function parseMessages($messagesArray) {
        $parsedMessages = [];
        libxml_use_internal_errors(true);
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
    public function convertMessagesToJSON($xmlMessages) {
        $messagesJSON = [];

        foreach($xmlMessages as $xmlMessage) {
            $xml = simplexml_load_string($xmlMessage);
            $json = json_encode($xmlMessage);
            array_push($messagesJSON, $json);
        }

        return $messagesJSON;
    }


    /**
     * @return null standard result to show as no storage has been set.
     */
    public function get_storage_result()
    {
        return $this->c_arr_storage_result;
    }

    /**
     * When registering, users selected username will be checked to see if it is already taken.
     * if the username is taken it will alert the user that that user name is already taken.
     * if the username is not already in use it will allow the user to create an account with that selected username.
     */
    public function check_if_user_exists($p_acct_name) {
        $m_store_result = false;

        $this->c_obj_wrapper_message_db->set_db_handle( $this->c_obj_db_handle);
        $this->c_obj_wrapper_message_db->set_sql_queries( $this->c_obj_sql_queries);

        //TODO - figure out a model for storing downloaded msgs locally, remove this placeholder \/
        $m_store_result = $this->c_obj_wrapper_message_db->check_if_user_exists($p_acct_name);
        var_dump($m_store_result);

        if(sizeof($m_store_result) != 0) {
            $result = true;
        }
        else $result = false;
        return $result;
    }

    /**
     * @param $p_acct_name - username stored in the database
     * @param $p_acct_password - encrypted password stored in the database
     * @return bool - returns true or false if stored in the database or not
     * gets called if user doesn't exist when attempting to login
     * username and password get stored in the database once the account is registered.
     * password will be encrypted (bcrypt)
     */
    public function store_account_data($p_acct_name, $p_acct_password) {
        $m_store_result = false;

        $this->c_obj_wrapper_message_db->set_db_handle( $this->c_obj_db_handle);
        $this->c_obj_wrapper_message_db->set_sql_queries( $this->c_obj_sql_queries);

        //TODO - figure out a model for storing downloaded msgs locally, remove this placeholder \/
        $m_store_result = $this->c_obj_wrapper_message_db->insert_account_details($p_acct_name, $p_acct_password);

        return $m_store_result;
    }

    /**
     * @return bool boolean for storing or not storing the data.
     * in this case, the result is set to false.
     */
    public function store_data()
    {
        $m_store_result = false;

        $this->c_obj_wrapper_message_db->set_db_handle( $this->c_obj_db_handle);
        $this->c_obj_wrapper_message_db->set_sql_queries( $this->c_obj_sql_queries);

        //TODO - figure out a model for storing downloaded msgs locally, remove this placeholder \/
        $m_store_result = $this->c_obj_wrapper_message_db->insert_message_details('timestamp', [0, 1, 0, 1], 'fwd', 35.4, 5124);

        return $m_store_result;
    }
}
