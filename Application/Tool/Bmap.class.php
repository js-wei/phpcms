<?php
namespace Classes;

class Bmap{
	private $url=array(
		'geocoding'=>'http://api.map.baidu.com/telematics/v3/geocoding?',
		'reverseGeocoding'=>'http://api.map.baidu.com/telematics/v3/reverseGeocoding?',
		'point'=>'http://api.map.baidu.com/telematics/v3/point?',
		'local'=>'http://api.map.baidu.com/telematics/v3/local?',
		'navigation'=>'http://api.map.baidu.com/telematics/v3/navigation?',
		'distance'=>'http://api.map.baidu.com/telematics/v3/distance?',
		'weather'=>'http://api.map.baidu.com/telematics/v3/weather?',
		'trafficEvent'=>'http://api.map.baidu.com/telematics/v3/trafficEvent?',
		'viaPath'=>'http://api.map.baidu.com/telematics/v3/viaPath?',
		'travel_city'=>'http://api.map.baidu.com/telematics/v3/travel_city?',
		'travel_attractions'=>'http://api.map.baidu.com/telematics/v3/travel_attractions?',
		'hot_movie'=>'http://api.map.baidu.com/telematics/v3/movie?qt=hot_movie&',
        'search_movie'=>'http://api.map.baidu.com/telematics/v3/movie?qt=search_movie&',
        'search_cinema'=>'http://api.map.baidu.com/telematics/v3/movie?qt=search_cinema&',
        'nearby_cinema'=>'http://api.map.baidu.com/telematics/v3/movie?qt=nearby_cinema&',
        'direction'=>'http://api.map.baidu.com/direction/v1?',
        'suggestion'=>'http://api.map.baidu.com/place/v2/suggestion?',
        'place'=>array(
            'search'=>'http://api.map.baidu.com/place/v2/search?',
            'detail'=>'http://api.map.baidu.com/place/v2/detail?',
            'eventsearch'=>'http://api.map.baidu.com/place/v2/eventsearch?',
            'eventdetail'=>'http://api.map.baidu.com/place/v2/eventdetail?',
            ),
		);
	private $param;		//参数
	/**
	 * [__construct 构造函数]
	 */
	public function __construct(){
        $conf=C('Bmap');
        ksort($conf);
        foreach ($conf as $k => $v) {
           if(!empty($v))
              $this->param.='&'.$k.'='.$v;
        } 
        
    }

