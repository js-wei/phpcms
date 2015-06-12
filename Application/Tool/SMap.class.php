<?php
namespace Tool;

class SMap{
	protected $type=array(
			'search'=>'http://apis.map.qq.com/ws/place/v1/search?',
			'suggestion'=>'http://apis.map.qq.com/ws/place/v1/suggestion?',
			'geocoder'=>'http://apis.map.qq.com/ws/geocoder/v1?',
			'district'=>'http://apis.map.qq.com/ws/district/v1/list?', 
      'getchildren'=>'http://apis.map.qq.com/ws/district/v1/getchildren?',
			'translate'=>'http://apis.map.qq.com/ws/coord/v1/translate?',
			'streetview'=>'http://apis.map.qq.com/ws/streetview/v1/getpano?',
      'streetimage'=>'http://apis.map.qq.com/ws/streetview/v1/image?'
		);
	 protected $param;

   public function __construct(){
        $conf=C('Smap');
        ksort($conf);
        foreach ($conf as $k => $v) {
           if(!empty($v))
              $this->param.='&'.$k.'='.$v;
        }
       
    }
  /**
   * [search 搜素信息]
   * @param  [type]  $area    [description]
   * @param  [type]  $keyword [description]
   * @param  [type]  $filter  [description]
   * @param  integer $type    [description]
   * @return [type]           [description]
   * $area=array(
   *   'region'=>'',
   *   'range'=>'0'
   * );
   * $filter=array(
   *   '公交','银行' ....
   *   );
   */
	public function search($squ,$keyword,$filter,$index=1,$type=1){

      //p($squ);die;
      if($type==1){
          $boundary="boundary=region(".urlencode($squ['region']).",".$squ['range'].")".'&';
      }elseif($type==2){
          $boundary="boundary=nearby(".urlencode($squ['region']).",".$squ['range'].")".'&';
      }elseif($type==3){
          $boundary="boundary=rectangle(".urlencode($squ['region']).",".$squ['range'].")".'&';
      }
      $filter=$this->filter($filter);
      $index=!empty($index)?$index:1;
  		$url=$this->type['search'].$boundary.'keyword='.urlencode($keyword).$filter.$this->param.'&page_index='.$index;
      $data=$this->curl_get($url);
      $data=json_decode($data,true);
      $data['page_count']=ceil($data['count']/C('Smap.page_size'));
      $data['page_index']=$index;
  		return $data;
  	 
	}
  /**
   * [suggestion 提示信息]
   * @param  [type] $region  [区域]
   * @param  [type] $keyword [关键词]
   * @param  [type] $filter  [过滤分类]
   * @return [type]          [description]
   * $filter=array(
   *   '公交','银行' ....
   *   );
   */
  public function suggestion($region,$keyword,$index,$filter){
    $filter=$this->filter($filter);
    $index=!empty($index)?1:$index;
    $url=$this->type['suggestion'].'&region='.$region.'&keyword='.urlencode($keyword).$filter.$this->param.'&page_index='.$index;
    return $this->curl_get($url);
  }
  /**
   * [geocoder 地理信息解析]
   * @param  [type] $address [description]
   * @param  [type] $region  [description]
   * @return [type]          [description]
   */
  public function geocoder($address,$region){
    $url=$this->type['geocoder'].'&address='.$address.'&region='.urlencode($region).$filter.$this->param;
    $data=$this->curl_get($url);
    $data=json_decode($data,true);
    $temp['location']=$data['result']['location'];
    foreach ($data['result']['address_components'] as  $v) {
      $temp['address'].=$v.' ';
    }
    $temp['deviation']='误差级别(米):'.$data['result']['deviation'];
    $temp['similarity']='相似度:'.$data['result']['similarity']?'完全匹配':'仅参考';
    $temp['reliability']='可信度:'.($data['reliability']>=7)?'较为准确':'仅参考'; 
    return $temp;
  }

  /**
   * [district 获取行政区划]
   * @return [type] [description]
   */
  public function district(){
    $url=$this->type['district'].$this->param;
    $data=$this->curl_get($url);
    $data=json_decode($data,true);
    $temp['province']=$data['result'][0];
    $temp['city']=$data['result'][1];
    $temp['county']=$data['result'][2];
    return $temp;
  }
  /**
   * [getchildren 获取行政区划]
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  public function getchildren($id){
    $url=$this->type['getchildren'].'id='.$id.$this->param;
    $data=$this->curl_get($url);
    $data=json_decode($data,true);
    return $data['result'][0];
  }
  /**
   * [translate 坐标转换]
   * @param  [type] $locations [description]
   * @param  [type] $type      [description]
   * @return [type]            [description]
   */
  public function translate($locations,$type){
    $locations=!empty($locations)?'&locations='.$locations:'';
   
    $type = $this->maketype($type);
    
    $url=$this->type['translate'].$locations.$type.$this->param;
    $data=$this->curl_get($url);
    $data=json_decode($data,true);
    return $data;
  }
  /**
   * [streetview 街景查询]
   * @param  [type]  $locations [description]
   * @param  integer $radius    [description]
   * @return [type]             [description]
   */
  public function streetview($locations,$radius=100){
      if(strstr($locations,',')){
         $locations=!empty($locations)?'location='.$locations:'';
       }else{
         $locations=!empty($locations)?'id='.$locations:'';
       }
      $url=$this->type['streetview'].$locations.'&radius='.$radius.$this->param;
      $data=$this->curl_get($url);
      $data=json_decode($data,true);
      return $data;
  }

  public function streetimage($size='140x140',$location){
      $url=$this->type['streetimage'].'location='.$location.'&size='.$size.$this->param;
      $data=$this->curl_get($url);
      return $data;
  }

  /**
   * [maketype description]
   * @param  [type] $type [description]
   * @return [type]       [description]
   */
  private function maketype($type){
      $type=!empty($type)?$type:'soso';
      $data=array(
          1=>'GPS1',
          2=>'sogou搜狗2',
          3=>'baidu百度3',
          4=>'mapbar4',
          5=>'soso腾讯google谷歌,高德5',
          6=>'墨卡托6'
        );
      foreach ($data as $k => $v) {
          if(strstr($v,$type)){
            $type=$k;
          }
      }
      $type='&type='.$type;
      return $type;
  }
  /**
   * [filter description]
   * @param  [type] $filter [description]
   * @return [type]         [description]
   */
  private function filter($filter){
      if(!empty($filter) && is_array($filter)){
          $temp='&filter=category=';
          foreach ($filter as $v) {
             $temp.=urlencode($v).',';
          }
          return substr($temp,0,-1);
      }else{
         return '';
      }
     
  }
  /**
   * 模拟提交参数，支持https提交 可用于各类api请求
   * @param string $url ： 提交的地址
   * @param array $data :POST数组
   * @param string $method : POST/GET，默认GET方式
   * @return mixed
   */
  private function curl_get($url, $data='', $method='GET'){ 
      $curl = curl_init(); // 启动一个CURL会话
      curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
      curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
      curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
      if($method=='POST'){
          curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
          if ($data != ''){
              curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
          }
      }
      curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
      curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
      $tmpInfo = curl_exec($curl); // 执行操作
      curl_close($curl); // 关闭CURL会话
      return $tmpInfo; // 返回数据
  }
}