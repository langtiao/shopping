<?php
namespace app\shopadmin\controller;

use think\Controller;
use think\Db;
class Attr extends Controller
{
    public function attrlist()
    {
    	$model = model("Attrs");
    	$data  = $model->attr_goods_name();
    	$this->assign('data',$data);
        return $this->fetch('attrbute_list');
    }
    //添加页面
    public function attradd()
    {	
    	$model = model("Attrs");
    	$data  = $model->selecttype();
    	$this->assign('data',$data);
    	return $this->fetch('attrbute_add');
    }
    //执行添加
    public function add(){
    	$data = input("post.");
    	$model= model("Attrs");
    	$res  = $model->insert($data);
    	if($res){
    		$this->success('添加成功','attr/attrlist');
    	}
    }
    //执行删除
    public function del(){
    	$id = input('get.id');
    	$model= model("Attrs");
    	$res  = $model->del($id);
    	if($res){
    		$this->success("删除成功",'attr/attrlist');
    	}
    }
    //修改页面
    public function attrup(){
    	$id   = input('get.id');
    	$model= model("Attrs");
    	$data = $model->upselect($id);
    	$goods_type = $model->selecttype();
    	$this->assign('goods_type',$goods_type);
    	$this->assign('data',$data);
    	return $this->fetch("attrbute_up");
    }
    //执行修改
    public function up(){
    	$data = input("post.");
    	$id   = $data['id'];
    	$user = model("Attrs");
    	unset($data['id']);
    	$data = $user->up($id,$data);
    	if($data){
    		$this->success('修改成功','attr/attrlist');
    	}
    }
}