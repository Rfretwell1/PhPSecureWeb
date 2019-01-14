<?php
/**
 * Created by PhpStorm.
 * User: php-slim
 * Date: 13/01/19
 * Time: 17:19
 */

/**
 * Class AccountModel
 * A class for handling all account related features of the application
 */
class AccountModel {
    private $database_handle;
    private $sql_wrapper;
    private $sql_queries;
    private $session_wrapper;

    public function __construct() {
        $this->database_handle = null;
        $this->sql_wrapper = null;
        $this->sql_queries = null;
        $this->session_wrapper = null;
    }

    public function __destruct() { }

    /**Sets the database handle for the class, containing the settings required to connect to the database
     * @param $database_handle - the database handle to set */
    public function set_database_handle($database_handle)
    {
        $this->database_handle = $database_handle;
    }

    /**Sets the SQLWrapper file for the class
     * @param $sql_wrapper - the SQLWrapper file to set */
    public function set_sql_wrapper($sql_wrapper)
    {
        $this->sql_wrapper = $sql_wrapper;
    }

    /**Sets the SQLQueries file for the class
     * @param $sql_queries - the SQLQueries file to set */
    public function set_sql_queries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    /**Sets the SessionWrapper file for the class
     * @param $session_wrapper - the SessionWrapper file to set */
    public function set_session_wrapper($session_wrapper)
    {
        $this->session_wrapper = $session_wrapper;
    }

    //TODO - COMMENT
    public function store_data_in_session_file($username, $password)
    {
        $m_store_result = false;
        $m_store_result_username = $this->session_wrapper->set_session('user_name', $username);
        $m_store_result_password = $this->session_wrapper->set_session('password', $password);

        if ($m_store_result_username !== false && $m_store_result_password !== false)	{
            $m_store_result = true;
        }
        return $m_store_result;
    }

    /**Stores a given username & password into the database
     * @param $username - The username to insert
     * @param $password - The password to insert
     * @return mixed - The result of the storage attempt
     */
    public function store_account_data($username, $password) {
        $this->sql_wrapper->set_database_handle( $this->database_handle);
        $this->sql_wrapper->set_sql_queries( $this->sql_queries);

        $storage_result = $this->sql_wrapper->insert_account_details($username, $password);

        return $storage_result;
    }

    /**Retrieves the account data for a given username from the database
     * @param $username - The username to retrieve the account data for
     * @return bool|array - 'false' if the account doesn't exist, else returns an array containing the account username & password from the accounts database
     */
    public function get_account_data($username) {
        $this->sql_wrapper->set_database_handle( $this->database_handle);
        $this->sql_wrapper->set_sql_queries( $this->sql_queries);

        $account_data = $this->sql_wrapper->select_account_data($username);
        if(sizeof($account_data) != 1) {
            $account_data = false;
        }

        return $account_data;
    }
}