    /**
     * 1、place_sea(array('query'=>'农行','region'=>'苏州'))
     * 2、place_search('农行|苏州',1);
     * 3、place_search('农行',0,'苏州');
     * [place_search 获取到POI信息]
     * @param  [type]  $query    [description]
     * @param  integer $page_num [当前页]
     * @param  [type]  $location [坐标、地点、城市代码]
     * @param  int  $type        [区域类型0、地点,1、radius,2、bounds。bounds lat：lng(左下角坐标),lat,lng(右上角坐标)，radius(r)lat<纬度>,lng<经度>+周边检索半径，单位为米]
     * @param  integer $radius   [圆形范围的半径]
     * @param  integer $scope    [POI信息显示程度:1简单,2详细]
     * @return [type]            [description]
     */
    public function place_search($query,$page_num=0,$location='',$type=0,$filter='',$radius=1000,$scope=2){
        $_location=$this->_param($query,2);
        $_type=$this->_place_type($type,$location,$radius);
        $filter=!empty($filter)?'&filter='.$filter:'';
        $url=$this->url['place']['search'].$_location.$_type.'&page_num='.$page_num.'&scope='.$scope.$filter.$this->param; 
        
        $data=$this->_get($url);
        $data['note']='注释:name poi名称,location poi经纬度坐标,address poi地址信息,street_id街区号,telephone poi电话信息,
        uid poi的唯一标示:detail_infopoi的扩展信息,distance距离中心点的距离,type所属分类,tag标签,detail_url poi的详情页,
        price poi商户的价格,shop_hours营业时间,overall_rating总体评分,taste_rating,service_rating服务评分,environment_rating环境评分,
        facility_rating星级（设备）评分,hygiene_rating卫生评分,technology_rating技术评分,image_num图片数,groupon_num,团购数,
        discount_num优惠数m,comment_num评论数,favorite_num收藏数,checkin_num签到数';
        $data['msg']=$this->_msg($data['status']);
        $data['pageCount']=ceil($data['total']/C('Bmap.page_size'));
        $data['page_num']=++$page_num;
        ksort($data);
        return $data;
    }
    /**
     * [place_detail POI详细信息]
     * @param  [type]  $uid   [PIO信息uid]
     * @param  integer $scope [description]
     * @return [type]         [description]
     */
    public function place_detail($uid,$scope=2){
        $filter=$this->_map_filter();
        p($filter);die;
        $url=$this->url['place']['detail'].'uid='.$uid.'&scope='.$scope.$this->param; 
        
        $data=$this->_get($url);
        $data['note']='注释:detail_url poi的详情页,
        price poi商户的价格,shop_hours营业时间,overall_rating总体评分,taste_rating,service_rating服务评分,environment_rating环境评分,
        facility_rating星级（设备）评分,hygiene_rating卫生评分,technology_rating技术评分,image_num图片数,groupon_num,团购数,
        discount_num优惠数m,comment_num评论数,favorite_num收藏数,checkin_num签到数,featured_service特色服务';
        $data['msg']=$this->_msg($data['status']);
        ksort($data);
        return $data;
    }

    /**
     * 检索过滤条件，当scope取值为2时，可以设置filter进行排序。
     * industry_type：行业类型注意：设置该字段可提高检索速度和过滤精度。
     * industry_type取值如下：hotel:宾馆、cater:餐饮、life:生活娱乐
     * sort_name：排序字取值根据industry_type字段的值而定。
     * (1)industry_type为hotel时，
     * sort_name取值：default:默认；
     *     price:价格
     *     total_score:好评
     *     level：星级
     *     health_score：卫生
     *     distance:距离排序，只有周边检索有效
     * (2)industry_type取值cater时，
     * sort_name取值：default：默认
     *     taste_rating：口味
     *     price：价格
     *     overall_rating：好评
     *     service_rating：服务
     *     distance:距离排序，只有周边检索有
     * (3)industry_type取值life时，
     * sort_name取值：default：默认
     *     price：价格
     *     overall_rating：好评
     *     comment_num：服务
     *     distance：距离排序，只有周边检索有
     * sort_rule：排序规则，取值如下：
     *     0：从高到低，1：从低到高；
     *price_section：价格区间；
     *groupon：是否有团购，1为有团购，0为无团购；
     *discount：是否打折，1为有打折，0为无打折；
     * @return [type] [description]
     */
   /* private function _filter($filter='宾馆|价格,200-300'){
        'industry_type': //行业
        'sort_name':    //排序字段

    }*/

