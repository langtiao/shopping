<?php
namespace app\shopadmin\controller;

use think\Controller;
class Goodstype extends Controller
{
    public function goods_typelist()
    {
        return $this->fetch('goods_type_list');
    }
}