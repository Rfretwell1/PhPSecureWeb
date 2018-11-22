<?php

/**
 * MySQLWrapper.php
 *
 * Access the sessions database
 *
 * Author: CF Ingrams
 * Email: <clinton@cfing.co.uk>
 * Date: 22/10/2017
 *
 * @author CF Ingrams <clinton@cfing.co.uk>
 * @copyright CFI
 */

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

  public function store_session_var($p_session_key, $p_session_value)
  {

    if ($this->session_var_exists($p_session_key) === true)
    {
      $this->set_session_var($p_session_key, $p_session_value);
    }
    else
    {
      $this->create_session_var($p_session_key, $p_session_value);
    }

    return($this->c_arr_errors);
  }

  private function session_var_exists($p_session_key)
  {
    $session_var_exists = false;
    $m_query_string = $this->c_obj_sql_queries->check_session_var();

    $m_arr_query_parameters = [
      ':local_session_id' => session_id(),
      ':session_var_name' => $p_session_key
    ];

    $this->safe_query($m_query_string, $m_arr_query_parameters);

    if ($this->count_rows() > 0)
    {
      $session_var_exists = true;
    }
    return $session_var_exists;
  }

  private function create_session_var($p_session_key, $p_session_value)
  {
    $m_query_string = $this->c_obj_sql_queries->create_session_var();

    $m_arr_query_parameters = [
      ':local_session_id' => session_id(),
      ':session_var_name' => $p_session_key,
      ':session_var_value' => $p_session_value
    ];

    $this->safe_query($m_query_string, $m_arr_query_parameters);
  }

  private function set_session_var($p_session_key, $p_session_value)
  {
    $m_query_string = $this->c_obj_sql_queries->set_session_var();

    $m_arr_query_parameters = [
      ':local_session_id' => session_id(),
      ':session_var_name' => $p_session_key,
      ':session_var_value' => $p_session_value
    ];

    $this->safe_query($m_query_string, $m_arr_query_parameters);
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
      // execute the query
      $m_execute_result = $this->c_obj_stmt->execute();
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
