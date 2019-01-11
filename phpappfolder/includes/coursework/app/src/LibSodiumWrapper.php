<?php
/**
 * Wrapper class for the PHP LibSodium library.  Takes the pain out of using the library.
 *
 * Encrypt/decrypt the given string
 * Encrypt/Decrypt the given string with base 64 encoding
 *
 * @author CF Ingrams <cfi@dmu.ac.uk>
 * @copyright De Montfort University
 *
 */

/**
 * Class LibSodiumWrapper - software library for encryption, decryption, signatures, password hashing.
 */
class LibSodiumWrapper
{
    private $key;

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
        $this->initialise_encryption();
    }

    /**
     * the destruct will be called as soon as there are no other references to a particular
     * object, or in any order during a shutdown sequence.
     * The destructor being called will happen even if the script execution is stopped.
     * Calling for a function to stop the script will prevent the remaining shutdown
     * routines from being executed.
     */
    public function __destruct()
    {
        sodium_memzero($this->key);
    }

    /**
     * For encrypting, when set to integer (8bit), typing a string will not work as the key is the incorrect size.
     *
     */
    private function initialise_encryption()
    {
        $this->key = 'The boy stood on the burning dek';

        if (mb_strlen($this->key, '8bit') !== SODIUM_CRYPTO_SECRETBOX_KEYBYTES) {
            throw new RangeException('Key is not the correct size (must be 32 bytes).');
        }
    }

    /**
     * @param $string_to_encrypt - string that has been inputted for the encryption.
     * @return array -
     * @throws Exception
     */
    public function encrypt($string_to_encrypt)
    {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

        $encryption_data = [];

        $encrypted_string = '';
        $encrypted_string = sodium_crypto_secretbox(
            $string_to_encrypt,
            $nonce,
            $this->key
        );

        $encryption_data['nonce'] = $nonce;
        $encryption_data['encrypted_string'] = $encrypted_string;

        sodium_memzero($string_to_encrypt);
        return $encryption_data;
    }

    public function decrypt($base64_wrapper, $string_to_decrypt)
    {
        $decrypted_string = '';
        $decoded = $base64_wrapper->decode_base64($string_to_decrypt);

        if ($decoded === false)
        {
            throw new Exception('Ooops, the encoding failed');
        }

        if (mb_strlen($decoded, '8bit') < (SODIUM_CRYPTO_SECRETBOX_NONCEBYTES + SODIUM_CRYPTO_SECRETBOX_MACBYTES))
        {
            throw new Exception('Oops, the message was truncated');
        }

        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');

        $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');

        $decrypted_string = sodium_crypto_secretbox_open(
            $ciphertext,
            $nonce,
            $this->key
        );

        if ($decrypted_string === false)
        {
            throw new Exception('the message was tampered with in transit');
        }

        sodium_memzero($ciphertext);

        return $decrypted_string;
    }
}
