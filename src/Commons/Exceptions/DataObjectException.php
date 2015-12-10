<?php 
namespace Commons\Exceptions;

class DataObjectException extends \Exception{
    
    protected $_errors;

    function __construct($errors){
        $this->_errors = $errors;
    }

    public function getErrors(){
        return $this->_errors;
    }
}
