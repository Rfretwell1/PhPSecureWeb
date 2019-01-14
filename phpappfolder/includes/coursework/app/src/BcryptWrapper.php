<?php
/**
 * Wrapper class for the PHP BCrypt library.  Takes the pain out of using the library.
 *
 * @author CF Ingrams <cfi@dmu.ac.uk>
 * @copyright De Montfort University
 */

class BcryptWrapper
{
  public function __construct(){}

  public function __destruct(){}

    /**
     * @param $string_to_hash function to turn string into has for encrypted password
     * @return bool|string - if successful returns hashed password, otherwise fails.
     */
  public function create_hashed_password($string_to_hash)
  {
    $password_to_hash = $string_to_hash;
    $bcrypt_hashed_password = '';

    if (!empty($password_to_hash))
    {
      $arr_options = array('cost' => BCRYPT_COST);
      $bcrypt_hashed_password = password_hash($password_to_hash, BCRYPT_ALGO, $arr_options);
    }
    return $bcrypt_hashed_password;
  }


    /**
     * @param $string_to_check - string to check if the users password is stored and authenticated
     * @param $stored_user_password_hash
     * @return bool - true if authenticated, false if not.
     */
  public function authenticate_password($string_to_check, $stored_user_password_hash)
  {
    $user_authenticated = false;
    $current_user_password = $string_to_check;
    $stored_user_password_hash = $stored_user_password_hash;

    if (!empty($current_user_password) && !empty($stored_user_password_hash))
    {
      if (password_verify($current_user_password, $stored_user_password_hash))
      {
        $user_authenticated = true;
      }
    }
    return $user_authenticated;
  }
}
