<?php

class MySQLWrapper
{
    private $database_handle;
    private $sql_queries;
    private $sql_statement;
    private $errors_array;

    public function __construct()
    {
    $this->database_handle = null;
    $this->sql_queries = null;
    $this->sql_statement = null;
    $this->errors_array = [];
    }

    public function __destruct() { }

    /**Sets the database handle for the class, containing the settings required to connect to the database
     * @param $database_handle - the database handle to set */
    public function set_database_handle($database_handle)
    {
        $this->database_handle = $database_handle;
    }

    /**Sets the SQLQueries file for the class
     * @param $sql_queries - the SQLQueries file to set */
    public function set_sql_queries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    /**Retrieves the account data for a given username from the database
     * @param $username - The username to retrieve the account data for
     * @return bool|array - 'false' if the account doesn't exist, else returns an array containing the account username & password from the accounts database
     */
    public function select_account_data($username) {
      $query_string = $this->sql_queries->select_account_data();
      $query_parameters = [
          ':acct_name' => $username,
      ];

      $result = $this->safe_query($query_string, $query_parameters);
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
