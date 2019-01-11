<?php
/**
 * Wrapper class for the Base 64 encoding/decoding library
 *
 * Methods available are:
 *
 * Encode/Decode the given string with base 64 encoding
 *
 * @author CF Ingrams <cfi@dmu.ac.uk>
 * @copyright De Montfort University
 */

/**
 * Class Base64Wrapper - base64 is a group of similar binary-to-text encoding schemes that represent binary
 * data in an ASCII string format by translating it into a radix-64 representation.
 * Encoding is used for data being transferred and so it remains intact without any modification during transport.
 * Base64 encoding and decoding are commonly used when there is a need to encode
 * or decode data that needs to be stored and transferred.
 * The encoding is designed to make data survive transport through transport layers that are not 8-bit
 * clean for example.
 */
class Base64Wrapper
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
     * Encoding base64 is in order to transmit the data without loss or modification of the actual contents,
     * @param $string_to_encode - if the parameter is set to false
     * @return bool|string - returns encoded string if correct input, otherwise false.
     */
    public function encode_base64($string_to_encode)
    {
        $encoded_string = false;

        if (!empty($string_to_encode['encrypted_string']))
        {
            $nonce = $string_to_encode['nonce'];
            $encrypted_string = $string_to_encode['encrypted_string'];
            $encoded_string = base64_encode($nonce . $encrypted_string);
        }

        return $encoded_string;
    }

    /**
     * @param $string_to_decode - if the parameter is set to true, then the function will return false
     * if the input contains characters outside the base64 alphabet.
     * @return bool|string - will return true if correct input is inputted. Otherwise false.
     */
    public function decode_base64($string_to_decode)
    {
        $decoded_string = false;
        if (!empty($string_to_decode))
        {
            $decoded_string = base64_decode($string_to_decode);
        }
        return $decoded_string;
    }
}
