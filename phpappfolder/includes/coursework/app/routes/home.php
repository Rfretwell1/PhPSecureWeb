<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

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
            'page_title' => 'Coursework',
        ]);
})->setName('home');
