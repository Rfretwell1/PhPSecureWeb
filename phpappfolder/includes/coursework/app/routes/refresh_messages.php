<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post(
    '/refresh_messages',
    function(Request $request, Response $response) use ($app)
    {
        /*$message_model = $this->get('message_model');
        $wrapper_mysql = $this->get('mysql_wrapper');
        $db_handle = $this->get('dbase');
        $sql_queries = $this->get('sql_queries');
        $message_model->set_wrapper_message_db($wrapper_mysql);
        $message_model->set_db_handle($db_handle);
        $message_model->set_sql_queries($sql_queries);
        $soap = $message_model->createSoapClient();



        $peeked_messages = $message_model->peekMessages($soap);
        var_dump($peeked_messages);
        $msgs_table_data = $message_model->select_messages_table();
        var_dump($msgs_table_data);*/

        /** Uncomment this on uni PCs! **/
        /*$parsed_messages = $message_model->parseMessages($peeked_messages);
        $messages_json = $message_model->convertMessagesToJSON($peeked_messages);
        $decoded_json_array = $message_model->decodeJSON($messages_json);
        $message_model->store_peeked_messages($decoded_json_array);

        var_dump($decoded_json_array);

        var_dump($messages_json);

        var_dump($parsed_messages);

        var_dump($peeked_messages);*/

        $message_model = $this->get('message_model');
        $wrapper_mysql = $this->get('mysql_wrapper');
        $db_handle = $this->get('dbase');
        $sql_queries = $this->get('sql_queries');

        $message_model->set_wrapper_message_db($wrapper_mysql);
        $message_model->set_db_handle($db_handle);
        $message_model->set_sql_queries($sql_queries);
        $soap = $message_model->createSoapClient();

        $peeked_messages = $message_model->peekMessages($soap);
        //var_dump($peeked_messages);
        $message_table_data = $message_model->select_messages_table();

        return $this->view->render($response,
            'home.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => $_SERVER["SCRIPT_NAME"],
                'storeindatabase' => 'index.php/storeindatabase',
                'sendmessage' => 'sendmessage',
                'peekmessages' => 'index.php/peekmessages',
                'register' => 'index.php/register',
                'page_title' => 'Coursework',
                'message_table_data' => $message_table_data,
            ]);
    })->setName('home');
