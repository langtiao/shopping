<?php
/**
 * Created by PhpStorm.
 * User: 尹超
 * Date: 2018/4/24
 * Time: 14:18
 */

namespace app\shopadmin\controller;


use app\shop\model\Address;
use think\Controller;
use think\Db;
use think\Request;

class Order extends Controller
{
    public function order_list(){
        $order_list=Db::table("order")->alias('o')->where('order_id',"GT",0)
                        ->join('goods g','o.goods_id=g.goods_id')
                        ->join('address r','o.address_id=r.address_id')
                        ->join('user u','o.user_id=u.user_id')
                        ->paginate(5);




        return $this->fetch('order_list',['order_list'=>$order_list]);
    }
    public function address_list(){
        $region=Db::table('region')->where(['parent_id'=>1])->select();
        $addres_list=Db::table('address')->where('address',"GT",0)->select();
        return $this->fetch('address_list',['addres_list'=>$addres_list,'region'=>$region]);
    }
    //地址状态修改
    public function address_status(){
        $id=Request::instance()->get('id');
        $model=Db::table('address')->where('address_id',$id)->value('status');
        if($model==0){
            Db::table('address')->where('address_id',$id)->setField('status',1);

        }else{
            Db::table('address')->where('address_id',$id)->setField('status',0);

        }
         return $this->success("修改成功",'order/address_list');
    }
    //添加地址
    public function address_add()
    {
        Request::instance()->filter('htmlspecialchars');
        $data=input();
        $sheng=$data['sheng'];
        $shi=$data['shi'];
        $xian=$data['xian'];
        if(!empty($data['sheng'])||!empty($data['shi']||!empty($data['xian']))){
            $region=Db::table('region')->where('region_id',['=',$sheng],['=',$shi],['=',$xian],'or')->column('region_name');
            unset($data['sheng']);
            unset($data['shi']);
            unset($data['xian']);
          ;
        }
        $data['city']=$region[0]."-".$region[1]."-".$region[2];
        if(empty($data['takename'])){
            $this->error("阿萨德");die;
        };
        $data['user_id']=1;
        $data['status']=0;
        $data['createtime']=Date("Y-m-d H:i:s",time());
        $data['updatetime']=Date("Y-m-d H:i:s",time());
//         print_r($data);die;
        $model=new Address();
        $data=$model->add($data);
        if($data){
            $this->success('添加成功');
        }
        return $this->fetch('address_list');
    }
    //地址修改
    public function address_set(){
        $region=Db::table('region')->where(['parent_id'=>1])->select();
        $id=input('get.id');
        $data=Db::table('address')->where('address_id',$id)->find();

        if(Request::instance()->post()){
            Request::instance()->filter('htmlspecialchars');
            $data=Request::instance()->param();
            $sheng=Request::instance()->param('sheng');
            $shi=Request::instance()->param('shi');
            $xian=Request::instance()->param('xian');
            unset($data['id']);
            $id=Request::instance()->param('id');
            $region=Db::table('region')->where('region_id',['=',$sheng],['=',$shi],['=',$xian],'or')->column('region_name');
            if(!empty($region)){
                $data['city']=$region[0]."-".$region[1]."-".$region[2];
            }
//             var_dump($region);die;

//            var_dump($data);die;
            unset($data['sheng']);
            unset($data['shi']);
            unset($data['xian']);
            $data['updatetime']=Date("Y-m-d H:i:s",time());
            $db=Db::table('address')->where('address_id',$id)->update($data);
            return $this->success("修改成功",'order/address_list');
//            var_dump($data);
        }
        return $this->fetch('address_set',['region'=>$region,'data'=>$data]);
    }
    public function address_del(){
        $id=Request::instance()->get('id');
        Db::table('address')->where('address_id',$id)->delete();
        return $this->success("删除成功",'order/address_list');
    }


}