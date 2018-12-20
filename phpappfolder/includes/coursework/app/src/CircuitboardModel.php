<?php
/**
 * Created by PhpStorm.
 * User: php-slim
 * Date: 20/12/18
 * Time: 12:51
 */

class CircuitboardModel
{
    private $switches;
    private $fan;
    private $temperature;
    private $keypad;

    public function __construct()
    {
        $this->switches = null;
        $this->fan = null;
        $this->temperature = null;
        $this->keypad = null;
    }

    public function set_circuitboard_state($p_switches, $p_fan, $p_temperature, $p_keypad) {
        $this->switches = $p_switches;
        $this->fan = $p_fan;
        $this->temperature = $p_temperature;
        $this->keypad = $p_keypad;
    }

    public function create_circuitboard_message() {
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
        $f_encodedMessage .= "\"keypad\":\"$f_keypad\"}";

        //TODO - simulate circuit board

        var_dump($f_encodedMessage);

        $stripSlashed = stripslashes($f_encodedMessage);
        var_dump($stripSlashed);

        return $stripSlashed;
    }

}