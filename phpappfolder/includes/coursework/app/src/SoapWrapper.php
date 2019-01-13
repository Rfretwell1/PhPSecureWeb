<?php
/**
 * Class SoapWrapper
 * A class to hold all methods relating to the use of SOAP. Facilitates communication with the EE M2M Connect servers.
 */

class SoapWrapper
{
    private $soap_client;

    public function __construct()
    {
        $this->soap_client = null;
    }

    public function __destruct() {

    }

    public function init_soap_client()
    {
        $soap_client_handle = false;
        $soap_client_settings = ['trace' => true, 'exceptions' => true];
        $wsdl = WSDL;

        try
        {
            $soap_client_handle = new SoapClient($wsdl, $soap_client_settings);
        }
        catch (SoapFault $obj_exception)
        {
            trigger_error($obj_exception);
        }

        $this->soap_client = $soap_client_handle;

        return $soap_client_handle;
    }

    public function send_message($message_to_send) {
        $soap_client = $this->soap_client;
        $message_sent_successfully = false;

        if($soap_client != null) {
            try {
                $soap_client->sendMessage('18JoshDavis', 'Greggs123', '+447817814149', $message_to_send, false, 'SMS');
                $message_sent_successfully = true;
            } catch (SoapFault $obj_exception) {
                trigger_error($obj_exception);
            }
        }
        return $message_sent_successfully;
    }

    public function peek_messages() {
        $soap_client = $this->soap_client;
        $peeked_messages = false;

        if($soap_client != null) {
            try {
                $peeked_messages = $soap_client->peekMessages('18JoshDavis', 'Greggs123', 100, '+447817814149');
            } catch (SoapFault $obj_exception) {
                trigger_error($obj_exception);
            }
        }
        return $peeked_messages;
    }

    public function get_soap_client() {
        $soap_client = false;

        if($this->soap_client != null) {
            $soap_client = $this->soap_client;
        }

        return $soap_client;
    }
}