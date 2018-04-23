<?php
namespace app\shop\controller;

use think\Controller;
class Home extends Controller
{
    public function index()
    {
    	//echo "111";die;
        return $this->fetch('index');
    }
}