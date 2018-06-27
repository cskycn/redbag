<?php
/**
 * Copyright (c) 2013-2015, All rights reserved.
 * Author: 未知
 * Create: 2015/10/20 15:49
 */

namespace Common\Controller;

class CApiResponse extends ApiResponse
{
    public static function instance()
    {
        if (self::$instance == null) {
            $class_name     = __CLASS__;
            self::$instance = new $class_name();
        }
        return self::$instance;
    }

    public function pack($data = null)
    {
        if (!$data) $data = $this;
        $sen = new SendResponse();
        $sen->send($data);

        return $data;
    }
}