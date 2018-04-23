<?php
namespace app\shop\controller;

use think\Controller;
class Pay extends Controller
{
    public function index()
    {
        //echo "111";die;
        return $this->fetch('pay');
    }

    public function shopcart(){
        return $this->fetch('shopcart');
    }
    
    public function success(){
        return $this->fetch('success');
    }
}