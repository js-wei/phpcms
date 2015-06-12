<?php
/**
 * 配置项
 *'lookout'=>array(
        'ak'=>'xooZZG25yNjbmCFGytrRyor0',       //ak
        'page_size'=>10,                        //显示条数
        'page_index'=>1,                        //显示页数 (默认:第一页)
    )
 * 类实现对百度鹰眼的操作
 */
namespace Tool;

class LbsTrace{
	private $url=array(
		'trace_create'=>'http://api.map.baidu.com/trace/v1/service/create',                           //创建鹰眼服务
		'trace_delete'=>'http://api.map.baidu.com/trace/v1/service/delete',                           //删除鹰眼服务
		'trace_detail'=>'http://api.map.baidu.com/trace/v1/service/detail',                           //显示鹰眼服务
		'trace_list'=>'http://api.map.baidu.com/trace/v1/service/list?',                              //列出鹰眼服务
		'trace_update'=>'http://api.map.baidu.com/trace/v1/service/update',                           //更新鹰眼服务
		'trace_addcolumn'=>'http://api.map.baidu.com/trace/v1/service/addcolumn',                     //添加鹰眼服务列
        'trace_updatecolumn'=>'http://api.map.baidu.com/trace/v1/service/updatecolumn',               //更新鹰眼服务列
        'trace_delcolumn'=>'http://api.map.baidu.com/trace/v1/service/delcolumn',                     //删除鹰眼服务列
        'track_create'=>'http://api.map.baidu.com/trace/v1/track/create',                             //创建监控轨迹
        'track_detail'=>'http://api.map.baidu.com/trace/v1/track/detail',                             //显示监控轨迹
        'track_upload'=>'http://api.map.baidu.com/trace/v1/track/upload',                             //更新监控轨迹
        'track_history'=>'http://api.map.baidu.com/trace/v1/track/history',                           //历史监控轨迹
        'track_delete'=>'http://api.map.baidu.com/trace/v1/track/delete',                             //删除监控轨迹
        'track_list'=>'http://api.map.baidu.com/trace/v1/track/list',                                 //列出监控轨迹
        'conf_set'=>'http://api.map.baidu.com/trace/v1/conf/set',                                     //设置track的配置信息
        'conf_get'=>'http://api.map.baidu.com/trace/v1/conf/get',                                     //获取track的配置信息
        'relation_create'=>'http://api.map.baidu.com/trace/v1/relation/create',                       //创建
        'relation_detail'=>'http://api.map.baidu.com/trace/v1/relation/detail',
        'relation_delete'=>'http://api.map.baidu.com/trace/v1/relation/delete',
        'attribute_add'=>'http://api.map.baidu.com/trace/v1/attribute/add',
        'attribute_delete'=>'http://api.map.baidu.com/trace/v1/attribute/delete',
        'attribute_update'=>'http://api.map.baidu.com/trace/v1/attribute/update',
        'attribute_batchset'=>'http://api.map.baidu.com/trace/v1/attribute/batchset',
        'attribute_set'=>'http://api.map.baidu.com/trace/v1/attribute/set',
		);
	private $param;		//参数
	/**
	 * [__construct 构造函数]
	 */
	public function __construct(){
        $conf=C('lookout');
        ksort($conf);
        $this->param=$conf;
    }
    /**
     * [attribute_add 为某个service添加一个属性]
     * @param  integer $service_id [Service唯一标识]
     * @param  string  $attr_name  [属性名称]
     * @param  string  $attr_desc  [属性的描述信息]
     * @param  integer $is_search  [是否支持检索:0不支持,1支持]
     * @return [type]              [description]
     */
    public function attribute_add($service_id,$attr_name,$attr_desc,$is_search=0){
        $_ak=$this->param['ak'];
        $uri=$this->url['attribute_add'];
        $data['ak']=$_ak;
        $data['service_id']=$service_id;
        $data['attr_name']=$attr_name;
        $data['attr_desc']=$attr_desc;
        $data['is_search']==$is_search;
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result; 
    }
    /**
     * [attribute_delete 删除一个service下的某个属性]
     * @param  integer $service_id [Service唯一标识]
     * @param  string  $attr_name  [属性的名称]
     * @return [type]              [description]
     */
    public function attribute_delete($service_id,$attr_name){
        $_ak=$this->param['ak'];
        $uri=$this->url['attribute_delete'];
        $data['ak']=$_ak;
        $data['service_id']=$service_id;
        $data['attr_name']=$attr_name;
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result; 
    }
    /**
     * [attribute_update 修改一个service下的某个属性信息]
     * @param  integer $service_id [service唯一标识]
     * @param  string  $attr_name  [属性的名称]
     * @param  string  $attr_desc  [属性的描述信息]
     * @param  integer $is_search  [是否支持检索,1代表支持检索，0代表不支持检索]
     * @return [type]              [description]
     */
    public function attribute_update($service_id,$attr_name,$attr_desc,$is_search=0){
        $_ak=$this->param['ak'];
        $uri=$this->url['attribute_update'];
        $data['ak']=$_ak;
        $data['service_id']=$service_id;
        $data['attr_name']=$attr_name;
        $data['attr_desc']=$attr_desc;
        $data['is_search']==$is_search;
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result; 
    }
    /**
     * [attribute_set 对某个track的一个或多个属性进行赋值]
     * @param  integer $service_id    [service唯一标识]
     * @param  string  $track_name    [track的唯一标识]
     * @param  string  $attribute_key [属性的名称]
     * @return [type]                 [description]
     */
    public function attribute_set($service_id,$track_name,$attribute_key){
        $_ak=$this->param['ak'];
        $uri=$this->url['attribute_update'];
        $data['ak']=$_ak;
        $data['service_id']=$service_id;
        $data['track_name']=$track_name;
        $data['attribute_key']=$attribute_key;
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result; 
    }
    /**
     * [relation_create 建立主控设备与被控设备二者之间的关系]
     * @param  integer $service_id  [Service服务唯一标识]
     * @param  string  $master_name [主控设备的唯一标识]
     * @param  string  $track_name  [被控设备的唯一标识]
     * @param  string  $description [被控设备的描述信息，如昵称等]
     * @return [type]               [description]
     */
    public function relation_create($service_id,$master_name,$track_name,$description){
        $_ak=$this->param['ak'];
        $uri=$this->url['relation_create'];
        $data['ak']=$_ak;
        $data['service_id']=$service_id;
        $data['master_name']=$master_name;
        $data['track_name']=$track_name;
        $data['description']==$description;
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result; 
    }
    /**
     * [relation_detail 查询自己监护的被控设备的列表]
     * @param  integer $service_id  [Service服务唯一标识]
     * @param  string  $master_name [主控设备唯一标识]
     * @return [type]               [description]
     */
    public function relation_detail($service_id,$master_name){
        $data=$this->param;
        $data['service_id']=$id;
        $data['master_name']=$master_name;
        $uri=$this->url['relation_detail'].$this->reset_param($data);  
        $_result = $this->_request($uri);
        return $_result;
    }
    /**
     * [relation_delete 删除主控设备与被控设备二者之间的关系]
     * @param  integer $service_id  [Service唯一标识]
     * @param  string  $master_name [主控设备的唯一标识]
     * @param  string  $track_name  [被控设备的唯一标识]
     * @return [type]               [description]
     */
    public function relation_delete($service_id=0,$master_name='',$track_name=''){
        $_ak=$this->param['ak'];
        $uri=$this->url['relation_delete'];
        $data['ak']=$_ak;
        $data['service_id']=$service_id;
        $data['master_name']=$master_name;
        $data['track_name']=$track_name;
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result; 
    }
    /**
     * [config_set 设置track对应的配置信息]
     * @param  integer $service_id [Service服务唯一标识]
     * @param  integer $track_id   [Track实时点id]
     * @param  string  $track_name [用户自定义track标识，同一service服务中track的唯一标识]
     * @param  string  $conf       [Track对应的配置信息:loc_period:1:30|upload_period:1:60]
     * @return [type]              [配置信息]
     */
    public function conf_set($service_id=0,$track_id=0,$track_name='',$conf=''){
        $_ak=$this->param['ak'];
        $uri=$this->url['conf_get'];
        $data['ak']=$_ak;
        $data['service_id']=$service_id;
        $data['track_id']=($track_id>0)?$track_id:'';
        $data['track_name']=($track_id>0)?$track_id:'';
        $data['conf']==$conf;
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result;   
    }
     /**
     * [conf_get 获取track对应的配置信息]
     * @param  integer $service_id [Service服务唯一标识]
     * @param  integer $track_id   [Track实时点id]
     * @param  string  $track_name [用户自定义track标识，同一service服务中track的唯一标识]
     * @return [type]              [description]
     */
    public function conf_get($service_id=0,$track_id=0,$track_name=''){
        $_ak=$this->param['ak'];
        $uri=$this->url['conf_get'];
        $data['ak']=$_ak;
        $data['service_id']=$service_id;
        $data['track_id']=($track_id>0)?$track_id:'';
        $data['track_name']=($track_id>0)?$track_id:'';
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result;   
    }
    /**
     * [track_create 创建一个新track或者给track添加最新点]
     * @param  integer $service_id    [description]
     * @param  array   $data          [数据]
     * @param  array   $custom_column [自定义列键值对]
     * @return [type]                 [返回的是本track实时点的track_id，实时点的track_id或者track_name加上其所属服务的service _id可以做track的实时点查找使用]
     * $data=array(
     *     'latitude'=>'',                      //纬度,必选Double(-90.0 , +90.0)
     *     'longitude'=>'',                     //经度,必选Double(-180.0 , +180.0
     *     'coord_type'=>'',                    //坐标类型,必选1：GPS经纬度坐标2：国测局加密经纬度坐标 3：百度加密经纬度坐标。Int(1-3)
     *     'loc_time'=>'',                      //track点采集的GPS时间,必选Unix时间戳
     *     'track_name'=>'',                    //用户自定义的track标识,是track的唯一标识string(0-128),1时代表车辆名称,2时代表设备人员名称,3时代表配送人员名称,4时代表设备人员名称
     *     'direction'=>'',                     //GPS的方向Int(0-360),当service的type是1时才有这个字段
     *     'speed'=>'',                         //GPS的速度double,当service的type是1时才有这个字段
     *     'user_info'=>'',                     //用户自定义信息Int,当service的type是2时才有这个字段
     *     'power'=>'',                         //电量Int,当service的type是2和4时才有这个字段
     *     'dispatch_state'=>'',                //配送状态string,当service的type是3时才有这个字段
     *     'radius'=>'',                        //定位精度double,当service的type是1,2,3,4时才有这个字段
     * );
     * $custom_column=array(
     *     'custom_column_key0'=>'custom_column_value0',
     *     'custom_column_key1'=>'custom_column_value1',
     *     'custom_column_key2'=>'custom_column_value2',
     *     'custom_column_key3'=>'custom_column_value3',
     *     ...
     * );
     */
    public function track_create($service_id=0,$data=array(),$custom_column=array()){
        $_ak=$this->param['ak'];
        $uri=$this->url['track_create'];
        $data['ak']=$_ak;
        $data = array_merge($data,$custom_column);
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result;    
    }

