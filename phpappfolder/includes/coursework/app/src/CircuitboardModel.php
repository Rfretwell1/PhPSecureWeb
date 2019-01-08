<?php
/**
 * Created by PhpStorm.
 * User: php-slim
 * Date: 20/12/18
 * Time: 12:51
 */

/**
 * Class CircuitboardModel
 */
class CircuitboardModel
{
    private $switches;
    private $fan;
    private $temperature;
    private $keypad;

    /**
     * CircuitboardModel constructor.
     * a construct is always called for when creating new objects, or invoked when the initialization takes place.
     * A consturct for the circuit board shows here that all the initial settings are set to null. (default state)
     */
    public function __construct()
    {
        $this->switches = null;
        $this->fan = null;
        $this->temperature = null;
        $this->keypad = null;
    }

    /**
     * @param $p_switches - boolen array which is 4 long, so it will be either; true, true, true, true or
     * true, true, false, false.
     * @param $p_fan - string which will either be fwd for forward or rev for reverse.
     * @param $p_temperature - integer ranging between 0 and 150 to set the temprature.
     * @param $p_keypad - string for the keypad with all the letters and numbers on it.
     */
    public function set_circuitboard_state($p_switches, $p_fan, $p_temperature, $p_keypad) {
        $this->switches = $p_switches;
        $this->fan = $p_fan;
        $this->temperature = $p_temperature;
        $this->keypad = $p_keypad;
    }

<<<<<<< HEAD
    public function create_circuitboard_message_json() {
=======
    /**
     * @return string which will return the JSON formatted string for the message
     * showing the current state of the circut board.
     * encoded message for switch will display whether it is on or off.
     * encoded mssage for fan, temp, keypad will display the variables set from the objects.
     */
    public function create_circuitboard_message() {
>>>>>>> 353a71e80174f902a8c74b36a09302a9feaf4d37
        $f_switches       = $this->switches;
        $f_fan            = $this->fan;
        $f_temperature    = $this->temperature;
        $f_keypad         = $this->keypad;
        $f_encodedMessage = '{"id":"18-3110-AJ",';

        $i = 1;
        foreach($f_switches as $switch) {
            if($switch == true) {
                $f_encodedMessage .= "\"s$i\":\"on\",";
            }
            else {
                $f_encodedMessage .= "\"s$i\":\"off\",";
            }

            $i++;
        }

        $f_encodedMessage .= "\"fan\":\"$f_fan\",";
        $f_encodedMessage .= "\"temp\":\"$f_temperature\",";
<<<<<<< HEAD
        $f_encodedMessage .= "\"keypad\":\"$f_keypad\"";
=======
        $f_encodedMessage .= "\"keypad\":\"$f_keypad\"}";
>>>>>>> 353a71e80174f902a8c74b36a09302a9feaf4d37

        var_dump($f_encodedMessage);

        $stripSlashed = stripslashes($f_encodedMessage);
        var_dump($stripSlashed);

        return $stripSlashed;
    }

    public function create_circuitboard_message() {
        $f_switches       = $this->switches;
        $f_fan            = $this->fan;
        $f_temperature    = $this->temperature;
        $f_keypad         = $this->keypad;
        $f_encodedMessage = '<id>18-3110-AJ</id>';

        $i = 1;
        foreach($f_switches as $switch) {
            if($switch == true) {
                $f_encodedMessage .= "<s$i>on</s$i>";
            }
            else {
                $f_encodedMessage .= "<s$i>off</s$i>";
            }

            $i++;
        }

        $f_encodedMessage .= "<fan>$f_fan</fan>";
        $f_encodedMessage .= "<temp>$f_temperature</temp>";
        $f_encodedMessage .= "<kp>$f_keypad</kp>";

        return $f_encodedMessage;
    }

}