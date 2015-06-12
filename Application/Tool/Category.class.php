<?php
/**
 * 栏目处理类，提供常用的栏目无限级分类(unlimitForLevel、limitForLevel、unlimitedForLevel)
 * 获取父级栏目(getparents)
 * 获取子栏目(getChildrenById、getChildrens)
 */
namespace Tool;

class Category{
	/**
    * 返回一维栏目
    * @param $cate Array 栏目
    * @param $level  int 等级
    * @param $html string 分隔符
    * @param $margin int 空隙
    * @return Array 栏目
    */
	public static function unlimitForLevel($cate,$fid=0,$level=0,$html='|--',$margin=15){
		$arr=array();
		foreach ($cate as  $v) {
			if($v['fid']==$fid){
				$v['level']=$level+1;
				$v['html']=$html;
				$v['margin']=$level*$margin;
				$arr[]=$v;
				$arr=array_merge($arr,self::unlimitForLevel($cate,$v['id'],$level+1,$html,$margin));
			}
		}
		return $arr;
	}
	/**
	 * [LimitForLevel 获取无限极分类]
	 * @param [type]  $cate   [栏目]
	 * @param integer $fid    [父级id]
	 * @param integer $level  [无限级级别]
	 * @param string  $html   [description]
	 * @param integer $margin [description]
	 */
	public static function LimitForLevel($cate,$fid=0,$level=0,$html='--',$margin=15){
		$arr=array();
		foreach ($cate as  $v) {
			if($v['fid']==$fid){
				$v['level']=$level+1;
				$v['html']=str_repeat($html,$level);
				$arr[]=$v;
				$arr=array_merge($arr,self::unlimitForLevel($cate,$v['id'],$level+1,$html,$margin));
			}
		}
		return $arr;
	}
	/**
    * 返回多维栏目
    * @param $cate Array 栏目
    * @param $fid int 父亲id
    * @param $name string 分隔符
    * @return Array 栏目
    */
	public static function unLimitedForLevel($cate,$fid=0,$name='child'){
		$arr=array();
		foreach ($cate as  $v) {
			if($v['fid']==$fid){
				$v[$name]=self::unlimitedForLevel($cate,$v['id'],$name='child');
				$arr[]=$v;	
			}
		}

		return $arr;
	}
	/**
	 * [getparents 获取父级栏目]
	 * @param  [type] $cate   [栏目]
	 * @param  [type] $curent [当前栏目]
	 * @return [type]         [description]
	 */
	public static function getParents($cate,$curent){
		$arr=array();
		foreach ($cate as $v) {
			if($v['id']==$curent['fid']){
				$arr[]=$v;
				$arr=array_merge($arr,self::getparents($cate,$v));
			}
		}
	
		$arr=array_reverse($arr);
		return $arr;
	}
	/**
	 * [getchildrenid 获取子栏目]
	 * @param  [type] $cate [栏目]
	 * @param  [type] $fid  [父栏目id]
	 * @return [type]       [结果]
	 */
	public static function getChildrenById($cate,$id){
		$arr=array();
		foreach ($cate as $v) {
			if($v['fid']==$id){
				$arr[]=$v['id'];
				$arr=array_merge($arr,self::getChildrenById($cate,$v['id']));
			}
		}
		return $arr;
	}
	/**
	 * [getchildrens 获取子级栏目]
	 * @param  [type] $cate [栏目]
	 * @param  [type] $fid  [当前栏目id]
	 * @return [type]       [description]
	 */
	public static function getChildrens($cate,$id){
		$arr=array();
		foreach ($cate as $v) {
			if($v['fid']==$id){
				$arr[]=$v;
				$arr=array_merge($arr,self::getchildrens($v['id']));
			}
		}
		return $arr;
	}
}