    private function _map_filter($filter='宾馆|价格,200-300'){
        $mapping_sort=array(
              '好评'=>'total_score',
              '星级'=>'level',
              '卫生'=>'health_score',
              '距离'=>'distance',
              '口味'=>'taste_rating',
              '服务'=>'service_rating',
              '好评'=>'overall_rating',
              '价格'=>'price_section',
              '是否有团购'=>'groupon',
            );
        $mapping_type=array(
              '宾馆'=>'hotel',
              '餐饮'=>'cater',
              '生活'=>'life',
              '娱乐'=>'life',
              '生活娱乐'=>'life',
            );
        $_mapping='';
        if(!is_array($filter)){
            $_filter=explode('|', $filter);
            $price=explode(',', $_filter[1]);
            $_mapping='&industry_type='.$mapping_type[$_filter[0]].'&'.$mapping_sort[$price[0]].'='.$price[1];

        }else{
            foreach ($filter as $k => $v) {
                $_mapping.='&'.$k.'='.$v;
            }
        }
       
        return $_mapping;
    }
    /**
     * [_place_type 制造查询区域类型]
     * @param  [type]  $type     [类型]
     * @param  [type]  $location [坐标、地点、城市代码]
     * @param  integer $radius   [圆形范围的半径]
     * @return [type]            [description]
     */
    private function _place_type($type,$location,$radius=1000){
        if(!empty($location)){
            switch ($type) {
                case 1:
                    return '&location='.$this->_point($location).'&radius='.$radius;
                    break;
                case 2:
                    return '&bounds='.$this->_point($location);
                    break;
                 default:
                    return '&region='.urlencode($this->_point($location));
            }
        }
    }
    /**
     * array('query'=>'酒店','region'=>'苏州')
     * [suggestion 智能提示]
     * @param  string $query  [description]
     * @param  string $origin [description]
     * @return [type]         [description]
     */
    public function suggestion($query){
        $location=$this->_param($query,$type=0);
       
        $url=$this->url['suggestion'].$location.$this->param;
        $data=$this->_get($url);
        $data['note']='注释:name名称,city城市,district区县,business商圈,cityid城市代码';
        $data['msg']=$this->_msg($data['status']);
        ksort($data);
        return $data;
    }

    /**
     * array(
     *     'mode'=>'transit',           //导航模式，包括：driving（驾车）、walking（步行）、transit（公交）
     *     'origin'=>'清华大学',
     *     'destination'=>'北京大学',
     *     'origin_region'=>'北京',
     *     'destination_region'=>'北京',
     *     'tactics'=>11               //导航策略。导航路线类型，10，不走高速；11、最少时间；12、最短路径。
     * )
     * [direction description]
     * @param  [type] $location [description]
     * @return [type]           [description]
     */
    public function direction($location,$tactics=0,$mode=0){
        $location=$this->_param($location);
       
        $url=$this->url['direction'].$location.'&mode='.$this->mode($mode).'&tactics='.$this->tactics($tactics).'&output=json&ak=tOVGEEQswsdKWlWVjPZci6W7';
        //p($url);die;
        $data=$this->_get($url);
        $data['msg']=$this->_msg($data['status']);
        $data['type']=($data['type']==2)?'起终点都明确':'起终点模糊';
        $data['note']='注释:route:线路,origin起点信息,destination终点信息,taxi出租信息;scheme线路计划;arrive_time到达时间,distance方案距离(米),
        duration线路耗时(秒);steps线路具体方案-path路段位置坐标描述,type路段类型,stepOriginLocation路段起点坐标,stepDestinationLocation路段终点坐标,
        stepInstruction路段说明,vehicle车辆信息-start_name公交线路起点名称,end_name公交线路的末班车时间,end_time末班车时间,end_uid公交线路终点id,
        name公交线路名称,start_time首班车时间,start_uid,公交线路起点id,stop_num路段经过的站点数量,total_price价格,type公交线路类型,uid公交线路id,zone_price区间价';
        $data['info']=$data['info']['copyright'];       
        ksort($data);
        return $data;
    }
   
    /**
     * [nearby_cinema 周边影院查询]
     * @param  [type] $location [description]
     * @return [type]           [description]
     */
    public function nearby_cinema($location,$pn=1,$rn=10,$radius=300){
        $location=$this->_point($location);
        $url=$this->url['nearby_cinema'].'location='.$location.'&radius='.$radius.'&pn='.$pn.'&rn='.$rn.$this->param;
        $data=$this->_get($url);
        $data['msg']=$this->_msg($data['error']);
        ksort($data);
        return $data;
    }


