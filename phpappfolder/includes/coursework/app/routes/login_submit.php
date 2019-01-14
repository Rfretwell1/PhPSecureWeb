<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post(
    '/login_submit',
    function(Request $request, Response $response) use ($app)
    {
        $validator          = $this->get('validator');
        $bcrypt_wrapper     = $this->get('bcrypt_wrapper');
        $database_handle    = $this->get('dbase');
        $mysql_wrapper      = $this->get('mysql_wrapper');
        $sql_queries        = $this->get('sql_queries');
        $session_wrapper    = $this->get('session_wrapper');
        $account_model      = $this->get('account_model');

        $arr_tainted_params = $request->getParsedBody();
        $tainted_username   = $arr_tainted_params['username'];
        $tainted_password   = $arr_tainted_params['password'];

        $cleaned_username   = $validator->sanitise_string($tainted_username);
        $cleaned_password   = $validator->sanitise_string($tainted_password);
        $hashed_password    = $bcrypt_wrapper->create_hashed_password($cleaned_password);

        $account_model->set_session_wrapper($session_wrapper);
        $account_model->set_database_handle($database_handle);
        $account_model->set_sql_wrapper($mysql_wrapper);
        $account_model->set_sql_queries($sql_queries);
        $account_model->store_data_in_session_file($cleaned_username, $hashed_password);

        $sid = session_id();

        $authenticated = false;
        $account_data = $account_model->get_account_data($cleaned_username);

        if($account_data !== false) {
            $password_from_database = $account_data[0]['acct_password'];
            $valid_password = $bcrypt_wrapper->authenticate_password($cleaned_password, $password_from_database);

            if($valid_password !== false) {
                $authenticated = true;
            }
        }

        if($authenticated) {
            return $this->view->render($response,
                'display_login_result.html.twig',
                [
                    'landing_page' => $_SERVER["SCRIPT_NAME"],
                    'username' => $cleaned_username,
                    'password' => $hashed_password,
                    'css_path' => CSS_PATH,
                    'sid' => $sid,
                ]
            );
        }
        else {
            $error_message = 'The supplied username/password combination is incorrect.';
            return $this->view->render($response,
                'login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => $_SERVER["SCRIPT_NAME"],
                    'page_title' => 'Login',
                    'home' => '/coursework',
                    'login' => '/login',
                    'register' => '/register',
                    'login_submit' => 'login_submit',
                    'login_message' => $error_message,
                ]
            );
        }
    }
);