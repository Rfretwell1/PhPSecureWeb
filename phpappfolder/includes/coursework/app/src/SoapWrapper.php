<?php

/**
 * Class SoapWrapper
 * A class to hold all methods relating to the use of SOAP. Facilitates communication with the EE M2M Connect server.
 */

class SoapWrapper {
    private $soap_client;

    public function __construct()
    {
        $this->soap_client = null;
    }

    public function __destruct() {

    }

    /**Initialises the SOAP client with the WSDL file specified in /settings.php
     * @return bool|SoapClient - returns the SOAP client or, if initialisation was unsuccessful, returns false
     */
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

    /**Sends a given message to the EE M2M Connect server
     * @param $message_to_send - The message to send
     * @return bool - 'true' if the message was sent successfully, otherwise 'false'
     */
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

    /**Returns an array of messages peeked from the EE M2M Connect server
     * @return array|bool - Returns an array of messages peeked from the EE M2M Connect server, or 'false' if an error is encountered
     */
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

    /**Retrieves the private 'SoapClient' from this class
     * @return bool|null - returns the SoapClient, or if it has not been initialised, returns 'false'
     */
    public function get_soap_client() {
        $soap_client = false;

        if($this->soap_client != null) {
            $soap_client = $this->soap_client;
        }

        return $soap_client;
    }
}