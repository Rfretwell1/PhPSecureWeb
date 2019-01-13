<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post(
    '/sendmessage',
    function(Request $request, Response $response) use ($app)
    {
        $mysql_wrapper      = $this->get('mysql_wrapper');
        $database_handle    = $this->get('dbase');
        $sql_queries        = $this->get('sql_queries');
        $messages_model     = $this->get('messages_model');

        $messages_model->set_database_handle($database_handle);
        $messages_model->set_sql_wrapper($mysql_wrapper);
        $messages_model->set_sql_queries($sql_queries);
        $message_table_data = $messages_model->select_messages_table();

        $tainted_params = $request->getParsedBody();

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

        $tainted_fan     =  $tainted_params['fan'];
        $tainted_temp    =  $tainted_params['heater'];
        $tainted_keypad  =  $tainted_params['keypad'];

        $validator          = $this->get('validator');
        $validated_fan      = $validator->validate_fan($tainted_fan);
        $validated_temp     = $validator->validate_temperature($tainted_temp);
        $validated_keypad   = $validator->validate_keypad($tainted_keypad);

        $error_message = '';
        if($validated_fan === false) {
            $error_message .= "Value for field 'fan' is invalid. Value should be 'fwd' OR 'rev'\r\n";
        }

        if($validated_temp === false) {
            $error_message .= "Value for field 'temperature' is invalid. Value should be a number between -9999 and 9999\r\n";
        }

        if($validated_keypad === false) {
            $error_message .= "Value for field 'keypad value' is invalid. Value should be a 4 digit number\r\n";
        }

        if(strlen($error_message) === 0) {
            $circuitboard_model = $this->get('circuitboard_model');
            $circuitboard_model->set_circuitboard_state($switches, $validated_fan, $validated_temp, $validated_keypad);
            $message_to_send = $circuitboard_model->create_circuitboard_message();

            $soap_wrapper = $this->get('soap_wrapper');
            $soap_wrapper->init_soap_client();
            $soap_wrapper->send_message($message_to_send);
            $submit_message = 'Message successfully sent.';
        }
        else {
            $submit_message = $error_message;
        }

        return $this->view->render($response,
            'home.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => $_SERVER["SCRIPT_NAME"],
                'sendmessage' => 'sendmessage',
                'peekmessages' => 'peekmessages',
                'register' => 'register',
                'page_title' => 'Home',
                'message_table_data' => $message_table_data,
                'submit_message' => $submit_message,
            ]);
    });

/*$circuitboard_model = $this->get('circuitboard_model');
$circuitboard_model->set_circuitboard_state($switches, $validated_fan, $validated_temp, $validated_keypad);
$encodedMessage = $circuitboard_model->create_circuitboard_message();

$message_model = $this->get('message_model');
$soap = $message_model->createSoapClient();
$message_model->sendMessage($soap, $encodedMessage);

$wrapper_mysql = $this->get('mysql_wrapper');
$db_handle = $this->get('dbase');
$sql_queries = $this->get('sql_queries');

$message_model->set_wrapper_message_db($wrapper_mysql);
$message_model->set_db_handle($db_handle);
$message_model->set_sql_queries($sql_queries);
//$message_model->store_data();
//var_dump(date(DATE_W3C));
$message_model->store_message_data(date(), $switches, $fan, $tainted_heater, $tainted_keypad);
$store_result = $message_model->get_storage_result();
var_dump($store_result);

$message_table_data = $message_model->select_messages_table();*/


/*return $this->view->render($response,
    'display_sent_message.html.twig',
    [
        'landing_page' => $_SERVER["SCRIPT_NAME"],
        'action' => 'index.php/displaysentmessage',
        'css_path' => CSS_PATH,
        'storage_text' => 'You sent a message: ',
        'switches' => $switches,
        'fan' => $fan,
        'heater' => $tainted_heater,
        'keypad' => $tainted_keypad,
    ]);*/
