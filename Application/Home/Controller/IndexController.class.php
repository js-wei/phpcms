<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
   /**
    * 首页
    */
	public function index(){
		$this->display();
	}
}