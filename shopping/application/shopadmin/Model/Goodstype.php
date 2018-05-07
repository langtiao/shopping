<?php 
namespace app\shopadmin\model;

use think\Model;
use think\Db;
// use think\File;
// use think\Request;

class Goodstype extends Model{
	public $table = 'goods_type';
	//添加
	public function insert($data){
		$res = DB::table("$this->table")->insert($data);
		return $res;
	}
	//删除
	public function del($id){
		$res = DB::table("$this->table")->where("goods_type_id = $id")->delete();
		return $res;
	}
	//按条件查找
	public function upselect($id){
		$res = DB::table("$this->table")->where("goods_type_id = $id")->select();
		return $res;
	}
	//修改
	public function up($id,$data){
		$res = DB::table("$this->table")->where("goods_type_id = $id")->setField($data);
		return $res;
	}
	//查找全部
	public function select(){
		$res = DB::table("$this->table")->select();
		return $res;
	}
	// public function upload(){
	// 	$data=Request::instance()->param();
 //        $file = request()->file('image');
 //            if(isset($file)){
 //                $info = $file->move(ROOT_PATH . 'public/uploads');
 //                 if($info){
 //                     $a= $info->getSaveName();
 //                     $imgp= str_replace("\\","/",$a);
 //                 }
 //            }else{
 //            	return $imgp="";
 //            }
 //            return $imgp;
	// }
	// //无限递归分类
 //    public function category($category,$parent_id=0,$level=0){  
 //     $arr=array();  
 //     foreach($category as $k=>$v){  
 //         if($v['parent_id']==$parent_id){  
 //             $v['level']=$level;  
 //             $v['child']=$this->category($category,$v['cate_id'],$level+1);  
 //             $arr[]=$v;  
 //         }  
 //     }  
 //     return $arr;  
 // 	}  
}