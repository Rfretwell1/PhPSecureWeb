<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * all of the routes tell the application what to do.
 * the twig files connect what the user wants to display on the page
 * e.g. if the user clicks on register it will re-direct the user to the index.php/register page for user to be
 * able to register.
 */

$app->get('/', function(Request $request, Response $response) {
    //Loading the required files
    $messages_model     = $this->get('messages_model');
    $soap_wrapper       = $this->get('soap_wrapper');
    $database_handle    = $this->get('dbase');
    $mysql_wrapper      = $this->get('mysql_wrapper');
    $sql_queries        = $this->get('sql_queries');

    //Setting the database files information for the messages model
    $messages_model->set_database_handle($database_handle);
    $messages_model->set_sql_wrapper($mysql_wrapper);
    $messages_model->set_sql_queries($sql_queries);

    //Initialising the soap client
    $soap_wrapper  ->init_soap_client();

    //Peeking the messages from the M2M server, parsing them, converting them to XML, then filtering out the other groups. The filtered messages are then added to the database.
    $peeked_messages    = $soap_wrapper->peek_messages();
    //TODO - Uncomment this on uni PCs - libxml doesn't work on VM
    /*$parsed_messages    = $messages_model->parse_messages($peeked_messages);
    $filtered_messages  = $messages_model->filter_messages($parsed_messages);

    foreach($filtered_messages as $message) {
        $messages_model->store_message_data($message);
    }*/

    $message_table_data = $messages_model->select_messages_table();

    return $this->view->render($response,
        'home.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => $_SERVER["SCRIPT_NAME"],
            'sendmessage' => 'index.php/sendmessage',
            'refresh_messages' =>'index.php/refresh_messages',
            'login' => 'index.php/login',
            'register' => 'index.php/register',
            'page_title' => 'Coursework',
            'message_table_data' => $message_table_data,
        ]);
})->setName('home');


/*$message_model = $this->get('message_model');
$wrapper_mysql = $this->get('mysql_wrapper');
$db_handle = $this->get('dbase');
$sql_queries = $this->get('sql_queries');


$message_model->set_wrapper_message_db($wrapper_mysql);
$message_model->set_db_handle($db_handle);
$message_model->set_sql_queries($sql_queries);
//$soap = $message_model->createSoapClient();*/