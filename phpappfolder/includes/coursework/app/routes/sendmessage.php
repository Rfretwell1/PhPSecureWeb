<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post(
    '/sendmessage',
    function(Request $request, Response $response) use ($app)
    {
        $arr_tainted_params = $request->getParsedBody();
        var_dump($arr_tainted_params);
        $switches = array($arr_tainted_params['switch1'], $arr_tainted_params['switch2'], $arr_tainted_params['switch3'], $arr_tainted_params['switch4']);
        $fan = $arr_tainted_params['fan'];
        $tainted_heater = $arr_tainted_params['heater'];
        $tainted_keypad = $arr_tainted_params['keypad'];

        $validator = $this->get('message_validator');

        $circuitboard_model = $this->get('circuitboard_model');
        $circuitboard_model->set_circuitboard_state($switches, $fan, $tainted_heater, $tainted_keypad);
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
        $message_model->store_data();
        $store_result = $message_model->get_storage_result();
        var_dump($store_result);


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

        return $this->view->render($response,
            'home.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => $_SERVER["SCRIPT_NAME"],
                'storeindatabase' => 'storeindatabase',
                'sendmessage' => 'sendmessage',
                'peekmessages' => 'peekmessages',
                'page_title' => 'Coursework',
                'sentmessage' => 'Message successfully sent.'
            ]);

    });
