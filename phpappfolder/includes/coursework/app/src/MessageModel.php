<?php

class MessageModel
{
    private $c_arr_storage_result;
    private $c_obj_wrapper_message_file;
    private $c_obj_wrapper_message_db;
    private $c_obj_db_handle;
    private $c_obj_sql_queries;

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

    public function __destruct() { }

    public function set_wrapper_message_file($p_obj_wrapper_message)
    {
        $this->c_obj_wrapper_message_file = $p_obj_wrapper_message;
    }

    public function set_wrapper_message_db($p_obj_wrapper_db)
    {
        $this->c_obj_wrapper_message_db = $p_obj_wrapper_db;
    }

    public function set_db_handle($p_obj_db_handle)
    {
        $this->c_obj_db_handle = $p_obj_db_handle;
    }

    public function set_sql_queries($p_obj_sql_queries)
    {
        $this->c_obj_sql_queries = $p_obj_sql_queries;
    }

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

    public function sendMessage($soapClient, $encodedMessage) {
        try {
            $soapClient->sendMessage('18JoshDavis', 'Greggs123', '+447817814149', $encodedMessage, false, 'SMS');
        }
        catch (SoapFault $obj_exception) {
            trigger_error($obj_exception);
        }
        return $soapClient->__getLastRequest();
    }

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
    public function parseMessages($messagesArray) {
        $parsedMessages = [];
        libxml_use_internal_errors(true);
        foreach($messagesArray as $message) {
            $message = simplexml_load_string($message);
            array_push($parsedMessages, $message);
        }

        return $parsedMessages;
    }

    public function convertMessagesToJSON($xmlMessages) {
        $messagesJSON = [];

        foreach($xmlMessages as $xmlMessage) {
            //$xml = simplexml_load_string($xmlMessage);
            $json = json_encode($xmlMessage);
            array_push($messagesJSON, $json);
        }

        return $messagesJSON;
    }


    public function get_storage_result()
    {
        return $this->c_arr_storage_result;
    }

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


    public function store_account_data($p_acct_name, $p_acct_password) {
        $m_store_result = false;

        $this->c_obj_wrapper_message_db->set_db_handle( $this->c_obj_db_handle);
        $this->c_obj_wrapper_message_db->set_sql_queries( $this->c_obj_sql_queries);

        //TODO - figure out a model for storing downloaded msgs locally, remove this placeholder \/
        $m_store_result = $this->c_obj_wrapper_message_db->insert_account_details($p_acct_name, $p_acct_password);

        return $m_store_result;
    }

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
