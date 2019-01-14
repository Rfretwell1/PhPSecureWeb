<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post(
    '/sendmessage',
    function(Request $request, Response $response) use ($app)
    {
        //Loading the required files
        $mysql_wrapper      = $this->get('mysql_wrapper');
        $database_handle    = $this->get('dbase');
        $sql_queries        = $this->get('sql_queries');
        $messages_model     = $this->get('messages_model');
        $validator          = $this->get('validator');

        //Loads the messages from the database & stores them in an array
        $messages_model->set_database_handle($database_handle);
        $messages_model->set_sql_wrapper($mysql_wrapper);
        $messages_model->set_sql_queries($sql_queries);
        $message_table_data = $messages_model->select_messages_table();

        $tainted_params = $request->getParsedBody();

        //Gets the values (or lack thereof) of the switch check boxes, and adds them to an array
        $switch_array_keys = ['switch1', 'switch2', 'switch3', 'switch4'];
        $switches = [];
        foreach($switch_array_keys as $key) {
            if(array_key_exists($key, $tainted_params)) {
                array_push($switches, true);
            }
            else {
                array_push($switches, false);
            }
        }

        //Gets the tainted values for the fan, temperature, and keypad
        $tainted_fan        =  $tainted_params['fan'];
        $tainted_temp       =  $tainted_params['heater'];
        $tainted_keypad     =  $tainted_params['keypad'];

        //Validates the tainted params
        $validated_fan      = $validator->validate_fan($tainted_fan);
        $validated_temp     = $validator->validate_temperature($tainted_temp);
        $validated_keypad   = $validator->validate_keypad($tainted_keypad);

        //Checking for any errors with the input & building a string to tell the user what they have done wrong
        $error_message = '';
        if($validated_fan === false) {
            $error_message .= "Value for field 'fan' is invalid. Value should be 'fwd' OR 'rev'";
        }

        if($validated_temp === false) {
            $error_message .= "Value for field 'temperature' is invalid. Value should be a number between -9999 and 9999";
        }

        if($validated_keypad === false) {
            $error_message .= "Value for field 'keypad value' is invalid. Value should be a 4 digit number";
        }

        if(strlen($error_message) === 0) {
            //If no error message, creates a CircuitboardModel & sets it state to that of the user entered values
            $circuitboard_model = $this->get('circuitboard_model');
            $circuitboard_model->set_circuitboard_state($switches, $validated_fan, $validated_temp, $validated_keypad);
            //Creates a JSON string of the circuitboard state, ready to be sent to the M2M server
            $message_to_send = $circuitboard_model->create_circuitboard_message();

            //Gets the SoapWrapper, initiates a client and then sends the message
            $soap_wrapper = $this->get('soap_wrapper');
            $soap_wrapper->init_soap_client();
            $soap_wrapper->send_message($message_to_send);
            $submit_message = 'Message successfully sent.';
        }
        else {
            //Shows the user the error message
            $submit_message = $error_message;
        }

        return $this->view->render($response,
            'home.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => $_SERVER["SCRIPT_NAME"],
                'sendmessage' => 'sendmessage',
                'refresh_messages' =>'refresh_messages',
                'register' => 'register',
                'page_title' => 'Home',
                'login' => 'login',
                'home' => '/coursework',
                'message_table_data' => $message_table_data,
                'submit_message' => $submit_message,
            ]
        );
    }
);