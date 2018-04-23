<?php
namespace app\shopadmin\controller;

use think\Controller;
class Goods extends Controller
{
    public function goodslist()
    {
    	//echo "111";die;
        return $this->fetch('goods_list');
    }
    public function goodsadd()
    {
        return $this->fetch('goods_add');
    }
}