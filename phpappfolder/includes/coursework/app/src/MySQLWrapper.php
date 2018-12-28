<?php

class MySQLWrapper
{
  private $c_obj_db_handle;
  private $c_obj_sql_queries;
  private $c_obj_stmt;
  private $c_arr_errors;

  public function __construct()
  {
    $this->c_obj_db_handle = null;
    $this->c_obj_sql_queries = null;
    $this->c_obj_stmt = null;
    $this->c_arr_errors = [];
  }

  public function __destruct() { }

  public function set_db_handle($p_obj_db_handle)
  {
    $this->c_obj_db_handle = $p_obj_db_handle;
  }

  public function set_sql_queries($p_obj_sql_queries)
  {
    $this->c_obj_sql_queries = $p_obj_sql_queries;
  }

  //OLD
  /*public function insert_message_details($p_message_content, $p_message_metadata) {
      $m_query_string = $this->c_obj_sql_queries->insert_message_details();
      $m_arr_query_parameters = [
          ':message_content' => $p_message_content,
          ':message_metadata' => $p_message_metadata,
      ];
      $this->safe_query($m_query_string, $m_arr_query_parameters);
  }*/

  public function check_if_user_exists($p_acct_name) {
      $m_query_string = $this->c_obj_sql_queries->check_if_user_exists();
      $m_arr_query_parameters = [
          ':acct_name' => $p_acct_name,
      ];
      $this->safe_query_2($m_query_string, $m_arr_query_parameters);
  }

    public function insert_message_details($p_msg_timestamp, $p_msg_switches, $p_msg_fan, $p_msg_temp, $p_msg_keypad) {
        $m_query_string = $this->c_obj_sql_queries->insert_message_details();
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

    public function insert_account_details($p_acct_name, $p_acct_password) {
        $m_query_string = $this->c_obj_sql_queries->insert_account_details();
        $m_arr_query_parameters = [
            ':acct_name' => $p_acct_name,
            ':acct_password' => $p_acct_password,
        ];
        $this->safe_query($m_query_string, $m_arr_query_parameters);
    }

    public function safe_query_2($p_query_string, $p_arr_params = null)
    {
        $this->c_arr_errors['db_error'] = false;
        $m_query_string = $p_query_string;
        $m_arr_query_parameters = $p_arr_params;

        try
        {
            $m_temp = array();

            $this->c_obj_stmt = $this->c_obj_db_handle->prepare($m_query_string);

            // bind the parameters
            if (sizeof($m_arr_query_parameters) > 0)
            {
                foreach ($m_arr_query_parameters as $m_param_key => $m_param_value)
                {
                    $m_temp[$m_param_key] = $m_param_value;
                    $this->c_obj_stmt->bindParam($m_param_key, $m_temp[$m_param_key], PDO::PARAM_STR);
                }
            }
            var_dump($this->c_obj_stmt->debugDumpParams());
            // execute the query
            $this->c_obj_stmt->execute();
            $m_execute_result = $this->c_obj_stmt->fetchAll();
            var_dump($m_execute_result);
            $this->c_arr_errors['execute-OK'] = $m_execute_result;
        }
        catch (PDOException $exception_object)
        {
            $m_error_message  = 'PDO Exception caught. ';
            $m_error_message .= 'Error with the database access.' . "\n";
            $m_error_message .= 'SQL query: ' . $m_query_string . "\n";
            $m_error_message .= 'Error: ' . var_dump($this->c_obj_stmt->errorInfo(), true) . "\n";
            // NB would usually output to file for sysadmin attention
            $this->c_arr_errors['db_error'] = true;
            $this->c_arr_errors['sql_error'] = $m_error_message;
        }
        return $this->c_arr_errors['db_error'];
    }

  public function safe_query($p_query_string, $p_arr_params = null)
  {
    $this->c_arr_errors['db_error'] = false;
    $m_query_string = $p_query_string;
    $m_arr_query_parameters = $p_arr_params;

    try
    {
      $m_temp = array();

      $this->c_obj_stmt = $this->c_obj_db_handle->prepare($m_query_string);

      // bind the parameters
      if (sizeof($m_arr_query_parameters) > 0)
      {
        foreach ($m_arr_query_parameters as $m_param_key => $m_param_value)
        {
          $m_temp[$m_param_key] = $m_param_value;
          $this->c_obj_stmt->bindParam($m_param_key, $m_temp[$m_param_key], PDO::PARAM_STR);
        }
      }
        var_dump($this->c_obj_stmt->debugDumpParams());
      // execute the query
      $m_execute_result = $this->c_obj_stmt->execute();
      var_dump($m_execute_result);
      $this->c_arr_errors['execute-OK'] = $m_execute_result;
    }
    catch (PDOException $exception_object)
    {
      $m_error_message  = 'PDO Exception caught. ';
      $m_error_message .= 'Error with the database access.' . "\n";
      $m_error_message .= 'SQL query: ' . $m_query_string . "\n";
      $m_error_message .= 'Error: ' . var_dump($this->c_obj_stmt->errorInfo(), true) . "\n";
      // NB would usually output to file for sysadmin attention
      $this->c_arr_errors['db_error'] = true;
      $this->c_arr_errors['sql_error'] = $m_error_message;
    }
    return $this->c_arr_errors['db_error'];
  }

  public function count_rows()
  {
    $m_num_rows = $this->c_obj_stmt->rowCount();
    return $m_num_rows;
  }

  public function safe_fetch_row()
  {
    $m_record_set = $this->c_obj_stmt->fetch(PDO::FETCH_NUM);
    return $m_record_set;
  }

  public function safe_fetch_array()
  {
    $m_arr_row = $this->c_obj_stmt->fetch(PDO::FETCH_ASSOC);
    $this->c_obj_stmt->closeCursor();
    return $m_arr_row;
  }

  public function last_inserted_ID()
  {
    $m_sql_query = 'SELECT LAST_INSERT_ID()';

    $this->safe_query($m_sql_query);
    $m_arr_last_inserted_id = $this->safe_fetch_array();
    $m_last_inserted_id = $m_arr_last_inserted_id['LAST_INSERT_ID()'];
    return $m_last_inserted_id;
  }
}
