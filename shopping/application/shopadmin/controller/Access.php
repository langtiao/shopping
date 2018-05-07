<?php
namespace app\shopadmin\controller;

use think\Controller;
use think\Model;
class Access extends Controller
{
	static $new_data;
    public function accesslist()
    {
    	$model = model('access');
    	$data = $model->getAccessUrl();
    	$new_data = $this->getList($data,0,'');
    	//var_dump($new_data);die;

    	$this->assign('data',$new_data);

        return $this->fetch('access_list');
    }
    public function getList($data,$parent_id,$tmp)
    {
        foreach ($data as $k => $v) {
            if($data[$k]['parent_id']==$parent_id)
            {
                $data[$k]['tmp']=$tmp;
                self::$new_data[]=$data[$k];
                $this->getList($data,$data[$k]['a_id'],$tmp.'|--');
            }
        }
        return self::$new_data;
    }

}