    /**
     * array(
     *     'wd'=>'万达',
     *     'location'=>苏州
     * )
     * [search_cinema 影院影讯]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function search_cinema($key){
        $p=$this->_param($key);
        $url=$this->url['search_cinema'].$p.$this->param;
        $data=$this->_get($url);
        
        $data['msg']=$this->_msg($data['error']);
        ksort($data);
        return $data;
    }


    /**
     * array(
     *     'wd'=>'冰雪奇缘',
     *     'location'=>'北京'
     * )
     * [search_movie 影片搜素]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function search_movie($key){
        $p=$this->_param($key);
        $url=$this->url['search_movie'].$p.$this->param;
        $data=$this->_get($url);
        //$data['note']='现在显示'.$cityName.'旅游信息';
        
        $data['msg']=$this->_msg($data['error']);
        ksort($data);
        return $data;

    }



    /**
     * [hot_movie description]
     * @param  [type] $cityName [description]
     * @return [type]           [description]
     */
    public function hot_movie($cityName='苏州'){
        $location=$this->_point($cityName);
        $url=$this->url['hot_movie'].'location='.urlencode($location).$this->param;
        $data=$this->_get($url);
        //$data['note']='现在显示'.$cityName.'旅游信息';
        $data['cityid']=$data['result']['cityid'];
        $data['cityname']=$data['result']['cityname'];
        $data['location']=$data['result']['location'];
        $data['result']=$data['result']['movie'];
        $data['msg']=$this->_msg($data['error']);
        ksort($data);
        return $data;
    }


    /**
     * $poi=array(
     *     'keyWord'=>'山塘街',
     *     'cityName'=>'苏州'
     * )
     * '山塘街|苏州'
     * [point 获取POI点]
     * @return [type] [description]
     */
    public function point($poi=array('keyWord'=>'山塘街','cityName'=>'苏州'),$page=1,$tag=''){
        $tag=!empty($tag)?'&tag='.urlencode($tag):'';
        $poi=$this->_param($poi);
        $url=$this->url['point'].$poi.'&page='.$page.$tag.$this->param;
        $data=$this->_get($url);
       
        //$data['note']='现在显示'.$cityName.'旅游信息';
        $data['page']=$page;
        $data['msg']=$this->_msg($data['error']);
        ksort($data);
        return $data;
    }

  

    /**
     * [travel_attractions 查询景点详情]
     * @param  [type] $id     [poiId]
     * @return [type]         [description]
     */
    public function travel_attractions($id=10){
        $location=$this->_point($cityName);
        $url=$this->url['travel_attractions'].'id='.urlencode($location).$this->param;
        $data=$this->_get($url);
        //$data['note']='现在显示'.$cityName.'旅游信息';
       
        $data['msg']=$this->_msg($data['error']);
        ksort($data);
        return $data;
    }

    /**
     * $cityName=array(
     * 		'cityName'=>'北京'
     * )
     * [trafficEvent description]
     * @param  [type] $cityName [description]
     * @return [type]           [description]
     */
    public function travel_city($cityName='北京'){
    	$location=$this->_point($cityName);
    	$url=$this->url['travel_city'].'location='.urlencode($location).$this->param;
    	$data=$this->_get($url);
        //$data['note']='现在显示'.$cityName.'旅游信息';
        $data['cityid']=$data['result']['cityid'];
        $data['cityname']=$data['result']['cityname'];
        $data['location']=$data['result']['location'];
        $data['star']=$data['result']['star'];
        $data['url']=$data['result']['url'];
        $data['abstract']=$data['result']['abstract'];
        $data['description']=$data['result']['description'];
        $data['result']=$data['result']['itineraries'];
        $data['msg']=$this->_msg($data['error']);
    	ksort($data);
    	return $data;
    }

    
    /**
     * $cityName=array(
     * 		'cityName'=>'北京'
     * )
     * [trafficEvent description]
     * @param  [type] $cityName [description]
     * @return [type]           [description]
     */
    public function trafficEvent($cityName='北京'){
    	$location=$this->_point($cityName);
    	$url=$this->url['trafficEvent'].'location='.urlencode($location).$this->param;
    	$data=$this->_get($url);
    	ksort($data);
    	return $data;
    }


