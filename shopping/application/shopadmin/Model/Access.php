<?php
namespace app\shopadmin\model;

use think\Model;
use think\Db;
use think\Request;

class Access extends Model
{
	protected $table = "access";
    public function getUserurlByAccessid($accessId)
    {
    	$model = new Access;
    	$access_url = $model->where('a_id','in',$accessId)->column('access_url');
    	return $access_url;
    	//echo "111";die;
    	
    }
    public function getAccessUrl(){
    	$model = new Access;
    	return $model->limit(0,10)->select();
    }
}