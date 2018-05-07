<?php
namespace app\shop\model;

use think\Model;
use think\Request;

class Region extends Model
{
	protected $table = "region";
    public function index()
    {
    	//echo "111";die;
    	
        return $this->fetch('introduction');
    }
}