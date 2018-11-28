<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post(
    '/peekmessages',
    function(Request $request, Response $response) use ($app)
    {
        $message_model = $this->get('message_model');
        $soap = $message_model->createSoapClient();
        $peeked_messages = $message_model->peekMessages($soap);

        return $this->view->render($response,
            'display_peeked_messages.html.twig',
            [
                'landing_page' => $_SERVER["SCRIPT_NAME"],
                'action' => 'index.php/displaypeekedmessages',
                'css_path' => CSS_PATH,
                'storage_text' => 'Peeked messages: ',
                'peeked_messages' => $peeked_messages,
            ]);
    });
