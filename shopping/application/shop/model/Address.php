<?php 
namespace app\shop\model;
use think\Db;
use think\Model;


// class Address extends Model
// {
	


// }


class Address extends Model
{
    protected $table="address";
    //添加
    public function add($data){
       $model=Db::table($this->table)->insert($data);
       return $model;
    }

}
 ?>