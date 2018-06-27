<?php
/**
 * Copyright (c) 2013-2015, All rights reserved.
 * Author: 未知
 * Create: 2015/10/20 15:12
 */

namespace Common\Controller;

class ApiResponse {
    protected static $instance = null;
    public $ver     = "2.0";
    public $code    = 200;
    public $message = '';
    public $errors  = array();
    public $data    = array();

    public static function instance() {
        if(self::$instance == null) {
            $class_name = __CLASS__ ;
            self::$instance = new $class_name();
        }
        return self::$instance;
    }

    protected function __construct() {
        $this->code  = Error::ERR_OK;
        $this->message = Error::getMessage($this->code);
    }

    public function setCode($code , $message = null, $args = array()) {
        $this->code  = (int)$code;
        if($message)
            $this->message = $message;
        else
            $this->message = Error::getMessage($this->code , $args);
        return $this;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setErrors($errors) {
        if(!is_array($errors)) $errors = array();
        $this->errors = $errors;
        if($this->getCode() == Error::ERR_OK) {
            $this->setCode(Error::ERR_GENERAL);
        }
    }

    public function addError($error , $key = null) {
        if($key) {
            $tmp = $key;
            $key = $error;
            $error = $tmp;
        }
        if(!$key) $this->errors[] = $error;
        else  $this->errors[$key] = $error;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function clearCode() {
        $this->code  = Error::ERR_OK;
        $this->message = Error::getMessage($this->code);

        return $this;
    }

    public function getCode() {
        return $this->code;
    }

    public function setData($obj) {
        $this->data = $obj;
        return $this;
    }

    public function getData() {
        return $this->data;
    }

    public function encode($encode = 'json') {
        return json_encode($this);
    }
}