    /**
     * array(
     * 	'location'=>'116.305145,39.982368',
     * 	'keyWord'=>'酒店' 
     * )
     * [local description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function local($key,$index=1,$radius=500){
    	if(!empty($key) && is_array($key)){
    		foreach ($key as $k => $v) {
    			if(!empty($v) && !is_array($v)){
					$t.='&'.$k.'='.urlencode($v);
    			}else{
    				$t.='&'.$k.'='.$this->_point($v);
    			}
    		}
    	}

    	$url=$this->url['local'].$t.'&radius='.$radius.'&page='.$index.'&sort_rule=0'.$this->param;
    	
    	$data=$this->_get($url);
    	$data['pageCount']=ceil($data['total']/C('Bmap.number'));
    	ksort($data);
    	return $data;
    }


    /**
     * $location=array(
     * 	'origin'=>'116.3017193083,40.050743859593',
     * 	'destination'=>'116.37145906414,40.102914916569'
     * );
     * [viaPath 沿途路段查询]
     * @param  [type] $location [description]
     * @return [type]           [description]
     */
    public function viaPath($location){
		if(!empty($location) && is_array($location)){
    		foreach ($location as $k => $v) {
    			if(!empty($v)){
					$t.='&'.$k.'='.urlencode($v);
    			}
    		}
    	}
    	$url=$this->url['viaPath'].$t.$this->param;

    	$data=$this->_get($url);
    	foreach ($data['results']['landMark'] as  $v) {
    		$v['type']=$this->_type($v['type']);
    		$landMark[]=$v;		//landMark途径地标
    	}

    	foreach ($data['results']['trafficLight'] as  $v) {
    		$v['type']=$this->_type($v['type']);
    		$trafficLight[]=$v;		//trafficLight红绿灯
    	}

    	foreach ($data['results']['mainRoad'] as  $v) {
    		$v['type']=$this->_type($v['type']);
    		$mainRoad[]=$v;		//mainRoad主要路段
    	}

    	foreach ($data['results']['serviceArea'] as  $v) {
    		$v['type']=$this->_type($v['type']);
    		$serviceArea[]=$v;		//serviceArea服务区
    	}

    	foreach ($data['results']['carPark'] as  $v) {
    		$v['type']=$this->_type($v['type']);
    		$carPark[]=$v;		//carPark终点停车场
    	}
    	foreach ($data['results']['tollStation'] as  $v) {
    		$v['type']=$this->_type($v['type']);
    		$tollStation[]=$v;		//tollStation收费站
    	}

    	foreach ($data['results']['gasStation'] as  $v) {
    		$v['type']=$this->_type($v['type']);
    		$gasStation[]=$v;		//gasStation加油站
    	}

    	foreach ($data['results']['camera'] as  $v) {
    		$v['type']=$this->_type($v['type']);
    		$camera[]=$v;		//camera摄像头
    	}

    	foreach ($data['results']['entrance'] as  $v) {
    		$v['type']=$this->_type($v['type']);
    		$entrance[]=$v;		//entrance道路出入口
    	}

    	$data=array(
    		'location'=>$location,
    		'note'=>'mainRoad主要路段 entrance道路出入口 landMark途径地标 tollStation收费站 trafficLight红绿灯 serviceArea服务区 gasStation加油站 camera摄像头 other其他 carPark终点停车场',
    		'landMark'=>!empty($landMark)?$landMark:'暂无数据',
    		'trafficLight'=>!empty($trafficLight)?$trafficLight:'暂无数据',
    		'mainRoad'=>!empty($mainRoad)?$mainRoad:'暂无数据',
    		'serviceArea'=>!empty($serviceArea)?$serviceArea:'暂无数据',
    		'carPark'=>!empty($carPark)?$carPark:'暂无数据',
    		'tollStation'=>!empty($tollStation)?$tollStation:'暂无数据',
    		'gasStation'=>!empty($gasStation)?$gasStation:'暂无数据',
    		'camera'=>!empty($camera)?$camera:'暂无数据',
    		'entrance'=>!empty($entrance)?$entrance:'暂无数据',
    		);
    	
    	return $data;
    }

