<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * all of the routes tell the application what to do.
 * the twig files connect what the user wants to display on the page
 * e.g. if the user clicks on register it will re-direct the user to the index.php/register page for user to be
 * able to register.
 */

/**
 *
 */
$app->get('/', function(Request $request, Response $response) {

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
            'sendmessage' => 'index.php/sendmessage',
            'peekmessages' => 'index.php/peekmessages',
            'refresh_messages' =>'index.php/refresh_messages',
            'register' => 'index.php/register',
            'page_title' => 'Coursework',
            'message_table_data' => $message_table_data,
        ]);
})->setName('home');
