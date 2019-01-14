<?php

class MySQLWrapper
{
  private $database_handle;
  private $sql_queries;
  private $sql_statement;
  private $errors_array;

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
    $this->database_handle = null;
    $this->sql_queries = null;
    $this->sql_statement = null;
    $this->errors_array = [];
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
     * @param $p_obj_db_handle - selects object handler from the database.
     */
  public function set_database_handle($database_handle)
  {
    $this->database_handle = $database_handle;
  }

    /**
     * @param $p_obj_sql_queries - tells something where it can find the queries
     */
  public function set_sql_queries($sql_queries)
  {
    $this->sql_queries = $sql_queries;
  }

    /**
     * @param $p_acct_name - check if the users account name exists
     * @return array - if found, display account name, if not, fail.
     */
  public function select_account_data($p_acct_name) {
      $m_query_string = $this->sql_queries->select_account_data();
      $m_arr_query_parameters = [
          ':acct_name' => $p_acct_name,
      ];

      $result = $this->safe_query($m_query_string, $m_arr_query_parameters);
      return $result;
  }

    /**
     * binding parameters to the sql query , if those parameters are not there then the method wouldn't know what
     * values to use instead of placeholders and msg_timestamp would be inserted instead of the actual timestamp
     * @param $p_msg_timestamp - replacing :msg_timestamp in the query with the variable $p_msg_timestamp
     * @param $p_msg_switches - replacing :msg_switch1,2,3,4 in the query with the variable $p_msg_switches,1,2,3,4
     * @param $p_msg_fan - replacing :msg_fan in the query with the variable $p_msg_fan
     * @param $p_msg_temp - replacing :msg_temperature in the query with the variable $p_msg_temperature
     * @param $p_msg_keypad - replacing :msg_keypad in the query with the variable $p_msg_keypad
     */
    public function insert_message_details($p_msg_timestamp, $p_msg_switches, $p_msg_fan, $p_msg_temp, $p_msg_keypad) {
        $m_query_string = $this->sql_queries->insert_message_details();
        $m_arr_query_parameters = [
            ':msg_timestamp' => $p_msg_timestamp,
            ':msg_switch1' => $p_msg_switches[0],
            ':msg_switch2' => $p_msg_switches[1],
            ':msg_switch3' => $p_msg_switches[2],
            ':msg_switch4' => $p_msg_switches[3],
            ':msg_fan' => $p_msg_fan,
            ':msg_temperature' => $p_msg_temp,
            ':msg_keypad' => $p_msg_keypad,
        ];
        $this->safe_query($m_query_string, $m_arr_query_parameters);
    }

    /**
     * @param $p_acct_name - replacing :acct_name in the query with the variable $p_acct_name
     * @param $p_acct_password - replacing :acct_password in the query with the variable $p_acct_password
     */
    public function insert_account_details($p_acct_name, $p_acct_password) {
        $m_query_string = $this->sql_queries->insert_account_details();
        $m_arr_query_parameters = [
            ':acct_name' => $p_acct_name,
            ':acct_password' => $p_acct_password,
        ];
        $this->safe_query($m_query_string, $m_arr_query_parameters);
    }

    public function select_messages_table() {
        $m_query_string = $this->sql_queries->select_messages_table();
        $msgs_table_data = $this->safe_query($m_query_string);
        return $msgs_table_data;
    }

