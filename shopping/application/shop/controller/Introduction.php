<?php
namespace app\shop\controller;

use think\Controller;
class Introduction extends Controller
{
    public function index()
    {
    	//echo "111";die;
        return $this->fetch('introduction');
    }
}