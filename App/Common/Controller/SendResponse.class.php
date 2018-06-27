<?php
/**
 * Copyright (c) 2013-2015, All rights reserved.
 * Author: 未知
 * Create: 2015/10/22 17:33
 */
namespace Common\Controller;

use Think\Controller\RestController;

class SendResponse extends RestController{
    public function send($data=null){
        $this->setContentType('application/json','utf-8');
        $this->response($data,'json');
    }
}