<?php

namespace Admin\Controller;
use Think\Controller;
/**
 * 登录操作
 * @author 魏巍
 *
 */
class LoginController extends Controller {
	/**
	 * 登陆处理
	 */
	public function index(){
        if(session('?login_username')){
            $this->username=session('login_username');
        }else{
            $this->username='';
        }
        if(session('?login_password')){
            $this->password=session('login_password');
        }else{
            $this->password='';
        }
        if(session('?login_remember')){
            $this->remember=session('login_remember');
        }else{
            $this->remember=0;
        }
		$this->display();
	}
	/**
	 * 验证码生成
	 */
    public function verify(){
        $verify = new \Think\Verify();
        $verify->entry();
    }

}
