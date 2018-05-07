<?php
namespace app\shopadmin\controller;

use think\Controller;
class Goodstype extends Controller
{
    public function goods_typelist()
    {
    	$user = model("Goodstype");
    	$data = $user->select();
    	$this->assign('data',$data);
        return $this->fetch('goods_type_list');

    }
    //添加页面
    public function goods_typeadd(){

    	return $this->fetch('goods_type_add');

    }
    //执行添加
    public function add(){
    	$data = input("post.");
    	$user = model("Goodstype");
    	$res = $user->insert($data);
    	if($res){
    		$this->success("添加成功","goodstype/goods_typelist");
    	}
    }
    //执行删除
    public function del(){
    	$id = input('get.id');
    	$user = model("Goodstype");
    	$res = $user->del($id);
    	if($res){
    		$this->success("删除成功","goodstype/goods_typelist");
    	}
    }
    //修改页面
    public function goods_typeup(){
    	$id = input('get.id');
    	$user = model("Goodstype");
    	$data = $user->upselect($id);
    	$this->assign('data',$data);
    	return $this->fetch('goods_type_up');
    }
    //执行修改
    public function up(){
    	$data = input("post.");
    	$id   = $data['id'];
    	$user = model("Goodstype");
    	unset($data['id']);
    	$data = $user->up($id,$data);
    	if($data){
    		$this->success('修改成功','goodstype/goods_typelist'); 
    	}
    }

}