    /**
     * [track_upload 对于一个track批量上传轨迹点]
     * @param  integer $service_id [service_id]
     * @param  string  $file_name  [文件名]
     * @param  string  $track_name [track_name]
     * @return [type]              [实时点id，过程耗时等信息]
     */
    public function track_upload($service_id=0,$track_name=''){
        //$poi_list=$_FILES;
        $_ak=$this->param['ak'];
        $uri=$this->url['track_upload'];
        $data['ak']=$_ak;
        $data['poi_list']=$_FILES;
        $data['track_name']=$track_name;
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result;  
    }
    /**
     * [track_history 通过service _id和track_id（或者track_name）查找本track历史轨迹点的具体信息（包括经纬度，时间，其他用户自定义信息，等）]
     * @param  integer $service_id [service_id]
     * @param  integer $track_id   [Track实时点id与track_name二选一]
     * @param  string  $track_name [Track实时点自定义命名的track name与track_id二选一]
     * @param  integer $start_time [起始时间]
     * @param  integer $end_time   [结束时间（不能超过当前时间）]
     * @return [type]              [description]
     */
    public function track_history($service_id=0,$track_id=0,$track_name='',$start_time=0,$end_time=0){
        $data=$this->param;
        $uri=$this->url['track_upload'];
        $data['service_id']=$service_id;
        $data['track_id']=$track_id;
        $data['track_name']=($track_name>0)?$track_name:'';
        $data['start_time']=($start_time>0)?$start_time:'';
        $data['end_time']=($end_time>0)?$end_time:'';
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result;  
    }
    /**
     * [track_list 根据service_id和track_name列出服务中tracks的实时点集合]
     * @param  integer $service_id [service_id]
     * @param  array   $filter     [过滤条件]
     * @param  array   $attribute  [附加属性,按属性的值进行检索,如果输入多个属性的值,则按多个条件进行联合检]
     * @return [type]              [description]
     * $filter=array(
     *     'track_ids'=>'',        //Track的poi_id,每个track_id以”,”拼接，最多100个(与track_ids字段二选一)
     *     'track_name'=>'',       //Track的poi_id,track_name,”拼接，最多100个(与track_ids字段二选一)
     *     'return_type'=>'',      //返回结果的类型Int,默认为0,代表返回全部结果，1代表只返回track_name的列表
     *     'active_time'=>'',      //活跃时间UNIX时间戳,可选，指定该字段时,返回从该时间点之后仍有位置变动的track的实时点集合   
     * );
     *$attribute=array(
     *     'attribute_key0'=>'attribute_value0',
     *     'attribute_key1'=>'attribute_value1',
     *     'attribute_key2'=>'attribute_value2',
     *     'attribute_key3'=>'attribute_value3',
     *     ...
     * );
     */
    public function track_list($service_id=0,$filter=array(),$attribute=array()){
        $data=$this->param;
        $uri=$this->url['trace_create'];
        $data['service_id']=$service_id;
        $data = array_merge($data,$attribute);
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }
        $_result = $this->curl_post($uri,$temp);
        return $_result;    
    }

    /**
     * [track_detail description]
     * @param  integer $service_id [description]
     * @param  integer $track_id   [description]
     * @return [type]              [description]
     */
    public function track_detail($service_id=0,$track_id=0){
        $data=$this->param;
        $data['service_id']=$id;
        $uri=$this->url['track_detail'].$this->reset_param($data);  
        $_result = $this->_request($uri);
        return $_result;
    }

    /**
     * [track_delete 根据track_id或者track_name删除track]
     * @param  integer $service_id [Trace唯一标识,必选]
     * @param  integer $track_id   [Track实时点 id]
     * @param  string  $track_name [用户自定义命名的track name,可选，与track_id 2选1]
     * @return [type]              [description]
     */
    public function track_delete($service_id=0,$track_id=0,$track_name=''){
        $data=$this->param;
        $uri=$this->url['trace_create'];
        $data['service_id']=$service_id;
        $data['track_id']=($track_id>0)?$track_id:'';
        $data['track_name']=($track_name>0)?$track_name:'';
        $data = array_merge($data,$attribute);
        ksort($data);
        array_filter($data);
        foreach ($data as $k => $v) {
            if(!empty($v)){
                $temp[]=$v;
            }
        }

        $_result = $this->curl_post($uri,$temp);
        return $_result;    
    }

    /**
     * [trace_create 创建鹰眼服务]
     * @param  string  $name [服务名称]
     * @param  string  $desc [服务简介]
     * @param  integer $type [服务类型]
     * @return [type]        [description]
     */
    public function trace_create($name='',$desc ='',$type=0){
    	$type=$this->type($type);	//重置服务类型
    	$_ak=$this->param['ak'];
		$uri=$this->url['trace_create'];
    	$data['ak']=$_ak;
    	$data['name']=$name;
    	$data['desc']=$desc;
    	$data = array_merge($data,$type);
    	ksort($data);

    	$_result = $this->curl_post($uri,$data);
    	return $_result;	
    }
    /**
     * [trace_update 更新鹰眼服务]
     * @param  string  $name [description]
     * @param  string  $desc [description]
     * @param  integer $type [description]
     * @return [type]        [description]
     */
    public function trace_update($name='',$desc ='',$type=0){
    	$type=$this->type($type);	//重置服务类型
    	$_ak=$this->param['ak'];
		$uri=$this->url['trace_update'];
    	$data['ak']=$_ak;
    	$data['name']=$name;
    	$data['desc']=$desc;
    	$data = array_merge($data,$type);
    	ksort($data);
    	$_result = $this->curl_post($uri,$data);
    	return $_result;	
    }

    /**
     * [trace_addColumn 添加鹰眼服务列]
     * @param  string  $column_name [description]
     * @param  string  $column_key [description]
     * @param  integer $type [description]
     * @param  integer $max_length [description]
     * @param  integer $default_value [description]
     * @return [type]        [description]
     */
    public function trace_addColumn($column_name='',$column_key ='',$column_type=1,$max_length=0,$default_value=0){
        $type=$this->column_type($column_type);   //重置服务类型
        $_ak=$this->param['ak'];
        $uri=$this->url['trace_addColumn'];
        $data['column_key']=$column_key;
        $data['column_name']=$column_name;
        $data['column_type']=$column_type;
        $data['max_length']=$max_length;
        $data['default_value']=$default_value;
        $data = array_merge($data,$type);
        ksort($data);
        $_result = $this->curl_post($uri,$data);
        return $_result;    
    }

    /**
     * [trace_updateColumn 更新属性]
     * @param  string  $column_name [description]
     * @param  string  $column_key [description]
     * @param  integer $type [description]
     * @param  integer $max_length [description]
     * @param  integer $default_value [description]
     * @return [type]        [description]
     */
    public function trace_updateColumn($column_id='',$service_id ='',$column_name='',$default_value='',$max_length=50){
        $_ak=$this->param['ak'];
        $uri=$this->url['trace_updateColumn'];
        $data['column_id']=$column_id;
        $data['service_id']=$service_id;
        $data['column_name']=$column_name;
        $data['default_value']=$default_value;
        $data['max_length']=$max_length;
        $data = array_merge($data,$type);
        ksort($data);
        $_result = $this->curl_post($uri,$data);
        return $_result;    
    }

    /**
     * [trace_delColumn 删除鹰眼服务列]
     * @param  integer  $service_id [description]
     * @param  integer  $column_id [description]
     * @return [type]        [description]
     */
    public function trace_delColumn($service_id=0,$column_id =0){ 
        $uri=$this->url['trace_delColumn'];
        $data['ak']=$this->param['ak'];
        $data['service_id']=$service_id;
        $data['column_id']=$column_id;
        $data = array_merge($data,$type);
        ksort($data);
        $_result = $this->curl_post($uri,$data);
        return $_result;    
    }

    /**
     * [trace_delete 删除鹰眼服务]
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function trace_delete($id=0){
    	$_ak=$this->param['ak'];
		$uri=$this->url['trace_delete'];
    	$data['ak']=$_ak;
    	$data['service_id']=$id;	
    	$_result = $this->curl_post($uri,$data);
    	return $_result;
    }

    /**
     * [trace_detail 显示鹰眼服务信息]
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function trace_detail($id=0){
    	$data=$this->param;
    	$data['service_id']=$id;
    	$uri=$this->url['trace_detail'].$this->reset_param($data);	
    	$_result = $this->_request($uri);
    	return $_result;
    }

    /**
     * [trace_list 列出鹰眼服务]
     * @param  integer $id [description]
     * @param  integer $name [Trace的name中包含的关键字]                    
     * @return [type]      [description]
     */
    public function trace_list($name=''){
    	$data=$this->param;
    	$data['name']=$name;	
		$uri=$this->url['trace_list'].$this->reset_param($data);
        
    	$_result = $this->_request($uri);
    	return $_result;
    }
    /**
     * [column_type 设置栏目类型]
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    private function column_type($type=1){
        $_data=array(
            '1'=>'Int64', 
            '2'=>'double', 
            '3'=>'string', 
            '4'=>'在线图片url'
        );
        return $_data[$type];
    }

    /**
     * [reset 重置GET参数]
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    private function reset_param($param){
    	foreach ($param as $k => $v) {
    		if(!empty($v))
              $_result .='&'.$k.'='.$v;
        } 
        return $_result;
    }
    /**
     * [type 获取服务类型]
     * [默认：其他行业(0)]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    private function type($type){
    	$_data = array(
    		'其他行业',
    		'车辆管理行业',
    		'MTK位置穿戴',
    		'O2O配送行业',
    		'位置智能穿戴'
    		);
    	if (is_numeric($type)) {
    		$_result['type']=$type;
    	}else{
    		foreach ($_data as $k => $v) {
    			if ($v==$type) {
    				$_result['type']=$k;
    			}else{
    				$_result['type']=0;
    			}
    		}
    	}
    	return $_result;
    }

    /**
     * [status 返回状态信息]
     * @param  [type] $code [状态码]
     * @return [type]       [description]
     */
    private function status($code){
    	$data=array(
    		'0'=>'成功',
			'1'=>'服务器内部错误',
			'2'=>'参数错误',
			'3'=>'http method错误',
			'21'=>'此操作为批量操作', 
			'22'=>'同步到检索失败',
			'31'=>'服务端加锁失败', 
			'32'=>'服务端释放锁失败',
			'1001'=>'表的name重复',
			'1002'=>'表的数量达到了最大值', 
			'1003'=>'表中存在poi数据，不允许删除', 
			'2001'=>'列的key重复',
			'2002'=>'列的key是保留字段', 
			'2003'=>'列的数量达到了最大值',
			'2004'=>'唯一索引只能创建一个',
			'2005'=>'更新为唯一索引失败，原poi数据中有重复', 
			'2006'=>'创建唯一索引失败，原POI数据中该字段为null' ,
			'2011'=>'排序筛选字段只能用于整数或小数类型的列', 
			'2012'=>'排序筛选的列已经达到了最大值 ',
			'2021'=>'检索字段只能用于字符串类型的列且最大长度不能超过512个字节', 
			'2022'=>'检索的列已经达到了最大值', 
			'2031'=>'索引的列已经达到了最大值', 
			'2041'=>'指定的列不存在 ',
			'2042'=>'修改max_length必须比原值大',
			'3001'=>'更新坐标必须包含经纬度和类型', 
			'3002'=>'唯一索引字段存在重复',
			'3003'=>'指定POI不存在', 
			'3031'=>'上传的文件太大', 
			'4001'=>'追踪服务的name重复', 
			'4002'=>'追踪服务的数量达到了最大值', 
			'4003'=>'追踪服务中存在poi数据，不允许删除', 
			'4004'=>'指定追踪服务中不包含指定轨迹ID', 
			'4005'=>'指定追踪服务不存在',
			'6001'=>'指定的relation不存在', 
			'7001'=>'属性名称重复',
			'7002'=>'指定的属性不存在', 
			'7003'=>'唯一检索的属性不能批量赋值 ',
			'7004'=>'允许添加的属性数量达到了最大值', 
			'7005'=>'允许添加的可检索属性数量达到了最大值', 
			'7006'=>'该属性不是可检索属性', 
			'7007'=>'上传的属性文件大小超过限制'
    		); 
		$_result=!empty($data[$code])?$data[$code]:'未知错误';
		return $_result;
    }

    /**
     * [_REQUEST 请求操作]
     * @param  [type] $url  [请求地址]
     * @param  [type] $data [请求数据]
     * @param  string $type [请求类型]
     * @return [type]       [description]
     */
    private function _request($url,$data,$post=0){
		  $curl = curl_init(); // 启动一个CURL会话
	      curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
	      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
	      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
	      curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
	      //curl_setopt($ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
	      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
	      curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
	      if($post){
	          curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
	          if (!empty($data)){
	              curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
	              curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS['cookie_file']); // 读取上面所储存的Cookie信息      
	          }
	      }
	      curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
	      curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
	      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
	      $tmpInfo = curl_exec($curl); // 执行操作
	      curl_close($curl); // 关闭CURL会话 
	   	 
    	  return json_decode($tmpInfo,true); // 返回数据
    }

    /**
     * [curl_post post提交]
     * @param  [type] $url  [提交地址]
     * @param  [type] $data [提交数据]
     * @return [type]       [description]
     */
    private function curl_post($url,$data){ // 模拟提交数据函数      
        $curl = curl_init(); // 启动一个CURL会话      
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址                  
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查      
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在      
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器      
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转      
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer      
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求      
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包      
        curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS['cookie_file']); // 读取上面所储存的Cookie信息      
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环      
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容      
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回      
        $tmpInfo = curl_exec($curl); // 执行操作      
        if (curl_errno($curl)) {      
           echo 'Errno'.curl_error($curl);      
        }      
        curl_close($curl); // 关键CURL会话  

        return json_decode($tmpInfo,true); // 返回数据      
    }
}