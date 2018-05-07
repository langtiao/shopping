<?php
namespace app\shop\controller;

use Org\Util\Date;
use think\Controller;
use think\Db;
use think\Request;
use \app\shop\model\Address;

class Pay extends Controller
{
    //提交订单
    public function pay()
    {//->where('card_id',"in",[1])->select();
        $user=1;
        $region=Db::table('region')->where(['parent_id'=>1])->select();
        //获取登录id
        $address=Db::table('address')->where('user_id',"1")->select();
        $address_default=Db::table('address')->where(['user_id'=>"1","status"=>1])->find();

         //从sku的到商品id数据
        $shop_cat=Db::table('shop_card')
                      ->alias('g')
                   ->join('sku','g.skuid=sku.sku_id')
                   ->where('skuid','in',[1,12])
                  ->select();
        $goods_name=Db::table('goods')->where('goods_id','in',[1,2])->field('goods_name')->select();
        // var_dump($goods_name);die;
        $total_price=array();
        for ($i=0; $i < count($goods_name); $i++) {
           // array_push($shop_cat[$i],$goods_name[$i]['goods_name']);
            $shop_cat[$i]['goods_name'] = $goods_name[$i]['goods_name'];
            $total_price[]= $shop_cat[$i]['price']*$shop_cat[$i]['num'];
        }
         
        $order=array();
        for ($k=0;$k<count($shop_cat);$k++){
            echo $k;
            if($shop_cat[$k]['goods_name']){
                // var_dump($shop_cat[$k]['goods_name']);die;
                $order[$k]['goods_name']=$shop_cat[$k]['goods_name'];
                $order[$k]['goods_price']=$shop_cat[$k]['price'];
                $order[$k]['order_num']=\date("YmdHis",time()).$user.$k;
                $order[$k]['user_id']=$user;
                $order[$k]['order_createtime']=\date("Y-m-d H:i:s");
                $order[$k]['order_updatetime']=\date("Y-m-d H:i:s");
                $order[$k]['countprice']=$order[$k]['countprice']=$shop_cat[$k]['price']*$shop_cat[$k]['num'];
                $order[$k]['address_id']=$address_default['address_id'];
                $order[$k]['goods_id']=$shop_cat[$k]['goods_id'];
                  Db::table('order')->insert($order[$k]);


            }
        }

        $total_price=array_sum($total_price);
        return $this->fetch('pay',['region'=>$region,"address"=>$address,'shop_cat'=>$shop_cat,'total_price'=>$total_price,'default'=>$address_default]);
    }

     public function get_city(){
        $pid=Request::instance()->param('pid');

         $region=Db::table('region')->where(['parent_id'=>$pid])->select();
       return json_encode($region,true);
     }

    public function site_add()
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
        return $this->fetch('pay');
    }
    public function register(){
        return $this->fetch('shopcart');
    }
    //提交成功
    public function succed(){
        return $this->fetch('succed');
    }
      public function shopcart(){
        return $this->fetch('shopcart');
    }



    public function paygoods(){
        $param = input('post.');
        $sxm = array_pop($param);
        $b = implode('_',$sxm);
        //var_dump($b);die;
        $sku_id = DB::table('sku')->where(['goodsid'=>$param['goods_id']])->where(['sku'=>$b])->column('sku_id');
       // var_dump($sku_id);die;
        if(empty($sku_id))
        {
           $sku_id=array(0);
           exit(json_encode(['code'=>0,'sku_id'=>$sku_id[0]]));
        }
        else{
            $data = array(
                'goods_id'=>$param['goods_id'],
                'goodsprice'=>$param['goodsprice'],
                'marketprice'=>$param['marketprice'],
                'num'=>$param['num'],
                'skuid'=>$sku_id[0],
            );
        

            $res = DB::table('shop_card')->insert($data);
            $card_id = Db::table('shop_card')->getLastInsID();
            exit(json_encode(['code'=>1,'sku_id'=>$sku_id[0],'card_id'=>$card_id]));
        }



}
}