    /**
     * @param $query_string -
     * @param null $parameters_array
     * @return mixed
     */
  public function safe_query($query_string, $parameters_array = null)
  {
    $this->errors_array['db_error'] = false;
    $m_query_string = $query_string;
    $m_arr_query_parameters = $parameters_array;
    $fetched_results = false;

    try
    {
      $temp = array();

      $this->sql_statement = $this->database_handle->prepare($m_query_string);

      // bind the parameters
      //if (sizeof($m_arr_query_parameters) > 0)
        if(!empty($m_arr_query_parameters))
      {
        foreach ($m_arr_query_parameters as $m_param_key => $m_param_value)
        {
            $temp[$m_param_key] = $m_param_value;
          $this->sql_statement->bindParam($m_param_key, $temp[$m_param_key], PDO::PARAM_STR);
        }
      }

      // execute the query
      $execute_result = $this->sql_statement->execute();
      $fetched_results = $this->sql_statement->fetchAll();
      $this->errors_array['execute-OK'] = $execute_result;
    }
    catch (PDOException $exception_object)
    {
      $error_message  = 'PDO Exception caught. ';
      $error_message .= 'Error with the database access.' . "\n";
      $error_message .= 'SQL query: ' . $m_query_string . "\n";

      // NB would usually output to file for sysadmin attention
      $this->errors_array['db_error'] = true;
      $this->errors_array['sql_error'] = $error_message;
    }
      return $fetched_results;
  }

    /**
     * @return mixed - return the numeric value of elements in the array.
     */
  public function count_rows()
  {
    $m_num_rows = $this->sql_statement->rowCount();
    return $m_num_rows;
  }

    /**
     * @return mixed - fetches the numeric array.
     */
  public function safe_fetch_row()
  {
    $m_record_set = $this->sql_statement->fetch(PDO::FETCH_NUM);
    return $m_record_set;
  }

    /**
     * @return mixed - fetch using the associative array.
     */
  public function safe_fetch_array()
  {
    $m_arr_row = $this->sql_statement->fetch(PDO::FETCH_ASSOC);
    $this->sql_statement->closeCursor();
    return $m_arr_row;
  }

    /**
     * @return mixed - returns the last ID that was inserted.
     */
  public function last_inserted_ID()
  {
    $m_sql_query = 'SELECT LAST_INSERT_ID()';

    $this->safe_query($m_sql_query);
    $m_arr_last_inserted_id = $this->safe_fetch_array();
    $m_last_inserted_id = $m_arr_last_inserted_id['LAST_INSERT_ID()'];
    return $m_last_inserted_id;
  }

    public function get_errors() {
        return $this->errors_array;
    }

}

/**
 * @param $p_query_string
 * @param null $p_arr_params
 * @return array
 */
/*public function safe_query_2($p_query_string, $p_arr_params = null)
{
    $this->errors_array['db_error'] = false;
    $m_query_string = $p_query_string;
    $m_arr_query_parameters = $p_arr_params;

    var_dump($m_arr_query_parameters);

    try
    {
        $m_temp = array();

        $this->sql_statement = $this->database_handle->prepare($m_query_string);

        // bind the parameters
        if (sizeof($m_arr_query_parameters) > 0)
        {
            foreach ($m_arr_query_parameters as $m_param_key => $m_param_value)
            {
                $m_temp[$m_param_key] = $m_param_value;
                $this->sql_statement->bindParam($m_param_key, $m_temp[$m_param_key], PDO::PARAM_STR);
            }
        }
        var_dump($this->sql_statement->debugDumpParams());
        // execute the query
        $this->sql_statement->execute();
        $m_execute_result = $this->sql_statement->fetchAll();
        var_dump($m_execute_result);
        $this->errors_array['execute-OK'] = $m_execute_result;
        $result = $m_execute_result;
    }
    catch (PDOException $exception_object)
    {
        $m_error_message  = 'PDO Exception caught. ';
        $m_error_message .= 'Error with the database access.' . "\n";
        $m_error_message .= 'SQL query: ' . $m_query_string . "\n";
        $m_error_message .= 'Error: ' . var_dump($this->sql_statement->errorInfo(), true) . "\n";
        // NB would usually output to file for sysadmin attention
        $this->errors_array['db_error'] = true;
        $this->errors_array['sql_error'] = $m_error_message;
        $result=$this->errors_array;
    }
    //return $this->c_arr_errors['db_error'];

    return $result;
}*/
