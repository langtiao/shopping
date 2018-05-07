<?php
namespace app\shop\controller;

use think\Controller;
class Search extends Controller
{
    public function search()
    {
    	//echo "111";die;
        return $this->fetch('search');
    }
}