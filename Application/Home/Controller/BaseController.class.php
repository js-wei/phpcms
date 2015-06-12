<?php
namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller {
  	protected function _initialize(){
		header('Content-type:text/html;charset=utf-8;');
		set_time_limit(0); 
	}
	/**
	 * [_before_index 开始之前]
	 * @return [type] [description]
	 */
	public function _before_index(){
		
	}
	/**
	 * [index 开始方法]
	 * @return [type] [description]
	 */
	public function index(){
		$this->display();
	}
	/**
	 * [_after_index 开始之后]
	 * @return [type] [description]
	 */
	public function _after_index(){
		
	}

	/**
	* 获取数据列表
	* @param type $model模型名
	* @param type $map条件
	* @param type $order排序
	* @param type $field需要查询的字段，默认全部
	* @param type $pagination为每页显示的数量，默认为配置中的值
	* @return type返回结果数组
	*/
    protected function getlist($model = '', $map = '', $order = '', $field = '*', $pagination = '') {
        //import('ORG.Util.Page');
        $page = new \Think\Page();// 实例化上传类
        $count = $model->where($map)->count('*');
        $pagination = $pagination ? $pagination : C('PAGE_SIZE');
        //$page = new Page($count, $pagination);
        $page->setConfig('header', '');
        $page->setConfig('prev','上一页');
        $page->setConfig('next', '下一页');
        $show = $page->show();
        $this->assign('page', $show);
        $res = $model->where($map)->field($field)->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
        return $res;
    }

    /**
    * [delImage 删除图片]
    * @param  [string] $path 图片路径
    * @return [string] 删除结果
    */
    protected function delImage($path){
    	$path=!empty($path)?$path:I('path');
    	
    	if(!empty($path)){
    		$id=I('id','',intval);
            $index=I('index','',intval);
            $result=M('Article')->find($id);

            $image=array_filter(explode(',', $result['image']));
            unset($image[$index]); 
            $image=implode(',', $image);
         
    		$data=array('id'=>$id,'image'=>$image);
    		$result=M('Article')->save($data);

    		if(!unlink('./Uploads/ueditor/'.$path) || !$result){
    			if(!$result){
    				echo 1;
    			}else{
    				echo 2;
    			}
    		}else{
    			echo 0;
    		}
    	}
    }
    /**
     * [delFile 删除文件]
     * @return [int] [返回结果]
     */
    public function delFile($id=0){
        $id=$id?$id:I('id','',intval);
        $file=!empty($_POST['file'])?$_POST['file']:'';
       
        if(!unlink('./Uploads/file/'.$file)){  
            echo 0;
        }else{
            $data=array('id'=>$id,'file'=>'');
            $result=M('Article')->save($data);
            echo 1;
        }
    }
  	/**
  	* [_setDel 定时删除]
    * @param integer $time [间隔]
    * @param string  $model [模型]
    * @param string  $type [跨度]
  	*/
    protected function _setDel($time=10,$model='',$type='day'){	
        switch ($type) {
        	case 'day':
        		$after=time()- $time*24*60*60;
        		break;
        	case 'week':
        		$after=time()- $time*24*60*60*7;
        		break;
        	case 'hour':
        		$after=time()- $time*60*60;
        		break;
        	default:
        		$after=time()- $time*24*60*60;
        		break;
        }
        
        $name=!empty($model)?$model:$this->getActionName();
        $model=M($name);
        $where['create_time']=array('lt',$after);
        $result=$model->where($where)->delete(); 
        return $result;
    }
    /**
    * [_param 获取参数信息]
    * @param  string $param [参数]
    * @return [type]        [description]
    */
    protected function _param($param=''){
        if(empty($param)){
            foreach ($_REQUEST as $k => $v) {
                if($k!='_URL_'){
                    $param[$k]=$v;
                }
            }
        }
        return $param;
    }
}