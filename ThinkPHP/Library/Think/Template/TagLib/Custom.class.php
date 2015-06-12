<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Think\Template\TagLib;
use Think\Template\TagLib;
/**
 * Html标签库驱动
 */
class Custom extends TagLib{
    // 标签定义
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'list'      => array('attr'=>'model,where,limit,order,empty','close'=>1),
        'list1'     => array('attr'=>'model,where,limit,order,empty','close'=>1),
        'single'    => array('attr' => 'id,model,field,where,empty','close' =>1),
        'nav'       => array('attr' => 'position,where,order,empty','close' =>1),
        'location'  => array('attr' => 'model,field,current,where,empty','close' =>1),
        'article'   => array('attr' => 'id,field,where,empty','close' =>1),
        'banner'    => array('attr' => 'model,field,limit,where,width,height,auto,timespan,date,roll,order,','close' =>0),
        'banner2'   => array('attr' => 'model,field,limit,where,date,order,','close' =>1),
        'myad'=>array('attr' => 'model,field,limit,where,date,empty','close' =>1),
        'myflAd'=>array('attr' => 'model,field,id,where,date,width,height,empty','close' =>0),
        'mycoplAd'=>array('attr' => 'model,field,left,right,where,date,width,height,empty','close' =>0),
        'flink'=>array('attr' => 'model,field,limit,where,position,empty','close' =>1),
        'channel'=>array('attr' => 'model,id,field,limit,wher,emptye','close' =>1),  
        'channellist'=>array('attr' => 'model,fid,field,limit,where,order,empty','close' =>1),
        'randomrecom'=>array('attr' => 'model,fid,field,limit,where,order,empty','close' =>1),
        'tag'=>array('attr' => 'model,id,field,limit,where,order,date,empty','close' =>1),
        'tags'=>array('attr' => 'model,fid,field,limit,where,order,date,empty','close' =>1),
        'service'=>array('attr' => 'model,field,limit,where,date,custom,empty','close' =>0),
        'file'=>array('attr' => 'model,field,limit,where,date,order,empty','close' =>1),
        'site'=>array('attr' => 'model,field,limit,where,empty,empty','close' =>1),
        'page'=>array('attr' => 'model,field,limit,where,empty,empty','close' =>1),
        );
    /**
     * [_page description]
     * @param  [type] $tag     [description]
     * @param  [type] $content [description]
     * @return [type]          [description]
     */
    public  function _page($tag,$content){
        $model  = !empty($tag['model'])?$tag['model']:'article';
        $size   = !empty($tag['size'])?$tag['size']:C('PAGE_SIZE');
        $model  = !empty($tag['model'])?$tag['model']:'article';
        $model  = !empty($tag['model'])?$tag['model']:'article';
        $where  = $this->adjunct($tag);
        $limit  = $tag['limit'];
        $order  = $tag['order'];
          
        
    }
    
    /**
     * [_list 列表标签]
     * @param  [type]
     * @return [type]
     */
    public function _list($tag,$content) {    
        $model  = !empty($tag['model'])?$tag['model']:'article';
        $where  = $this->adjunct($tag);
        $limit  = $tag['limit'];
        $order  = $tag['order'];
        $id=!empty($tag['id'])?$tag['id']:I('id');
        $attr=!empty($attr['attr'])?$attr['attr']:'';

        if(!empty($id)){
            if(!empty($where)){
              if (strpos($where,'column_id')===false) { 
                 $where.=' and column_id = '.$id;
              }
            }else{
               $where.=' column_id = '.$id;
            } 
        }
        
        $str='<?php ';
        $str .= '$_list_news=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->limit('.$limit.')->order("'.$order.'")->select();';//查询语句 
        $str .='$_column=M("Column")->find("'.$id.'");';      
        $str .='$column=$_column;';
        $str .= 'foreach ($_list_news as $_list_value):';
        //$str .= 'extract($_list_value);';
        $str .= '$list=$_list_value;';
        $str .= '?>';//自定义文章生成路径$url
        $str .= $content;
        $str .='<?php endforeach ?>';
        return $str;
    }
     /**
     * [_list1 文章列表返回数组]
     * @param  [type] $attr    [description]
     * @param  [type] $content [description]
     * @return [type]          [description]
     */
    public function _list1 ($tag,$content){
      
      $model=!empty($tag['model'])?$tag['model']:'Article';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $limit=$attr['limit'];//参数$limit，可通过模板传入参数值
      $order=$attr['order'];//$order$limit，可通过模板传入参数值
      $where= $this->adjunct($tag);
      $id=!empty($tag['id'])?$tag['id']:I('id');
    
      if(empty($_REQUEST['id'])){ 
          if(!empty($id)){
            if(!empty($where)){
              $where.=' and column_id = '.$id;
            }else{
               $where.=' column_id = '.$id;
            }
          }
      }else{
          $_res=M($model)->find($id);
          $id=$_res['column_id'];
          if(!empty($where)){
            $where.=' and column_id='.$id;
          }else{
            $where.=' column_id='.$id;
          }
      }
      
      $str='<?php ';
      $str .= '$_list_news=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->limit('.$limit.')->order("'.$order.'")->select();';//查询语句 
      $str .='$_column=M("Column")->find("'.$id.'");';      
      $str .='$column=$_column;';
      //$str .= 'extract($_list_value);';
      $str .= '$list1=$_list_news;';
      $str .= '?>';//自定义文章生成路径$url
      $str .= $content;
      return $str;
    }
    /**
     * [_single 单个栏目]
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    public function _single($tag,$content){
    
      $model=!empty($tag['model'])?$tag['model']:'Article';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $date=!empty($tag['date'])?$tag['date']:'';
      $limit=$tag['limit'];//参数$limit，可通过模板传入参数值
      $order=$tag['order'];//$order$limit，可通过模板传入参数值
      $where= $this->adjunct($tag);
      $id=!empty($tag['id'])?$tag['id']:I('id');
    
      if (!empty($id)) {
        $where.=' and id = '.$id;
      }
     
      $str='<?php ';
      $str .= '$_list_news=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->find();';//查询语句 
      $str .='$_column=M("Column")->find("'.$id.'");';      
      $str .='$column=$_column;';
      //$str .= 'extract($_list_value);';
      $str .= '$single=$_list_news;';
      $str .= '?>';//自定义文章生成路径$url
      $str .= $content;
      return $str;

    }
    /**
     * [_nav 导航]
     * @param  [type] $tag    [description]
     * @param  [type] $content [description]
     * @return [type]          [description]
     */
    public function _nav ($tag,$content){
     
      $model=!empty($tag['model'])?$tag['model']:'Column';
      $field=!empty($tag['field'])?$tag['field']:'*';
     
      $limit=$tag['limit'];//参数$limit，可通过模板传入参数值
      $order=$tag['order'];//$order，可通过模板传入参数值
      $position=$tag['position'];
      $where= $this->condition($tag['where']);
      // $nav= \Classes\Category::unlimitedForLevel($_list_result);
     
      if(!empty($position)){
        if(empty($where))
            $where .=' position = '.$position;
        else
            $where .=' and position = '.$position;
      }

      //$_list_result=M($model)->field($field)->where($where)->limit($limit)->order($order)->select();
      
      $str='<?php ';
      $str .= '$_list_result=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->limit('.$limit.')->order("'.$order.'")->select();';//查询语句
      $str .= '$nav= \Classes\Category::unlimitedForLevel($_list_result);';
      $str .= '?>';  
      $str .= $content;
      return $str;

    }

    /**
    * [_location 面包屑导航]
    * @param  [type] $tag    [description]
    * @param  [type] $content [description]
    * @return [type]          [description]
    */
   public function _location($tag,$content){

      $model=!empty($attr['model'])?$attr['model']:'Column';
      $field=!empty($attr['field'])?$attr['field']:'*';
      $where= $this->adjunct($tag);
     
      if(!empty($_REQUEST['id']) || !empty($_REQUEST['cid'])){
          if(!empty($_REQUEST['id'])){
             $_article=M('Article')->find(I('id'));
             $current=!empty($attr["current"])?$attr["current"]:$_article['column_id'];
          }else{
             $current=!empty($attr["current"])?$attr["current"]:I('cid');
          }
      }else{
          $current=2;
      }
      if(empty($where))
          $where.='status=0';
        else
         $where.=' and status=0'; 
    
      $str='<?php ';
      $str .= '$_current_column=M("'.$model.'")->field("'.$field.'")->find("'.$current.'"); 
              $_result_content=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->select();
              $location=\Classes\Category::getparents($_result_content,$_current_column);
              $location[]=$_current_column;
              $temp=array(array("id" =>0,"title" => "首页",uri=>__GROUP__));
              $location=array_merge($temp,$location);
              $length=count($location)-1;
            ';
      $str .= '?>';
      $str .= $content;
      return $str;
   }

   /**
   * [_article 文章]
   * @param  [type] $tag    [description]
   * @param  [type] $content [description]
   * @return [type]          [description]
   */
  public function _article($tag,$content){
   
    $model=!empty($tag['model'])?$tag['model']:'Article';
    $field=!empty($tag['field'])?$tag['field']:'*';
    $key=!empty($tag['key'])?$tag['key']:'id';
    $id=!empty($tag['id'])?$tag['id']:I('id');
    
    $str='<?php ';
    $str .= '$_result_content=M("'.$model.'")->field("'.$field.'")->find("'.$id.'");';//查询语句
    $str .= '$_column=M("Column")->find($_result_content["column_id"]);';
    $str .= '$pre=M("'.$model.'")->where("'.$key.' < '.$id.' and column_id=".$_result_content["column_id"])->order("'.$key.' desc")->limit(1)->find();'; //上一条
    $str .= '$nxt=M("'.$model.'")->where("'.$key.' > '.$id.' and column_id=".$_result_content["column_id"])->order("'.$key.' asc")->limit(1)->find();'; //下一条
    $str .= '$_result_content["content"]=htmlspecialchars_decode($_result_content["content"]);$article=$_result_content;';
    $str .= '$column=$_column;';
    $str .= '?>';//自定义文章生成路径$url
    $str .= $content;
    return $str;
  }


  /***
    *Banner滚屏图片表
    CREATE TABLE IF NOT EXISTS `think_Banner` (
      `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
      `title` char(80) NOT NULL DEFAULT '' COMMENT '滚屏图片中文名称',
      `name` char(20) NOT NULL DEFAULT '' COMMENT '滚屏图片英文名称',
      `description` char(250) NOT NULL DEFAULT '' COMMENT '滚屏图片简单介绍',
      `image` char(250) NOT NULL DEFAULT '' COMMENT '滚屏图片图片',
      `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
      `effective` int(11) NOT NULL DEFAULT 0 COMMENT '滚屏图片有效时间,在有效时间内会显示',
      `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序：越小越靠前',
      `status` int(1) NOT NULL DEFAULT 0 COMMENT '状态：0正常，1禁用',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT 'Banner表'
   ***/
  /**
   * [_banner 图片滚屏]
   * @param  [type] $tag    [description]
   * @param  [type] $content [description]
   * @return [type]          [description]
   */
   public function _banner($tag,$content){
    
      $model=!empty($tag['model'])?$tag['model']:'Banner';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $limit=!empty($tag['limit'])?$tag['limit']:5;
      $width=!empty($tag['width'])?$tag['width']:1600;
      $height=!empty($tag['height'])?$tag['height']:'';
      $auto=!empty($tag['auto'])?$tag['auto']:1;
      $point=!empty($tag['point'])?$tag['point']:1;
      $timespan=!empty($tag['timespan'])?$tag['timespan']:1500;
      $where= $this->condition($tag['where']);
      $date=!empty($tag['date'])?$tag['date']:'';
      $roll=!empty($tag['roll'])?$tag['roll']:0;
      $speed=!empty($tag['speed'])?$tag['speed']:0;
      if(empty($where))
          $where.='status=0';
        else
         $where.=' and status=0';
   
      if(!empty($date)){
          $date=explode(' ', $date);
          if(count($date)>1){
            if(count($date)==2){
              $where.=' and create_time between '.strtotime($date[0]).' and '.strtotime($date[1]);
            }else{
              foreach ($date as $v) {
                $temp.= strtotime($v).',';
              }
              $temp=substr($temp, 1, -1);   //去掉最后一个字符
             
              $where.=' create_time IN ('.$temp.')';
            }
          }else{
            $where.=' and create_time = '.strtotime($date[0]);
          }
      }
      
      $_result=M($model)->field($field)->where($where)->limit($limit)->select();
      $html='';
      if(!empty($_result)){
        
          foreach ($_result as $v) {//p(__ROOT__.'/'.$v['image']);die;
              if(!empty($height)){ 

                $image .='<li><img src=\"__ROOT__/'.str_replace('./','', $v["image"]).'\" width=\"'.$width.'\" height=\"'.$height.'\" alt=\"'.$v["title"].'\"></li>';
              }else{
                $image .='<li><img src=\"__ROOT__/'.str_replace('./','', $v["image"]).'\" width=\"'.$width.'\"  alt=\"'.$v["title"].'\"></li>';
              }
              
          }
          if($roll) {
                  $html.='<style type=\"text/css\">
                    *{margin:0;padding:0;}
                    ul.banner-list-content{list-style:none;};
                    ul.banner-list-content>li{color:#666;}
                    ul.banner-list-content>li.active{color:orange;}
                  </style>'; 
                  $html.='<div class=\"banner-container\">
                    <div class=\"banner-image\">
                      <ul class=\"banner-image-content\">
                         '.$image.'
                      </ul>
                    </div>
                  </div>
                  <script src=\"__JS__/jquery.min.js\" text=\"text/javascript\" charset=\"uft-8\"></script>
                  <script src=\"__JS__/bannerBox.js\" text=\"text/javascript\" charset=\"uft-8\"></script>
                  <script type=\"text/javascript\">
                    $(function(){                  
                       $(\".banner-container\").BannerBox({auto:'.$auto.',point:'.$point.',speed:'.$speed.',timespan:'.$timespan.'});
                    });
                  </script>';
              }else{
                $html= '<ul class=\"banner-image-content\">'.$image.'</ul>';
                $html.='<style type=\"text/css\">
                        *{margin:0;padding:0;}
                        ul.banner-list-content{list-style:none;};
                      </style>';
              } 
      }else{
        $html='<b><i>抱歉您还未插入任何Banner图片</i></b>';
      }

      $str='<?php 
              echo "'.$html.'\n";
            ?>';
      $str .= $content;
      return $str;
   }
  /**
   * [_banner2 Banner无格式调用]
   * @param  [type] $tag    [description]
   * @param  [type] $content [description]
   * @return [type]          [description]
   */
  public function _banner2($tag,$content){

      $model=!empty($tag['model'])?$tag['model']:'Banner';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $where= $this->adjunct($tag);
      $limit=$tag['limit'];
      $order=$tag['order'];

      if(empty($where))
          $where.='status=0';
        else
         $where.=' and status=0'; 

      $str='<?php ';
      $str .= '$_list_banner2=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->limit('.$limit.')->order("'.$order.'")->select();';//查询语句 
      $str .= '$_i=0; foreach ($_list_banner2 as $_list_value):';
      //$str .= 'extract($_list_value);';
      $str .= '$banner2=$_list_value;';
      $str .= '$key=$_i;$_i++;';
      $str .= '?>';//自定义文章生成路径$url
      $str .= $content;
      $str .='<?php endforeach ?>';
      return $str;

    } 

   /***
    *Ad广告表
    CREATE TABLE IF NOT EXISTS `think_Ad` (
      `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
      `title` char(80) NOT NULL DEFAULT '' COMMENT '广告中文名称',
      `name` char(20) NOT NULL DEFAULT '' COMMENT '广告英文名称',
      `description` char(250) NOT NULL DEFAULT '' COMMENT '广告简单介绍',
      `image` char(250) NOT NULL DEFAULT '' COMMENT '广告图片',
      `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
      `effective` int(11) NOT NULL DEFAULT 0 COMMENT '广告有效时间,在有效时间内会显示',
      `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序：越小越靠前',
      `status` int(1) NOT NULL DEFAULT 0 COMMENT '状态：0正常，1禁用',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
   ***/
   /**
    * [_myad 广告图片]
    * @param  [type] $tag    [description]
    * @param  [type] $content [description]
    * @return [type]          [description]
    */
   public function _myad($tag,$content){
      
      $model=!empty($tag['model'])?$tag['model']:'Ad';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $empty=!empty($tag['empty'])?$tag['empty']:'';
      $where= $this->adjunct($tag);
      $limit=$tag['limit'];
      $order=$tag['order'];

      if(empty($where))
          $where.='status=0';
        else
          $where.=' and status=0'; 

      $str='<?php 
          $_result_content=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->order("'.$order.'")->limit("'.$limit.'")->select(); 
          $myad=count($_result_content)?$_result_content:"'.$empty.'";
      ?>';
      $str .= $content;
      return $str;
  }


  /**
   * [_mycoplAd 对联广告]
   * @param  [type] $tag    [description]
   * @param  [type] $content [description]
   * @return [type]          [description]
   */
  public function _mycoplAd($tag,$content){

      $model=!empty($tag['model'])?$tag['model']:'Ad';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $date=!empty($tag['date'])?$tag['date']:'';
      $width=!empty($tag['width'])?$tag['width']:0;
      $height=!empty($tag['height'])?$tag['height']:0;
      $where= $this->adjunct($tag);
      $left=!empty($tag['left'])?$tag['left']:0;
      $right=!empty($tag['right'])?$tag['right']:0;
      $order=$tag['order'];

      if(empty($where))
          $where.='status=0';
        else
          $where.=' and status=0'; 


      $_result_left=M($model)->field($field)->where($where)->order($order)->limit($limit)->find($left);
      $_result_right=M($model)->field($field)->where($where)->order($order)->limit($limit)->find($right);

      $html='<script src=\"__JS__/ad/ad.js\" text=\"text/javascript\" charset=\"uft-8\"></script>\n';
      if(!empty($_result_left) && !empty($_result_right)){
          if($width && $height){
              $lad='<a style=\"display:block;\" href=\"'.$_result_left['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_left['image'],1).'\" width=\"'.$width.'\" height=\"'.$height.'\" border=\"0\"></a>';
              $rad='<a style=\"display:block;\" href=\"'.$_result_right['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_right['image'],1).'\" width=\"'.$width.'\" height=\"'.$height.'\" border=\"0\"></a>';
               $html .='
                  <script type=\"text/javascript\">
                    var theFloaters  = new floaters();
                    theFloaters.addItem(\"followDiv1\",\"document.body.clientWidth-'.$width.'\",230,\"'.addslashes($rad).'\");
                    theFloaters.addItem(\"followDiv2\",20,230,\"'.addslashes($lad).'\");
                    theFloaters.play();
                  </script>
               '; 
          }elseif($width){
              $lad='<a style=\"display:block;\" href=\"'.$_result_left['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_left['image'],1).'\" width=\"'.$width.'\" border=\"0\"></a>';
              $rad='<a style=\"display:block;\" href=\"'.$_result_right['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_right['image'],1).'\" width=\"'.$width.'\"  border=\"0\"></a>';
               $html .='
                  <script type=\"text/javascript\">
                    var theFloaters  = new floaters();
                    theFloaters.addItem(\"followDiv1\",\"document.body.clientWidth-'.$width.'\",230,\"'.addslashes($rad).'\");
                    theFloaters.addItem(\"followDiv2\",20,230,\"'.addslashes($lad).'\");
                    theFloaters.play();
                  </script>
               ';
          }else{
              $lad='<a style=\"display:block;\" href=\"'.$_result_left['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_left['image'],1).'\" width=\"120\" height=\"150\" border=\"0\"></a>';
              $rad='<a style=\"display:block;\" href=\"'.$_result_right['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_right['image'],1).'\" width=\"120\" height=\"150\" border=\"0\"></a>';
               $html .='
                  <script type=\"text/javascript\">
                    var theFloaters  = new floaters();
                    theFloaters.addItem(\"followDiv1\",\"document.body.clientWidth-120\",230,\"'.addslashes($rad).'\");
                    theFloaters.addItem(\"followDiv2\",20,230,\"'.addslashes($lad).'\");
                    theFloaters.play();
                  </script>
               ';
          }
          
      }elseif(!empty($_result_left)){
          if($width && $height){
              $lad='<a style=\"display:block;\" href=\"'.$_result_left['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_left['image'],1).'\" width=\"'.$width.'\" height=\"'.$height.'\" border=\"0\"></a>';
               $html .='
                  <script type=\"text/javascript\">
                    var theFloaters  = new floaters();
                    theFloaters.addItem(\"followDiv2\",20,230,\"'.addslashes($lad).'\");
                    theFloaters.play();
                  </script>
               '; 
          }elseif($width){
              $lad='<a style=\"display:block;\" href=\"'.$_result_left['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_left['image'],1).'\" width=\"'.$width.'\" border=\"0\"></a>';
               $html .='
                  <script type=\"text/javascript\">
                    var theFloaters  = new floaters();
                    theFloaters.addItem(\"followDiv2\",20,230,\"'.addslashes($lad).'\");
                    theFloaters.play();
                  </script>
               ';
          }else{
              $lad='<a style=\"display:block;\" href=\"'.$_result_left['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_left['image'],1).'\" width=\"120\" height=\"150\" border=\"0\"></a>';
               $html .='
                  <script type=\"text/javascript\">
                    var theFloaters  = new floaters();
                    theFloaters.addItem(\"followDiv2\",20,230,\"'.addslashes($lad).'\");
                    theFloaters.play();
                  </script>
               ';
          }
      }elseif(!empty($_result_right)){
          if($width && $height){
              $rad='<a style=\"display:block;\" href=\"'.$_result_right['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_right['image'],1).'\" width=\"'.$width.'\" height=\"'.$height.'\" border=\"0\"></a>';
               $html .='
                  <script type=\"text/javascript\">
                    var theFloaters  = new floaters();
                    theFloaters.addItem(\"followDiv1\",\"document.body.clientWidth-'.$width.'\",230,\"'.addslashes($rad).'\");
                    theFloaters.play();
                  </script>
               '; 
          }elseif($width){
              $rad='<a style=\"display:block;\" href=\"'.$_result_right['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_right['image'],1).'\" width=\"'.$width.'\"  border=\"0\"></a>';
               $html .='
                  <script type=\"text/javascript\">
                    var theFloaters  = new floaters();
                    theFloaters.addItem(\"followDiv1\",\"document.body.clientWidth-'.$width.'\",230,\"'.addslashes($rad).'\"); 
                    theFloaters.play();
                  </script>
               ';
          }else{
              $rad='<a style=\"display:block;\" href=\"'.$_result_right['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_right['image'],1).'\" width=\"120\" height=\"150\" border=\"0\"></a>';
               $html .='
                  <script type=\"text/javascript\">
                    var theFloaters  = new floaters();
                    theFloaters.addItem(\"followDiv1\",\"document.body.clientWidth-120\",230,\"'.addslashes($rad).'\");
                    theFloaters.play();
                  </script>
               ';
          }
      }else{
        $html='<span style=\"color:red\">请输入正确的漂浮广告ID</span>';
      }
      
      $str='<?php 
              echo "'.$html.'\n";
            ?>';
      $str .= $content;
      return $str;
  }
 
  /**
   * [_myflAd 漂浮广告]
   * @param  [type] $tag    [description]
   * @param  [type] $content [description]
   * @return [type]          [description]
   */
  public function _myflAd($tag,$content){
     
      $model=!empty($tag['model'])?$tag['model']:'Ad';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $date=!empty($tag['date'])?$tag['date']:'';
      $width=!empty($tag['width'])?$tag['width']:0;
      $height=!empty($tag['height'])?$tag['height']:0;
      $where= $this->adjunct($tag);
      $id=!empty($tag['id'])?$tag['id']:0;
      $order=$tag['order'];

      if(empty($where))
          $where.='status=0';
        else
          $where.=' and status=0'; 


      if($id){
          $_result_content=M($model)->field($field)->where($where)->order($order)->limit($limit)->find($id);
          
          $html='<script src=\"__JS__/ad/ad.js\" text=\"text/javascript\" charset=\"uft-8\"></script>\n';
          if(!empty($_result_content)){
              if($width && $height){
                $flad='<a href=\"'.$_result_content['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_content['image'],1).'\" width=\"'.$width.'\" height=\"'.$height.'\" border=\"0\"></a>';
                 $html .='
                    <script type=\"text/javascript\">
                      var ad=new ad();
                      ad.addItem(\"'.addslashes($flad).'\");
                      ad.play();
                    </script>
                 '; 

              }elseif ($width || $height) {
                if($width){
                   $flad='<a href=\"'.$_result_content['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_content['image'],1).'\" width=\"'.$width.'\" border=\"0\"></a>';
                   $html .='
                      <script type=\"text/javascript\">
                        var ad=new ad();
                        ad.addItem(\"'.addslashes($flad).'\");
                        ad.play();
                      </script>
                   '; 
                }else{
                   $flad='<a href=\"'.$_result_content['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_content['image'],1).'\" height=\"'.$height.'\" border=\"0\"></a>';
                   $html .='
                      <script type=\"text/javascript\">
                        var ad=new ad();
                        ad.addItem(\"'.addslashes($flad).'\");
                        ad.play();
                      </script>
                   ';   
                }
              }else{
                 $flad='<a href=\"'.$_result_content['url'].'\" target=\"_blank\"><img src=\"__ROOT__'.substr($_result_content['image'],1).'\" width=\"80\" height=\"80\" border=\"0\"></a>';
                 $html .='
                    <script type=\"text/javascript\">
                      var ad=new ad();
                      ad.addItem(\"'.addslashes($flad).'\");
                      ad.play();
                    </script>
                 '; 
              }
          }else{
            $html='<span style=\"color:red\">请输入正确的漂浮广告ID</span>';
          }
      }else{
        $html ='<span style=\"color:red\">请输入漂浮广告的ID</span>';
      }
      
      $str='<?php 
              echo "'.$html.'\n";
            ?>';
      $str .= $content;
      return $str;
  }

  /***
    *Flink友情链接
    CREATE TABLE IF NOT EXISTS `think_Flink` (
      `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
      `title` char(80) NOT NULL DEFAULT '' COMMENT '友情链接中文名称',
      `name` char(20) NOT NULL DEFAULT '' COMMENT '友情链接英文名称',
      `description` char(250) NOT NULL DEFAULT '' COMMENT '友情链接简单介绍',
      `ico` char(250) NOT NULL DEFAULT '' COMMENT '友情链接图标',
      `url` char(250) NOT NULL DEFAULT '' COMMENT '友情链接链接指向,链接到的地址',
      `position` int(1) NOT NULL DEFAULT 0 COMMENT '友情链接位置：1首页，2内页',
      `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
      `effective` int(11) NOT NULL DEFAULT 0 COMMENT '友情链接有效时间,在有效时间内会显示',
      `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序：越小越靠前',
      `status` int(1) NOT NULL DEFAULT 0 COMMENT '状态：0正常，1禁用',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
   ***/
  /**
   * [_flink 友情链接读取]
   * @param  [type] $tag    [description]
   * @param  [type] $content [description]
   * @return [type]          [description]
   */
  public function _flink($tag,$content){
    
      $model=!empty($tag['model'])?$tag['model']:'Flink';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $position=!empty($tag['position'])?$tag['position']:'';
      
      $where= $this->adjunct($tag['where']);
      $limit=$tag['limit'];
      $order=$tag['order'];

      if(empty($where))
          $where.='status=0';
        else
         $where.=' and status=0';

      if(!empty($position)){
          $where.=' and position='.$position;
      }

      $str='<?php 
          $_result_content=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->order("'.$order.'")->limit("'.$limit.'")->select();
          $flink=$_result_content;
      ?>';
      $str .= $content;
      return $str;
  }

  /***
    *Column栏目表
    CREATE TABLE IF NOT EXISTS `think_Column` (
      `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
      `title` char(80) NOT NULL DEFAULT '' COMMENT '栏目中文名称',
      `name` char(20) NOT NULL DEFAULT '' COMMENT '栏目英文名称',
      `description` char(250) NOT NULL DEFAULT '' COMMENT '栏目简单介绍',
      `banner` char(250) NOT NULL DEFAULT '' COMMENT '栏目Banner',
      `iamge` char(250) NOT NULL DEFAULT '' COMMENT '栏目图片',
      `ico` char(250) NOT NULL DEFAULT '' COMMENT '栏目图标',
      `position` int(1) NOT NULL DEFAULT 0 COMMENT '栏目位置：1头部，2中部，3左侧，4右侧，5底部',
      `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
      `effective` int(11) NOT NULL DEFAULT 0 COMMENT '栏目有效时间,在有效时间内会显示',
      `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序：越小越靠前',
      `status` int(1) NOT NULL DEFAULT 0 COMMENT '状态：0正常，1禁用',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
   ***/
  /**
   * [_channel 单个栏目读取]
   * @param  [type] $tag    [description]
   * @param  [type] $content [description]
   * @return [type]          [description]
   */
  public function _channel($tag,$content){
     
      $model=!empty($tag['model'])?$tag['model']:'Column';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $id=$tag['id'];
      $where= $this->adjunct($tag);
      $limit=$tag['limit'];
      $order=$tag['order'];
      $empty=!empty($tag['empty'])?$tag['empty']:'';

      if(empty($where))
          $where.='status=0';
        else
         $where.=' and status=0'; 
     
      $str='<?php 
          $_channel=M("'.$model.'")->field("'.$field.'")->find("'.$id.'");
          if (count($_channel)) {
            $channel=$_channel;
          } else {
            echo "'.$empty.'";
          }      
      ?>';
      $str .= $content;
      return $str;
  }

  //调用子栏目列表
  public function _channellist($tag,$content){
      
      $model=!empty($tag['model'])?$tag['model']:'Column';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $fid=!empty($tag['fid'])?$tag['fid']:$_GET['cid'];
      $empty=!empty($tag['empty'])?$tag['empty']:'';
      $where= $this->adjunct($tag);
      $limit=$tag['limit'];
      $order=$tag['order'];
      if(empty($where))
          $where.='status=0';
        else
         $where.=' and status=0';

      if(!empty($fid)){
          $where.=' and fid = '.$fid;
      }

      $str='<?php 
          $_result_channellist=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->order("'.$order.'")->limit("'.$limit.'")->select();p(M("'.$model.'")->getlastsql()); 
          if (count($_result_channellist)) {
             $channellist=$_result_channellist;
          } else {
             exit('.$empty.');
          }
         
      ?>';
      $str .= $content;
      return $str;
  }

  /***
    *Article文章表
    CREATE TABLE IF NOT EXISTS `think_Article` (
      `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
      `column_id` int(1) NOT NULL DEFAULT 0 COMMENT '所属栏目',
      `title` char(80) NOT NULL DEFAULT '' COMMENT '文章中文名称',
      `name` char(20) NOT NULL DEFAULT '' COMMENT '文章英文名称',
      `description` char(250) NOT NULL DEFAULT '' COMMENT '栏目简单介绍',
      `iamge` char(250) NOT NULL DEFAULT '' COMMENT '文章图片',
      `com` int(1) NOT NULL DEFAULT 0 COMMENT '推荐，0否，1是',
      `hot` int(1) NOT NULL DEFAULT 0 COMMENT '最热，0否，1是',
      `new` int(1) NOT NULL DEFAULT 0 COMMENT '最新，0否，1是',
      `head` int(1) NOT NULL DEFAULT 0 COMMENT '头条，0否，1是',
      `top` int(1) NOT NULL DEFAULT 0 COMMENT '置顶，0否，1是',
      `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
      `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序：越小越靠前',
      `status` int(1) NOT NULL DEFAULT 0 COMMENT '状态：0正常，1禁用',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
   ***/
  /**
   * [_randomrecom 随机推荐文章]
   * @param  [type] $tag    [description]
   * @param  [type] $content [description]
   * @return [type]          [description]
   */
  public function _randomrecom($tag,$content){
     
      $model=!empty($tag['model'])?$tag['model']:'Article';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $fid=$tag['fid'];
      $where= $this->adjunct($tag);
      $limit=!empty($tag['limit'])?$tag['limit']:2;
      $order=!empty($tag['order'])?$tag['order']:'id';
      $empty=!empty($tag['empty'])?$tag['empty']:'';
      
      if(empty($where))
          $where.='status=0';
        else
         $where.=' and status=0';
      
      if(!empty($fid)){
          $where.=' and fid = '.$fid;
      }

      $DB_PREFIX=C('DB_PREFIX');
 
      $sql='SELECT * FROM `'.$DB_PREFIX.$model.'`
          WHERE id >= (SELECT floor(RAND() * (SELECT MAX(id) FROM `'.$DB_PREFIX.$model.'` where '.$where.'))) 
          ORDER BY id LIMIT '.$limit;
      $str='<?php 
          $_result_randomrecom=M("'.$model.'")->query("'.$sql.'");
          if (count($_result_randomrecom)) {
              $randomrecom=$_result_randomrecom;
           } else {
              exit('.$empty.');
           }     
      ?>';
      $str .= $content;
      return $str;
  }

  /***
    *Tag标签表
    CREATE TABLE IF NOT EXISTS `think_Tag` (
      `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
      `column_id` int(1) NOT NULL DEFAULT 0 COMMENT '所属栏目',
      `title` char(80) NOT NULL DEFAULT '' COMMENT '标签中文名称',
      `name` char(20) NOT NULL DEFAULT '' COMMENT '标签英文名称',
      `description` char(250) NOT NULL DEFAULT '' COMMENT '标签简单介绍',
      `content` ntext NOT NULL DEFAULT '' COMMENT '标签内容',
      `position` int(1) NOT NULL DEFAULT 0 COMMENT '标签位置：定位标签',
      `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
      `effective` int(11) NOT NULL DEFAULT 0 COMMENT '标签有效时间,在有效时间内会显示',
      `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序：越小越靠前',
      `status` int(1) NOT NULL DEFAULT 0 COMMENT '状态：0正常，1禁用',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
   ***/
  /**
   * [_tag 标签调用]
   * @param  [type] $attr    [description]
   * @param  [type] $content [description]
   * @return [type]          [description]
   */
  public function _tag($tag,$content){
    
      $model=!empty($tag['model'])?$tag['model']:'Tag';
      $field=!empty($tag['field'])?$tag['field']:'*';

      $id=$tag['id'];
      $where= $this->adjunct($tag);
      $limit=!empty($tag['limit'])?$tag['limit']:2;
      $order=!empty($tag['order'])?$tag['order']:'id';
      $empty=!empty($tag['empty'])?$tag['empty']:'';
      
      if(empty($where))
          $where.='status=0';
        else
         $where.=' and status=0';
      
      if(!empty($id)){
          $where.=' and id = '.$id;
      }
    /*
      if(!empty($date)){
          $date=explode(' ', $date);
          if(count($date)>1){
            if(count($date)==2){
              $where.=' and create_time between '.strtotime($date[0]).' and '.strtotime($date[1]);
            }else{
              foreach ($date as $v) {
                $temp.= strtotime($v).',';
              }
              $temp=substr($temp, 1, -1);   //去掉最后一个字符
              $where.=' create_time IN ('.$temp.')';
            }
          }else{
            $where.=' and create_time = '.strtotime($date[0]);
          }
      }
      */
      $str='<?php 
          $_result_tag=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->find();
          if (count($_result_tag)) {
            $tag=$_result_tag;
          } else {
            exit('.$empty.');
          }                     
      ?>';
      $str .= $content;
      return $str;
  }

  /**
   * [_tags 标签调用]
   * @param  [type] $tag    [description]
   * @param  [type] $content [description]
   * @return [type]          [description]
   */
  public function _tags($tag,$content){
 
      $model=!empty($tag['model'])?$tag['model']:'Tag';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $empty=!empty($tag['empty'])?$tag['empty']:'';
      $limit=$tag['limit'];
      $order=$tag['order'];
      $id=$tag['fid'];

      $where= $this->adjunct($tag);  //条件

      if(!empty($id)){
          $where.=' and fid = '.$id;
      }
            
      $str='<?php 
          $_result_tags=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->order("'.$order.'")->limit("'.$limit.'")->select(); 
          if (count($_result_tag)) {
            $tags=$_result_tags;
          } else {
            exit('.$empty.');
          }           
      ?>';
      $str .= $content;
      return $str;
  }

  /*
    --
    -- 表的结构 `think_service`
    --
    CREATE TABLE IF NOT EXISTS `think_service` (
      `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键，自动增长',
      `name` varchar(100) NOT NULL COMMENT '客服名称',
      `connect` varchar(50) NOT NULL COMMENT '联系方式',
      `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否启用：0是，1否',
      `create_time` int(11) NOT NULL COMMENT '添加时间',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='客服表' AUTO_INCREMENT=1 ;
    */
   /**
    * [_service 客服]
    * @param  [type] $attr    [description]
    * @param  [type] $content [description]
    * @return [type]          [description]
    */
   public function _service($tag,$content){
      
      $model=!empty($tag['model'])?$tag['model']:'Service';
      $field=!empty($tag['field'])?$tag['field']:'*';

      $limit=$tag['limit'];
      $order=$tag['order'];
      $custom=!empty($tag['custom'])?$tag['custom']:'';
      $empty=!empty($tag['empty'])?$tag['empty']:'';
    
      $where= $this->adjunct($attr);  //条件
      if(empty($custom)){
          $_result_content=M($model)->field($field)->where($where)->order($order)->limit($limit)->select();
          $qq ='\\\"';
          foreach ($_result_content as  $v) { 
            $qq .= $v['connect'].":".'|'.$v['name'].'*';
            //$qq=addcslashes($qq);
          }
          $qq .='\\\"';
      }else{
           $qq .=$custom;
      }
      
      $html='<link rel=\"stylesheet\" href=\"__JS__/qq/skin/style.css\">
        <script type=\"text/javascript\"> \$url=\"__URL__\";\$js=\"__JS__\";</script>
        <script type=\"text/javascript\" src=\"__JS__/qq/js/jquery.min.js\"></script>
        <script type=\"text/javascript\" src=\"__JS__/qq/js/jquery.kf.js\"></script>
        <script type=\"text/javascript\">
            $(function(){
              $(\"body\").kefu({qq:'.$qq.'});
            });
        </script>
        ';
      $str='<?php 
              echo "'.$html.'";    
            ?>';
      $str .= $content;
      return $str;
   }


  //重组查询条件
  private function adjunct($attr){
      $date=!empty($attr['date'])?$attr['date']:'';
      $where= $this->condition($attr['where']);

      if(empty($where)){
           $where.='status=0';
      }else{
        if(strpos($where,'status') === false){
            $where.=' and status=0';
        }  
      }
        
      if(!empty($date)){
          $date=explode(' ', $date);
          if(count($date)>1){
            if(count($date)==2){  //两个区间查询
              $where.=' and create_time between '.strtotime($date[0]).' and '.strtotime($date[1]);
            }else{
              foreach ($date as $v) { //两个以上存在查询
                $temp.= strtotime($v).',';
              }
              $temp=substr($temp, 1, -1);   //去掉最后一个字符
             
              $where.=' and create_time IN ('.$temp.')';
            }
          }else{  //一个精确查询
            $where.=' and create_time = '.strtotime($date[0]);
          }
      }

      $attr1=$this->makeAttr($attr['attr']);

      if (!empty($where) || !empty($attr1)) {
         if(!empty($where) && !empty($attr1)){
            $where .= ' and '.$attr1;
         }else{
            $where .= $attr1;
         }
      }

      return $where;
  }

  /**
    *--
    *-- 表的结构 `think_file`
    *--
    *CREATE TABLE IF NOT EXISTS `think_file` (
    *  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自动增长',
    *  `title` varchar(50) NOT NULL COMMENT '文件名称',
    *  `ico` varchar(150) NOT NULL COMMENT '文件图标',
    *  `name` varchar(50) NOT NULL COMMENT '文件名称',
    *  `rename` varchar(50) NOT NULL COMMENT '文件上传名',
    *  `type` varchar(20) NOT NULL COMMENT '文件类型',
    *  `description` varchar(250) NOT NULL COMMENT '文件说明',
    *  `size` int(11) NOT NULL COMMENT '文件大小(B)',
    *  `path` varchar(150) NOT NULL COMMENT '文件路径',
    *  `sort` int(11) NOT NULL COMMENT '排序:愈小愈靠前',
    *  `status` tinyint(1) NOT NULL COMMENT '文件状态:0正常,1禁用',
    *  `create_time` int(11) NOT NULL COMMENT '文件上传时间',
    *  PRIMARY KEY (`id`)
    *) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文件表' AUTO_INCREMENT=1 ;
  **/
  /**
  * [_file 文件]
  * @param  [type] $attr    [description]
  * @param  [type] $content [description]
  * @return [type]          [description]
  */
  public function _file($tag,$content){
    
      $model=!empty($tag['model'])?$tag['model']:'File';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $limit=$tag['limit'];
      $order=$tag['order'];
      $empty=!empty($tag['empty'])?$tag['empty']:'没有数据';
      $where= $this->adjunct($tag);  //条件
      
      $_result_content=M($model)->field($field)->where($where)->order($order)->limit($limit)->select();
      //empty
      $str=!empty($_result_content)?'<?php $file=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->order("'.$order.'")->limit("'.$limit.'")->select(); ?>':'<?php echo "'.$empty.'"; ?>';
    
      $str .= $content;
      return $str;
  }

  /*
    --
    -- 表的结构 `think_confing`
    --
    CREATE TABLE IF NOT EXISTS `think_confing` (
      `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键，自增长',
      `title` varchar(150) NOT NULL COMMENT '网站名',
      `keywords` varchar(250) NOT NULL COMMENT '网站关键词',
      `description` varchar(500) NOT NULL COMMENT '网站说明',
      `conact` varchar(1000) NOT NULL COMMENT '联系方式',
      `flink` text NOT NULL COMMENT '友情链接',
      `sum` int(10) NOT NULL COMMENT '幻灯个数',
      `copyright` varchar(10000) NOT NULL COMMENT '版权信息',
      `shard` text NOT NULL COMMENT '分享代码',
      `code` text NOT NULL COMMENT '统计代码，多个使用'':''分割',
      `date` int(10) NOT NULL COMMENT '修改日期',
      `status` tinyint(1) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COMMENT='网站配置' AUTO_INCREMENT=2;
    --
    -- 转存表中的数据 `think_confing`
    --
    INSERT INTO `think_confing` (`id`, `title`, `keywords`, `description`, `conact`, `flink`, `sum`, `copyright`, `shard`, `code`, `date`, `status`) VALUES
    (1, '51Game', '51Game', '51Game', '测试', 'htmlspecialchars', 3, '测试', '测试', '测试', 1419500501, 0);

   */
  /**
  * [_site 文件]
  * @param  [type] $attr    [description]
  * @param  [type] $content [description]
  * @return [type]          [description]
  */
  public function _site($tag,$content){
     
      $model=!empty($tag['model'])?$tag['model']:'confing';
      $field=!empty($tag['field'])?$tag['field']:'*';
      $limit=$tag['limit'];
      $order=$tag['order'];
      $empty=!empty($tag['empty'])?$tag['empty']:'没有数据';
      $where= $this->adjunct($tag);  //条件
      p($where);die;
      $_result_content=M($model)->field($field)->where($where)->order($order)->limit($limit)->find();
      //empty
      $str=!empty($_result_content)?'<?php $site=M("'.$model.'")->field("'.$field.'")->where("'.$where.'")->order("'.$order.'")->limit("'.$limit.'")->find(); ?>':'<?php echo "'.$empty.'"; ?>';
    
      $str .= $content;
      return $str;
   }


  //重写查询符号
  private function condition($str){
      if(strstr($str,'neq') || strstr($str,'eq')){
          if(strstr($str,'neq')){
              $str=str_replace('neq', '!=', $str);
          }else{
              $str=str_replace('eq', '=', $str);
          }
      }

      if(strstr($str,'elt') || strstr($str,'lgt') || strstr($str,'lt') ){
         if(strstr($str,'elt')){
            $str=str_replace('elt', '<=', $str);
         }elseif(strstr($str,'lgt')){
            $str=str_replace('lgt', '<>', $str);
         }else{
            $str=str_replace('lt', '<', $str);
         }
      }

      if(strstr($str,'gt') || strstr($str,'egt')){
         
          if(strstr($str,'egt')){
             $str=str_replace('egt', '>=', $str);
          }else{
             $str=str_replace('gt', '>', $str);
          }
      }
      return $str;
   }
  //组成属性条件
  protected function makeAttr($attr){ 
    switch ($attr) {
      case 'com':   #推荐
        return ' com = 1';
        break;
      case 'new':   #最新
        return' new = 1';
        break;
      case 'hot':   #最热
        return ' hot = 1';
        break;
      case 'head':  #头条
        return ' head = 1';
        break;
      case 'top':   #置顶
        return ' top = 1';
        break;
      case 'img':   #图文
        return ' img = 1';
        break;
      default:
        return '';
        break;
    }
  }

}