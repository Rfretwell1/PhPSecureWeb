<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post(
    '/storeindatabase',
    function(Request $request, Response $response) use ($app)
    {
        $arr_tainted_params = $request->getParsedBody();

        $validator = $this->get('message_validator');

        $tainted_content = $arr_tainted_params['content'];
        $tainted_metadata = $arr_tainted_params['metadata'];

        $sanitised_content = $validator->sanitise_string($tainted_content);
        $sanitised_metadata = $validator->sanitise_string($tainted_metadata);


        $wrapper_mysql = $this->get('mysql_wrapper');
        $db_handle = $this->get('dbase');
        $sql_queries = $this->get('sql_queries');
        $message_model = $this->get('message_model');

        $message_model->set_message_values($sanitised_content, $sanitised_metadata);
        $message_model->set_wrapper_message_db($wrapper_mysql);
        $message_model->set_db_handle($db_handle);
        $message_model->set_sql_queries($sql_queries);
        $message_model->store_data();
        $store_result = $message_model->get_storage_result();
        var_dump($store_result);



        $arr_storage_result_message = '';
        return $this->view->render($response,
            'display_storage_result.html.twig',
            [
                'landing_page' => $_SERVER["SCRIPT_NAME"],
                'action' => 'index.php/displaymessagedetails',
                'css_path' => CSS_PATH,
                'storage_text' => 'The values stored were:',
                'content' => $sanitised_content,
                'metadata' => $sanitised_metadata,
                'storage_result_message' => $arr_storage_result_message,
            ]);

    });
