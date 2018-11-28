<?php

class MessageModel
{
    private $c_content;
    private $c_metadata;
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

    public function set_message_values($p_content, $p_metadata)
    {
        $this->c_content = $p_content;
        $this->c_metadata = $p_metadata;
    }

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

    public function sendMessage($soapClient, $number, $message) {
        try {
            $soapClient->sendMessage('18JoshDavis', 'Greggs123', $number, $message, false, 'SMS');
        }
        catch (SoapFault $obj_exception) {
            trigger_error($obj_exception);
        }
        return $soapClient->__getLastRequest();
    }

    public function peekMessages($soapClient) {
        try {
            $soapClient->peekMessages('18JoshDavis', 'Greggs123', 100, '+447817814149');
        }
        catch (SoapFault $obj_exception) {
            trigger_error($obj_exception);
        }
        return $soapClient->__getLastRequest();
    }

    public function get_storage_result()
    {
        return $this->c_arr_storage_result;
    }

    public function store_data()
    {
        $m_store_result = false;

        $this->c_obj_wrapper_message_db->set_db_handle( $this->c_obj_db_handle);
        $this->c_obj_wrapper_message_db->set_sql_queries( $this->c_obj_sql_queries);

        $m_store_result = $this->c_obj_wrapper_message_db->insert_message_details($this->c_content, $this->c_metadata);

        return $m_store_result;
    }
}
