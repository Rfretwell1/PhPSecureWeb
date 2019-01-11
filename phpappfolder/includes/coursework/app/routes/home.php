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
$app->get('/', function(Request $request, Response $response)
{
    return $this->view->render($response,
        'home.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => $_SERVER["SCRIPT_NAME"],
            'storeindatabase' => 'index.php/storeindatabase',
            'sendmessage' => 'index.php/sendmessage',
            'peekmessages' => 'index.php/peekmessages',
            'register' => 'index.php/register',
            'page_title' => 'Coursework',
        ]);
})->setName('home');