    /**
     * $navigation =array(
     *       'origin' =>'天安门',
     *       'destination' =>'西单',
     *       'region'=>'北京',
     *       'origin_region'=>'',
     *       'destination_region'=>''
     *       
     *  )
     * [navigation description]
     * @param  [type] $location [起讫点：origin起点,destination讫点,region同城查询必须,origin_region、destination_region跨区域查询必填(region和origin_region、destination_region互斥，二者只能存在一个)]
     * @param  [type] $type [类型:0最短时间,1最短路程,2不走高速]
     * @return [type]           [description]
     * 
     */
    public function navigation($navigation,$type=0){
    	if(!empty($navigation) && is_array($navigation)){
    		
    		foreach ($navigation as $k => $v) {
    			if(!empty($v)){
					$t.='&'.$k.'='.urlencode($v);
    			}
    		}
    		
    	}else{
    		exit('请输入正确的参数');
    	}

		$route=$type?'&route_type='.$type:'&route_type=0';
    	$url=$this->url['navigation'].$t.$route.$this->param;

    	$data=$this->_get($url);
    	$data['note']='注释:returnType:返回类型19多点选择;20直接驾车路线,distance:约距离'.(ceil($data['results'][0]['distance']/1000)).'千米,duration:约耗时'.(ceil($data['results'][0]['duration']/3600)).'小时,pois:pois信息点,';
    	ksort($data);
    	return $data;
    }


    /**
     * [location] => Array(
     *       [lng] => 116.3017193083
     *       [lat] => 40.050743859593
     *  )
     * [reverseGeocoding 反地理解析]
     * @param  [type] $location [description]
     * @return [type]           [description]
     * 
     */
    public function reverseGeocoding($location){

    	if(!empty($location) && is_array($location)){
    		$location=implode(',', $location);
    	}

    	$url=$this->url['reverseGeocoding'].'&location='.$location.$this->param;
    	$data=$this->_get($url);
    	$data['note']='注释:city:城市,description:地点描述,district:所在街区的名称,province:省区名称,street:街道名称,street_number:街区/门牌号,distance:距离(数字愈小愈精确)';
    	$data['point']=$location;
    	ksort($data);
    	return $data;
    }

    /**
     * [geocoding 地理解析]
     * @param  array  $location [description]
     * @return [type]           [description]
     */
    public function geocoding($location=array('keyWord'=>'北京市上地十街十号百度大厦','cityName'=>'北京')){

    	if(!empty($location) && is_array($location)){
    		foreach ($location as $k => $v) {
    			if(is_numeric($k)){
					$t.='&'.$k.'='.urlencode($v);
    			}
    		}
    	}else{

    		$querystring=explode('|',$location);
    		$t='&keyWord='.urlencode($querystring[0]).'&cityName='.urlencode($querystring[1]);
    		
    	}

    	$url=$this->url['geocoding'].$t.$this->param;

    	$data=$this->_get($url);
    	$temp['address']=is_array($location)?($location['keyWord'].'|'.$location['cityName']):$location;
    	$temp['precise']=$data['results']['precise']?'比较精准':'不够精准';
    	$temp['location']=$data['results']['location'];
    	return $temp;
    }


