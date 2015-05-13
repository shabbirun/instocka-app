<?php
namespace library;

class MigException extends \Exception{
    /**
     * 
     * List messages
     * 
     * */
     private $messages = array(
         'customer'  => array(
             0 => '<strong>Install have failed, try to install again</strong>',
             1 => ''
         ),
         'admin'     => array()
     );
     
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    // representaci�n de cadena personalizada del objeto
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
    public function printMessage($nameClass,$index){
        return $this->messages[$nameClass][$index];
    }
    
    

    public function funci�nPersonalizada() {
        echo "Una funci�n personalizada para este tipo de excepci�n\n";
    }
}