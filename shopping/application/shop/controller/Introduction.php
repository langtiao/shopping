<?php
namespace app\shop\controller;

use think\Controller;
use think\Model;
use think\Request;
use think\Db;

class Introduction extends Controller
{
    public function index()
    {
    	//echo "111";die;
    	//$model = model('Region');
    	$data = DB::table('region')->where(['parent_id'=>1])->select();


        $goodsinfo = Db::table('goods')->alias('a')
            ->join('sku b', 'a.goods_id = b.goodsid')
            ->select();

        $attr = Db::table('attr')->select(); //查询属性
        $temp = [];
        foreach ($attr as $v){
            $attr_value = DB::table('attr_value')->where(['attrid'=>$v['attr_id']])->select(); //属性值
            $temp[$v['attr_id']] = array('attr_name'=>$v['attr_name'],'attr_value'=>$attr_value);
        }
        //var_dump($temp);die;
        $this->assign('data',$data);        
        $this->assign('temp',$temp);        
    	$this->assign('goodsinfo',$goodsinfo);    	
    	// 
        return $this->fetch('introduction');
    }
    public function changecity()
    {
    	$id = $_GET['id'];
    	//$model = model('Region');
    	$data = DB::table('region')->where(['parent_id'=>$id])->select();
    	exit(json_encode($data));
    }
}