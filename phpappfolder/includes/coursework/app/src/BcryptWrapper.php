<?php
/**
 * Wrapper class for the PHP BCrypt library.  Takes the pain out of using the library.
 *
 * @author CF Ingrams <cfi@dmu.ac.uk>
 * @copyright De Montfort University
 */

class BcryptWrapper
{
    /**
     * MessageModel constructor. - the __construct method is used to pass in parameters when you
     * first create an object - called 'defining constructor method'.
     * __construct is always called when creating new objects or they are invoked when
     * the initialization takes place. it is suitable for any of the initializations that
     * the object may need before it is used.
     * __construct method is the first method executed.
     */
  public function __construct(){}

    /**
     * the destruct will be called as soon as there are no other references to a particular
     * object, or in any order during a shutdown sequence.
     * The destructor being called will happen even if the script execution is stopped.
     * Calling for a function to stop the script will prevent the remaining shutdown
     * routines from being executed.
     */

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
