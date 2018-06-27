<?php
namespace Mobile\Controller;

use Think\Controller;

class TestController extends Controller{

    public function index(){
        session(null);
        cookie(null);
        echo "<h1>缓存清理完成</h1>";
        var_dump($_COOKIE);
        var_dump($_SESSION);
    }
}
