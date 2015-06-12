<?php
namespace Admin\Controller;
use Think\Controller;

class ArticleController extends BaseController{
	/**
	 * [index 文章列表]
	 * @return [type]
	 */
	public function index(){
		$id=!empty($_REQUEST['column_id'])?I('column_id'):I('cid');
		$id = !empty($id) ? $id: I('id');
		$map = $this->_search_arc();
        $map['column_id']=$id;
        //排序
        $ordermap = $this->ordermap(I('sort'),I('order'));
        //获取数据
		$this->arclist=$arclist=$this->getlist(M('article'), $map, $ordermap);
		$this->display('arclist');
	}
	/**
	 * [recycle 回收站]
	 * @return [type]
	 */
	public function recycle(){
		$this->display('index');
	} 
	/**
	 * [status 修改状态]
	 * @return [type]
	 */
	public function status(){
		if(!$this->upstatus(I('id'),M('article'),I('type'))){
			$this->error('操作失败');
		}
		$this->redirect('index?cid='.I('cid'));
	}
	/**
	 * [Insert 添加文章]
	 */
	public function Insert(){
		$images = $this->uploadsEditor();	//上传图片
		$file=$this->UploadsFile();			//上传文件
		$data=$_POST;
		$data['create_time']=time();
		$data['image']=$images['image'];
		$data['column_id']=$data['cid'];
		$attr=$this->makeAttr($_POST['attr']);	//重置属性
		$data['content']=I('content',htmlspecialchars);
		$data=array_merge($data,$attr);
		$_post=$_POST['file']?$_POST['file']:'';

		$data['startTime']=!empty($data['startTime'])?strtotime($data['startTime']):0;
		$data['endTime']=!empty($data['endTime'])?strtotime($data['endTime']):0;
		$data['file']=!empty($file['file'])?$file['file']:$_post;

		foreach ($images as $k => $v) {
			$data[$k]=$v;
		}

		$data['image']=!empty($data['image'])?$data['image']:'';

		if(!M('article')->add($data)){p(M('article')->getlastsql());die;			
			$this->error('操作失败');
		}
		$this->redirect('index?cid='.I('cid'));	
	}

	/**
	 * [update 更新视图]
	 * @return [type]
	 */
	public function update(){
		$this->article=$article=M('article')->find(I('id'));
		if($article['image']){
			$this->images=$images=array_filter(explode(',',$article['image']));
		}
		$this->display();
	}
	
	/**
	 * [delete 更新处理函数]
	 * @return [type]
	 */
	public function updatehandler(){
		$images = $this->uploadsEditor();	//上传图片
		$file=$this->UploadsFile();			//上传文件
		$data=$_POST;
		$data['create_time']=time();
		$data['column_id']=$data['cid'];
		$attr=$this->makeAttr($_POST['attr']);	//重置属性
		$data['content']=I('content',htmlspecialchars);
		$data=array_merge($data,$attr);

		$data['startTime']=!empty($data['startTime'])?strtotime($data['startTime']):0;
		$data['endTime']=!empty($data['endTime'])?strtotime($data['endTime']):0;
		$data['file']=!empty($file['file'])?$file['file']:$_POST['file'];
		
		if(!empty($_POST['image'])){
			foreach ($_POST['image'] as $i => $e) {
				$image .= $e.',';
			}
		}

		if(!empty($images)){
			foreach ($images as $k => $v) {
				$data[$k]=$v;
			}
			if(!empty($images['image'])){
				$image .= $images['image'];
			}
		}
		
		$data['image']=substr($image,0,-1);
		if(!M('article')->save($data)){			
			$this->error('操作失败');
		}
		$this->redirect('index?cid='.I('cid'));	
	}

	/**
	 * [delete 删除操作]
	 * @return [type]
	 */
	public function delete(){
		if(!M('article')->delete(I('id'))){
			$this->error('操作失败');
		}
		$this->redirect('index?cid='.I('cid'));
	}
	/**
	 * [_search_arc 搜索]
	 * @return [type]
	 */
	protected function _search_arc(){

		$map=array();
		$username=I('k');
		$status=I('q');
		if($status>-1&&$status!=""){
			$map['status']=array('eq',$status);
		}
		
		$map['title']=array('like','%'.I('k').'%');
		$this->search=array(
			'k'=>$username,
			'q'=>$status
			);
		//p($map);die;
		return $map;
	}
}