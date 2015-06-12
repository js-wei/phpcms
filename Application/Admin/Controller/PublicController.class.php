<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 登录操作
 * @author 魏巍
 *
 */
class PublicController extends Controller {
	/**
	 * 登陆处理
	 */
	public function Login(){
		if(!IS_POST) 
			$this->error('页面不存在');
        if(!$this->check(I('verify','')))
            $this->error('验证码错误，请重试');

		$pwd = I('password','','MD5');
		$username=strtolower(I('username'));
		$admin=M("admin")->where(array('username'=>$username))->find();
        //账号验证
		if(empty($_POST['password']) || empty($_POST['username'])){
			$this->error("账号或者密码不能为空");
		}
		if(!$admin||$admin['password']!=$pwd){
			$this->error("账号或者密码错误，请重试");
		}
		if($admin['status']==1){
			$this->error("账号已锁定");
		}
        //记住账号
        if(I('remember','',intval)==1){
            session(array('name'=>'login_username','expire'=>3600*24,'domain'=>C('DOMAIN')));
            session('login_username',$admin['username']);
            session('login_password',I('password'));
            session('login_remember',1);
        }else{
            session('login_username',null);
            session('login_password',null);
            session('login_remember',null);
        }
        //更新登录信息
		$data=array(
				'id'=>$admin['id'],
				'last_date'=>time(),
				'last_ip'=>get_client_ip()
				);
		M("admin")->save($data);
		//保存登录状态
		Session(C('SESSION_PREFIX').'_id',$admin['id']);
		Session(C('SESSION_PREFIX').'_name',ucfirst($admin['username']));
		Session(C('SESSION_PREFIX').'_time',time('Y-m-d h:i',$admin['logintime']));
		Session(C('SESSION_PREFIX').'_ip',$admin['loginip']);
        Session('login',$admin);
        //跳转目标页
		$this->redirect('Index/index');
	}

    /* 退出登录 */
    public function logout(){
    	Session(C('SESSION_PREFIX').'_id',null);
    	Session(C('SESSION_PREFIX').'_name',null);
    	Session(C('SESSION_PREFIX').'_time',null);
    	Session(C('SESSION_PREFIX').'_ip',null);
        Session('login',null);
    	//session('[destroy]');
    	$this->success('退出成功！', U('Login/index')); 
    }

    /**
     * 验证码检查
     */
    function check($code, $id =""){
        $verify = new \Think\Verify();
        return $verify->check($code,$id);
    }

}