    /**
     * [weather 获取天气信息]
     * @param  array  $location [description]
     * @return [type]           [description]
     */
    public function weather($location=array('徐州','苏州')){

    	if(!empty($location) && is_array($location)){
    		foreach ($location as  $v) {
    			$t.=$v.'|';
    		}
    		$location=substr($t,0,-1);
    	}else if(strstr('|',$location)){
            $location=$location;
        }else{
            exit('参数错误');
        }
    
    	$url=$this->url['weather'].'location='.urlencode($location).$this->param;
    	$data=$this->_get($url);
    	
    	return $data;
    }

    /**
    * 导航模式，包括：driving（驾车）、walking（步行）
    * [mode 导航模式]
    * @param  integer $type [description]
    * @return [type]        [description]
    */
    private function mode($type=0){
        $mode=array('transit','walking');
        return $mode[$type];
    }
    /**
     * 导航路线类型，10，不走高速；11、最少时间；12、最短路径。
     * [tactics 导航路线类型]
     * @param  integer $type [description]
     * @return [type]        [description]
     */
    private function tactics($type=0){
        $tactics=array(11,12);
        return $tactics[$type];
    }

    /**
     * [_param 参数制造]
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    private function _param($param,$type=1){
        $_key='';
        if(!empty($param) && is_array($param)){
            foreach ($param as $k => $v) {
               $t.='&'.$k.'='.urlencode($v);
               //$t.='&'.$k.'='.$v;
            }
            $_key=$t;
        }elseif(!empty($param) && strstr($param,'|') && $type==1){
            $temp=explode('|',$param);

            $_key= '&keyWord='.urlencode($temp[0]).'&cityName='.urlencode($temp[1]);
        }elseif(!empty($param) && strstr($param,'|') && $type==0){
            $temp=explode('|',$param);

            $_key= '&query='.urlencode($temp[0]).'&region='.urlencode($temp[1]);
        }elseif(!empty($param) &&  $type==2){
            $temp=explode('|',$param);
            if(count($temp)>=2){
                $_key= '&query='.urlencode($temp[0]).'&region='.urlencode($temp[1]);
            }else{
                $_key= '&query='.urlencode($temp[0]);
            }
            
        }else{
            $_key=$param;
        }
        return $_key;
    }

    /**
     * [_msg 获取状态码]
     * @param  [type] $code [状态码]
     * @return [type]       [description]
     */
    private function _msg($code){
       $msg=array(
            '0'=>   '正常/成功', 
            '2'=>   '请求参数非法', 
            '3'=>   '权限校验失败',  
            '4'=>   '配额校验失败',  
            '5'=>   'ak不存在或者非法/配额校验失败',  
            '2xx'=> '无权限', 
            '3xx'=> '配额错误',    
            '-1'=>  '服务器错误',  
            '-2'=>  '参数错误',  
            '-3'=>  '无结果', 
            '-4'=>  'uid过期',   
            '-5'=>  '未知错误',     
            '-6'=>  '参数不完整',   
            '201'=> '参数错误',     
            '401'=> '无返回结果',    
            '500'=> '未知错误',
        );

       foreach ($msg as $k => $v) {
           if(strlen($code)==3 && (substr($code,0,1)=='2' || substr($code,0,1)=='3')){
                if(substr($code,0,1)=='2')
                    return $msg['2xx'];
                else
                    return $msg['3xx'];
           }else{
                return $msg[$code];
           }
       }
    }

