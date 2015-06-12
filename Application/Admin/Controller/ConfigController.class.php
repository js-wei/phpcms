<?php
namespace Admin\Controller;
/**
 * 栏目操作
 * @author 魏巍
 */
class ConfigController extends BaseController {
    /**
     * 列表页
     */
	public function index(){
		$this->display();
	}

    /**
     * 基本信息页面
     */
    public function basic(){
        $this->site=$config=M('config')->find(1);
        $this->display();
    }

    /**
     * 基本信息操作函数
     */
    public function addbasehandler(){
        if(!IS_POST)
            $this->error(L('fail'));
        $data=$this->_param();
        $data['id']=1;
        $data['date']=time();

        $config=M('config')->find(1);
        if($config){    //存在修改
            if(!M('config')->save($data)){
                $this->error(L('fail').'-->Error:'.M('config')->getDbError(),10);
            }
        }else{      //不存在添加
            if(!M('config')->add($data)){
                $this->error(L('fail').'-->Error:'.M('config')->getDbError(),'',10);
            }
        }
        $this->redirect('basic');
    }

    /**
     * 文档配置
     */
    public function article(){
        $this-> document=$document=C('admin_config');
        $this->display();
    }

    /**
     * 保存配置文件
     */
    public function addarticlehandler(){
        $document=C('admin_config');
        if(!IS_POST)
            $this->error(L('fail'));
        $data=$this->_param();
        $temp=array_merge($document,$data);
        $path=APP_PATH.'Common/Conf/';
        if(!is_writeable($path)){       //设为可写
            mkdir($path,0777);
        }
        if(!FN('admin',array('admin_config'=>$temp),$path)){        //写入文件
            $this->error(L('fail'));
        }
        $this->redirect('article');
    }

    /**
     * 用户基本设置
     */
    public function user(){
        $this-> user =$document=C('admin_config');
        $this->display();
    }

    public function adduserhandler(){
        $document=C('admin_config');
        if(!IS_POST)
            $this->error(L('fail'));
        $data=$this->_param();
        $temp=array_merge($document,$data);
        $path=APP_PATH.'Common/Conf/';
        if(!is_writeable($path)){       //设为可写
            mkdir($path,0777);
        }
        if(!FN('admin',array('admin_config'=>$temp),$path)){        //写入文件
            $this->error(L('fail'));
        }
        $this->redirect('user');
    }

    /**
     * 系统基本配置
     */
    public function system(){
        $this->system=$system=C('admin_config');
        $this->display();
    }

    /**
     * 系统基本配置
     */
    public function addsystemhandler(){
        $document=C('admin_config');
        if(!IS_POST)
            $this->error(L('fail'));
        $data=$this->_param();
        $temp=array_merge($document,$data);
        $path=APP_PATH.'Common/Conf/';
        if(!is_writeable($path)){       //设为可写
            mkdir($path,0777);
        }
        if(!FN('admin',array('admin_config'=>$temp),$path)){        //写入文件
            $this->error(L('fail'));
        }
        $this->redirect('system');
    }

}
