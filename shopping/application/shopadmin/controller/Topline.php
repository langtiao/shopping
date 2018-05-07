<?php
namespace app\shopadmin\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Model;

class Topline extends Controller
{
    public function toplineadd(){
        $toplinetype = DB::table('toplinetype')->select();
        $this->assign('toplinetype',$toplinetype);
        return $this->fetch('toplineadd');
    }
    public function toptype()
    {
        //var_dump($access_url);die;
        $type = Db::table('toplinetype')->select();
        $this->assign('type',$type);
        return $this->fetch('toptype');

    }
    public function articlelist()
    {

    	// $data = Db::table('topline')->paginate(3);
        $keyword = input('get.keyword');
        $pageParam = ['query' =>[]];
        $pageParam['query']['keyword'] = $keyword;
        
        $data = DB::table('topline')->where('content','like',"%{$keyword}%")->paginate(3,false,$pageParam);
        $page = $data->render();
        $data = $data->toArray();
        
        foreach ($data['data'] as $key => $value) {
            // $start = stripos($data['data'][$key]['content'], "<p><img");
            // $end = stripos($data['data'][$key]['content'],"alt=");
            // $a = substr($data['data'][$key]['content'],$start,$end);
            // if ($a!=false) {
            //     //$a.="></p>";
            //     //$data['data'][$key]['img'] = $a;
            // }else{
            //     $data['data'][$key]['img'] = "";
            // }
            
            $data['data'][$key]['content']=substr($data['data'][$key]['content'],0,300);
        }
        $this->assign('page',$page);
    	$this->assign('data',$data);
    	//var_dump($data);die;
        return $this->fetch('articlelist');
    }

    //删除
    public function dellist(){
        $id = input('get.id');
        $res = DB::table('topline')->delete($id);
        if ($res) {
            $this->success('删除成功','shopadmin/topline/articlelist');
        }
    }
    //查看
    public function showlist(){
        $id = input('get.id');
        $data = DB::table('topline')->where(['id'=>$id])->find();
        $this->assign('data',$data);
        return $this->fetch('showlist');
    }
    //修改
    public function savelist(){
        if (Request::instance()->isPost()){
            $id = input('post.topid');
            //echo $id;die;
            $title = input('post.title');
            $content = input('post.content');
            $start = stripos($content, "/ueditor");

            $end = strpos($content,".png");

            $a = substr($content,$start,$end-$start+4);
            if ($start!==false && $end!==false) {
                $img = $a;
            }else{
                $img = "";
            }
            $res = Db::table('topline')->where(['id'=>$id])->update([
                    'title'=>$title,
                    'content'=>$content,
                    'img'=>$img,
                ]);
            if ($res) {
                $this->success('修改成功','shopadmin/topline/articlelist');
            }
        }else{
            $id = input('get.id');
            $data = DB::table('topline')->where(['id'=>$id])->find();
            $this->assign('data',$data);
            return $this->fetch('savelist');
        } 
        
    }


    // public function searchlist(){
    //     $keyword = input('get.keyword');
    //     $pageParam = ['query' =>[]];
    //     $pageParam['query']['keyword'] = $keyword;
        
    //     $list = DB::table('topline')->where('content','like',"%{$keyword}%")->paginate(3,false,$pageParam);
    //     //var_dump($list);die;
    //     $this->assign('list',$list);
    //     return $this->fetch('list');
    // }
    //添加头条
    public function testeditor(){
        $cont = $_POST;
        $start = stripos($cont['content'], "/ueditor");
        $end = strpos($cont['content'],".png");
        $a = substr($cont['content'],$start,$end-$start+4);
        if ($start!==false && $end!==false) {
            $cont['img'] = $a;
        }else{
            $cont['img'] = "";
        }
        //var_dump($cont);die;
        
        $res = Db::table('topline')->insert($cont);
        if ($res) {
                $this->success('添加成功','shopadmin/topline/articlelist');
            }
        //var_dump($cont);die;
    }
}