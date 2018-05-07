<?php
namespace app\shopadmin\controller;

use think\Controller;
use think\Db;
class Goods extends Controller
{
    public function goodslist()
    {
    	$res = DB::table('goods')->select();
    	$this->assign('data', $res);
        return $this->fetch('goods_list');
    }
    public function goodsadd()
    {   
        $model = model("goods");
        //商品类型查询
        $data  = $model->sel_goods_type();
        //商品分类查询
        $list  = $model->sel_cate();
        $list  = $model->category($list);
        //商品品牌查询
        $arr  = $model->sel_brand();
        $this->assign('arr',$arr);
        $this->assign('list',$list);
        $this->assign('data',$data);
        return $this->fetch('goods_add');
    }
    public function goodscomment(){
    	return $this->fetch('goodscomment');
    }
    public function ajaxsel(){
        $id = input("post.id");
        $model = model("goods");
        $data  = $model->selecttypeid($id);
        if($data){
           return json_encode(array('data'=>$data));
        }
    }
    public function adds(){
        $data = input('post.');
        $goods_img = $_FILES['goods_img'];
        $model = model("goods");  
        $file_img = $model->upload();
        $data['goods_img'] = $file_img;
        $res = $model->insert($data);
        if($res){
            $this->success("添加成功",'goods/goodslist');
        }
    }
    public function del(){
        $goods_id = input('get.id');
        $user = model("goods");  
        $res = $user->del($goods_id);
        if($res){
            $this->success("删除成功",'goods/goodslist');
        }
    }
}