    /**
     * [_point 装换坐标]
     * @param  [type] $location [坐标点]
     * @return [type]           [description]
     */
    private function _point($location){
    	if(is_array($location))
    		return $location['lng'].','.$location['lat'];
    	else
    		return $location;
    }
    /**
     * [_type 获取信息类型]
     * @param  [type] $_type [数字代码]
     * @return [type]        [description]
     */
    private function _type($_type){
    	$type=array(
    			//道路
    			'未知'=> 	0,
    			'环岛'=> 	1,
    			'无属性道路'=> 	2,
    			'主路'=> 	3,
    			'高速连接路'=> 	4,
    			'交叉点内路段'=> 	5,
    			'连接道路'=> 	6,	
    			'停车场内部道路'=> 	7,
    			'服务区内部道路'=> 	8,
    			'桥'=> 	9,
    			'步行街'=> 	10,
				'辅路'=> 	11,
				'匝道'=> 	12,
				'全封闭道路'=> 	13,
				'未定义交通区域'=> 	14,
				'POI连接路'=> 	15,
				'隧道'=> 	16,
				'步行道'=> 	17,
				'公交专用道'=> 	18,
				'提前右转道'=> 	19, 
				//POI
				'桥'=> 					100,
				'收费站'=> 				101,
				'服务区，停车场'=> 		102,
				'加油站'=> 				103,
				'百货商城'=> 			104,
				'电器商场'=> 			105,
				'大厦'=> 				106,
				'五星级酒店'=> 			107,
				'超市'=> 				108,
				'快餐'=> 				109,
				'广场'=> 				110,
				'会议中心，展览中心'=> 	111,
				'学校（大专院校）'=> 	112,
				'村屯、风景名胜'=> 		113, 
				//摄像头
				'限速摄像头'=> 	200,
				'交通信号灯摄像头'=> 	201,
				'路况监控摄像头'=> 	202,
				'雷达测速摄像头'=> 	203,
				'单行线摄像头'=> 	204,
				'非机动车道摄像头'=> 	205,
				'高速/城市高速出入口摄像头'=> 	206,
				'公交车道摄像头'=> 	207,
				'移动式测速'=> 	209,
				'禁止左转摄像头'=> 	210,
				'禁止右转摄像头'=> 	211,
				'其他'=> 	214, 
				'主要路段'=>'300-349',
				'红绿灯'    =>'350-399',
				'道路出入口' =>400,
				'终点停车场' =>	999 

    		);

		foreach ($type as $k => $v) {
			if(strstr('-',$v)){
				$temp=explode('-', $v);
				if($_type>$temp[0] && $_type<$temp[1]){
					return getKey($type,$v);
				}
			}else{
				if($_type==$v){
					return getKey($type,$v);
				}
			}
		}
    }

    /**
     * [_sn 组合snkey]
     * @param  [type] $querystring_arrays [description]
     * @param  [type] $url                [description]
     * @return [type]                     [description]
     */
    private function _sn($querystring_arrays,$url){
    	
		$cong=C('Bmap');
		$cong=array_merge($cong,$querystring_arrays);
		 
		//调用sn计算函数，默认get请求
		$sn = $this->caculateAKSN(C('Bmap.ak'), C('Bmap.sk'),$uri,$cong);
		return  $sn;  //输出计算得到的sn
			
    }
    /**
     * [caculateAKSN 制造snkey]
     * @param  [type] $ak                 [description]
     * @param  [type] $sk                 [description]
     * @param  [type] $url                [description]
     * @param  [type] $querystring_arrays [description]
     * @param  string $method             [description]
     * @return [type]                     [description]
     */
    private function caculateAKSN($ak,$sk, $url,$querystring_arrays, $method = 'GET'){  

	    if ($method === 'POST'){  
	        ksort($querystring_arrays);  
	    }  
	    $querystring = http_build_query($querystring_arrays);  
	    return md5(urlencode($url.$querystring.$sk));  
	}



    /**
     * [_get 获取数据]
     * @return [type] [description]
     */
    private function _get($url,$data,$type='get'){
		  $curl = curl_init(); // 启动一个CURL会话
	      curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
	      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
	      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
	      curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
	      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
	      curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
	      if(strtoupper($type)=='POST'){
	          curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
	          if (empty($data)){
	              curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
	          }
	      }
	      curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
	      curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
	      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
	      $tmpInfo = curl_exec($curl); // 执行操作
	      curl_close($curl); // 关闭CURL会话 
	   
    	 return json_decode($tmpInfo,true); // 返回数据
    }
}