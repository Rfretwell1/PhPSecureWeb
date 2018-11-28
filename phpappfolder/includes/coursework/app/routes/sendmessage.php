<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post(
    '/sendmessage',
    function(Request $request, Response $response) use ($app)
    {
        $arr_tainted_params = $request->getParsedBody();
        $validator = $this->get('message_validator');
        $tainted_number = $arr_tainted_params['number'];
        $tainted_message = $arr_tainted_params['message'];
        $sanitised_number = $validator->validate_integer($tainted_number);
        $sanitised_message = $validator->sanitise_string($tainted_message);

        $message_model = $this->get('message_model');
        $soap = $message_model->createSoapClient();

        $message_model->sendMessage($soap, $tainted_number, $sanitised_message);


        return $this->view->render($response,
            'display_sent_message.html.twig',
            [
                'landing_page' => $_SERVER["SCRIPT_NAME"],
                'action' => 'index.php/displaysentmessage',
                'css_path' => CSS_PATH,
                'storage_text' => 'You sent a message: ',
                'number' => $tainted_number,
                'message' => $sanitised_message,
            ]);

    });
