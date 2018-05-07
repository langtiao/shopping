<?php 
namespace app\shopadmin\model;

use think\Model;
use think\Db;
// use think\File;
// use think\Request;

class Attrs extends Model{
	public $table = 'attr';
	//添加
	public function insert($data){
		$res = DB::table("$this->table")->insert($data);
		return $res;
	}
	//删除
	public function del($id){
		$res = DB::table("$this->table")->where("attr_id = $id")->delete();
		return $res;
	}
	//按条件查找
	public function upselect($id){
		$res = DB::table("$this->table")->where("attr_id = $id")->select();
		return $res;
	}
	//修改
	public function up($id,$data){
		$res = DB::table("$this->table")->where("attr_id = $id")->setField($data);
		return $res;
	}
	//查找全部
	public function select(){
		$res = DB::table("$this->table")->select();
		return $res;
	}
	//查找商品类型表数据
	public function selecttype(){
		$res = DB::table("goods_type")->select();
		return $res;
	}
	public function attr_goods_name(){
		$data = Db::table("$this->table")
                 ->alias('a')
                 ->join('goods_type b', 'a.goods_type_id =b.goods_type_id')
                 ->where("a.goods_type_id = b.goods_type_id")
                 ->select();
   		return $data;
	}
}