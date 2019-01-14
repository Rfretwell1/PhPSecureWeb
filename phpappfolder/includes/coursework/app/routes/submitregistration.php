<?php

use Slim\Http\Request;
use Slim\Http\Response;

/**
 *
 */
$app->post(
    '/registrationsubmit',
    function(Request $request, Response $response) use ($app)
    {
        $validator          = $this->get('validator');
        $bcrypt_wrapper     = $this->get('bcrypt_wrapper');
        $database_handle    = $this->get('dbase');
        $mysql_wrapper      = $this->get('mysql_wrapper');
        $sql_queries        = $this->get('sql_queries');
        $account_model      = $this->get('account_model');
        $messages_model     = $this->get('messages_model');

        $messages_model->set_database_handle($database_handle);
        $messages_model->set_sql_wrapper($mysql_wrapper);
        $messages_model->set_sql_queries($sql_queries);

        $message_table_data = $messages_model->select_messages_table();

        $arr_tainted_params = $request->getParsedBody();
        $tainted_username   = $arr_tainted_params['username'];
        $tainted_password   = $arr_tainted_params['password'];

        $cleaned_username   = $validator->sanitise_string($tainted_username);
        $cleaned_password   = $validator->sanitise_string($tainted_password);
        $validated_username = $validator->validate_username($cleaned_username);
        $hashed_password    = $bcrypt_wrapper->create_hashed_password($cleaned_password);

        $account_model->set_database_handle($database_handle);
        $account_model->set_sql_wrapper($mysql_wrapper);
        $account_model->set_sql_queries($sql_queries);

        $does_user_exist = $account_model->get_account_data($cleaned_username);

        $error_message = '';
        if($does_user_exist) {
            $error_message .= 'A user with that name already exists.';
        }
        if($validated_username === false) {
            $error_message .= 'Username is invalid - field is either empty, or username is over 10 characters long.';
        }

        if(strlen($error_message) === 0) {
            $account_model->store_account_data($cleaned_username, $hashed_password);
            $registration_message = "You have created an account with the name '$validated_username'";

            return $this->view->render($response,
                'home.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => $_SERVER["SCRIPT_NAME"],
                    'sendmessage' => 'sendmessage',
                    'refresh_messages' =>'refresh_messages',
                    'register' => 'register',
                    'page_title' => 'Home',
                    'message_table_data' => $message_table_data,
                    'registration_message' => $registration_message,
                ]
            );
        }
        else {
            return $this->view->render($response,
                'register.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => $_SERVER["SCRIPT_NAME"],
                    'registrationsubmit' => 'registrationsubmit',
                    'page_title' => 'Register',
                    'error_message' => $error_message,
                ]
            );
        }
    }
);

/*$arr_tainted_params = $request->getParsedBody();
$tainted_username = $arr_tainted_params['username'];
$tainted_password = $arr_tainted_params['password'];

$validator = $this->get('validator');

$cleaned_username = $validator->sanitise_string($tainted_username);
$cleaned_password = $validator->sanitise_string($tainted_password);

$libsodium_wrapper = $this->get('libsodium_wrapper');
$bcrypt_wrapper = $this->get('bcrypt_wrapper');
$base64_wrapper = $this->get('base64_wrapper');


//$arr_encrypted = encrypt($libsodium_wrapper, $cleaned_password);
//$arr_hashed = hash_values($bcrypt_wrapper, $cleaned_password);
$hashed_password = $bcrypt_wrapper->create_hashed_password($cleaned_password);
// $arr_encoded = encode($base64_wrapper, $arr_encrypted);
//$arr_decrypted = decrypt($libsodium_wrapper, $base64_wrapper, $arr_encoded);

$message_model = $this->get('message_model');
//$message_model->set_session_values($cleaned_username, $cleaned_email, $cleaned_password);
//$message_model->set_wrapper_session_db($wrapper_mysql);
$wrapper_mysql = $this->get('mysql_wrapper');
$db_handle = $this->get('dbase');
$sql_queries = $this->get('sql_queries');

$message_model->set_wrapper_message_db($wrapper_mysql);
$message_model->set_db_handle($db_handle);
$message_model->set_sql_queries($sql_queries);
$doesUserExist = $message_model->check_if_user_exists($cleaned_username);*/



/*$store_result = $message_model->get_storage_result();
var_dump($store_result);

//$message_model->store_account_data($cleaned_username, $hashed_password);
$store_result = $message_model->get_storage_result();
var_dump($store_result);*/

/*$message_model = $this->get('message_model');

$message_model->set_wrapper_message_db($wrapper_mysql);
$message_model->set_db_handle($db_handle);
$message_model->set_sql_queries($sql_queries);
$message_model->store_data();
$store_result = $message_model->get_storage_result();
var_dump($store_result);*/