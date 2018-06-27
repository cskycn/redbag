<?php
/**
 * Copyright (c) 2013-2015, All rights reserved.
 * Author: 未知
 * Create: 2015/10/20 15:12
 */
namespace Common\Weixin;

use Think\Exception;

class  SDKRuntimeException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
?>