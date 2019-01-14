<?php

class SessionWrapper
{
	public function __construct() { }

	public function __destruct() {
	}

	public static function set_session($p_session_key, $p_session_value_to_set)
	{
		$m_session_value_set_successfully = false;
		if (!empty($p_session_value_to_set))
		{
			$_SESSION[$p_session_key] = $p_session_value_to_set;
			if (strcmp($_SESSION[$p_session_key], $p_session_value_to_set) == 0)
			{
				$m_session_value_set_successfully = true;
			}
		}
		return $m_session_value_set_successfully;
	}

	public static function get_session($p_session_key)
	{
		$m_session_value = false;

		if (isset($_SESSION[$p_session_key]))
		{
			$m_session_value = $_SESSION[$p_session_key];
		}
		return $m_session_value;
	}

	public static function unset_session($p_session_key)
	{
		$m_unset_session = false;
		if (isset($_SESSION[$p_session_key]))
		{
			unset($_SESSION[$p_session_key]);
		}
		if (!isset($_SESSION[$p_session_key]))
		{
			$m_unset_session = true;
		}
		return $m_unset_session;
	}
}
