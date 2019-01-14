<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/login', function(Request $request, Response $response)
{
    return $this->view->render($response,
        'login.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => $_SERVER["SCRIPT_NAME"],
            'page_title' => 'Login',
            'home' => '/coursework',
            'register' => 'register',
            'login_submit' => 'login_submit',
        ]);
});
