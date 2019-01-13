<?php
/**
 * Created by PhpStorm.
 * User: php-slim
 * Date: 13/01/19
 * Time: 17:19
 */

class AccountModel
{
    private $c_arr_storage_result;
    private $database_handle;
    private $sql_wrapper;
    private $sql_queries;

    /**
     * MessageModel constructor. - the __construct method is used to pass in parameters when you
     * first create an object - called 'defining constructor method'.
     * __construct is always called when creating new objects or they are invoked when
     * the initialization takes place. it is suitable for any of the initializations that
     * the object may need before it is used.
     * __construct method is the first method executed.
     */
    public function __construct()
    {
        $this->c_arr_storage_result = null;
        $this->database_handle = null;
        $this->sql_wrapper = null;
        $this->sql_queries = null;
    }

    /**
     * the destruct will be called as soon as there are no other references to a particular
     * object, or in any order during a shutdown sequence.
     * The destructor being called will happen even if the script execution is stopped.
     * Calling for a function to stop the script will prevent the remaining shutdown
     * routines from being executed.
     */
    public function __destruct() { }

    /**
     * @param $p_obj_db_handle - sets the underlying databases handle.
     * also, optionally environment handle if the environment has been changed.
     * Users can change the containers object's underlying database while the object
     * is alive. db will verify that the handles set conforms to the concrete container's
     * requirements to db.
     */
    public function set_database_handle($database_handle)
    {
        $this->database_handle = $database_handle;
    }

    /**
     * telling the mysql wrapper what the db information to use when its accessed.
     * @param $p_obj_wrapper_db - a wrapper is data that precedes or frames the main
     * data or a program that sets up another program so it can run successfully.
     */
    public function set_sql_wrapper($sql_wrapper)
    {
        $this->sql_wrapper = $sql_wrapper;
    }

    /**
     * @param $p_obj_sql_queries - sets the objects for the SQL queries.
     */
    public function set_sql_queries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    public function store_account_data($p_acct_name, $p_acct_password) {

        $this->sql_wrapper->set_database_handle( $this->database_handle);
        $this->sql_wrapper->set_sql_queries( $this->sql_queries);

        $store_result = $this->sql_wrapper->insert_account_details($p_acct_name, $p_acct_password);

        return $store_result;
    }

    public function check_if_user_exists($p_acct_name) {
        $m_store_result = false;

        $this->sql_wrapper->set_database_handle( $this->database_handle);
        $this->sql_wrapper->set_sql_queries( $this->sql_queries);

        $m_store_result = $this->sql_wrapper->check_if_user_exists($p_acct_name);
        //var_dump($m_store_result);

        if(sizeof($m_store_result) != 0) {
            $result = true;
        }
        else $result = false;

        return $result;
    }

}