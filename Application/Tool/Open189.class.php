<?php
namespace Tool;

class Open189{

	/**
	 * [sendSMS 发送短信验证]
	 * @param  [type] $mobile  [手机号]
	 * @param  [type] $message [发送信息]
	 * @return [type]          [结果]
	 */
	public function sendSMS($mobile, $message){
        $App_Id=C('AppId');
        $App_Secret=C('AppSecret');
        $access_token=$this->get_Access_token();
        $token=$this->getToken();
        $timestamp = date('Y-m-d H:i:s');
        $url="http://api.189.cn/v2/dm/randcode/sendSms";

        $param['app_id']= "app_id=".$App_Id;
        $param['access_token'] = "access_token=".$access_token;
        $param['timestamp'] = "timestamp=".$timestamp;
        $param['phone']="phone=".$mobile;
        $param['token']="token=".$token;
        $param['randcode']="randcode=".$message;
        ksort($param);
        $plaintext = implode("&",$param);
        $param['sign'] = "sign=".rawurlencode(base64_encode(hash_hmac("sha1", $plaintext, $App_Secret, $raw_output=True)));
        ksort($param);

        $result=$this->curl_post($url,implode("&",$param));
        $resultArr=json_decode($result);   
        return $resultArr;
    }


     /**
     * [busSiteNameInfo 根据具体公交站名获取所有路过该站点的公交线路]
     * @param  [type]  $city        [城市名称/代码('北京'、010)]
     * @param  [type]  $stationName [公交站台名('西直门')]
     * @param  integer $number      [显示条数(默认：10)]
     * @param  integer $batch       [显示页数(默认：第一页)]
     * @param  string  $rid         [请求ID]
     * @return [type]               [description]
     */
    public function busRouteInfo($city,$stationName,$number=10,$batch=1,$encode="gbk",$rid=''){
    	$App_Id=C('AppId');
        $App_Secret=C('AppSecret');
        $access_token=$this->get_Access_token();
        $token=$this->getToken();
        $timestamp = date('Y-m-d H:i:s');
    	$url='http://api.189.cn/v2/besttone/getBusRouteInfo';

    	$param['app_id']= "app_id=".$App_Id;
        $param['access_token'] = "access_token=".$access_token;
        $param['timestamp'] = "timestamp=".$timestamp;
        $param['city']='city='.$city;
        $param['stationName'] = "stationName=".$stationName;
        $param['encode'] = "encode=".$encode;
        $param['number'] = "number=".$number;
        $param['batch']='batch='.$batch;
        $param['rid']='rid='.$rid;
		ksort($param);
        $plaintext = implode("&",$param);
        $param['sign'] = "sign=".rawurlencode(base64_encode(hash_hmac("sha1", $plaintext, $App_Secret, $raw_output=True)));
        ksort($param);
        $result=$this->curl_post($url,implode("&",$param));
       
        return $result;
    }

    /**
     * [busSiteNameInfo 根据具体公交站名获取所有路过该站点的公交线路]
     * @param  [type]  $city        [城市名称/代码('北京'、010)]
     * @param  [type]  $stationName [公交站台名('西直门')]
     * @param  integer $number      [显示条数(默认：10)]
     * @param  integer $batch       [显示页数(默认：第一页)]
     * @param  string  $rid         [请求ID]
     * @return [type]               [description]
     */
    public function busSiteNameInfo($city,$stationName,$number=10,$batch=1,$encode="gbk",$rid='123'){
    	$App_Id=C('AppId');
        $App_Secret=C('AppSecret');
        $access_token=$this->get_Access_token();
        $token=$this->getToken();
        $timestamp = date('Y-m-d H:i:s');
    	$url='http://api.189.cn/v2/besttone/getBusSiteNameInfo';

    	$param['app_id']= "app_id=".$App_Id;
        $param['access_token'] = "access_token=".$access_token;
        $param['timestamp'] = "timestamp=".$timestamp;
        $param['city']='city='.$city;
        $param['stationName'] = "stationName=".$stationName;
        $param['encode'] = "encode=".$encode;
        $param['number'] = "number=".$number;
        $param['batch']='batch='.$batch;
        $param['rid']='rid='.$rid;
		ksort($param);
        $plaintext = implode("&",$param);
        $param['sign'] = "sign=".rawurlencode(base64_encode(hash_hmac("sha1", $plaintext, $App_Secret, $raw_output=True)));
        ksort($param);
        $result=$this->curl_post($url,implode("&",$param));
        

       /* $param['app_id']= $App_Id;
        $param['access_token'] = $access_token;
        $param['timestamp'] = $timestamp;
        $param['city']=$city;
        $param['stationName'] =$stationName;
        $param['encode'] = $encode;
        $param['number'] = $number;
        $param['batch']=$batch;
        $param['rid']=$rid;
        //p($param);die;
        $result=$this->_curl_post($url,$param);*/
        

        return $result;
    }

    /**
     * [getToken 获取信任吗]
     * @return [type] [description]
     */
    protected function getToken(){   
    	$App_Id=C('AppId');
        $App_Secret=C('AppSecret');
        $access_token=$this->get_Access_token();
        $timestamp = date('Y-m-d H:i:s');
        $url = "http://api.189.cn/v2/dm/randcode/token?";

        $param['app_id']= "app_id=".$App_Id;
        $param['access_token'] = "access_token=".$access_token;
        $param['timestamp'] = "timestamp=".$timestamp;
        ksort($param);
        $plaintext = implode("&",$param);
        $param['sign'] = "sign=".rawurlencode(base64_encode(hash_hmac("sha1", $plaintext, $App_Secret, $raw_output=True)));
        ksort($param);
        $url .= implode("&",$param);
        //$result = curl_get($url);
       
        $r=$this->curl_get($url);
        $result=json_decode($r,true);
        return $result['token'];
        
    }
    
    /**
     * [get_Access_token 获取访问令牌]
     * @return [type] [description]
     */
    protected function get_Access_token(){
        
        $App_Id=C('AppId');
        $App_Secret=C('AppSecret');
        $grant_type='client_credentials';
       
        $send ='app_id='.$App_Id.'&app_secret='.$App_Secret.'&grant_type='.$grant_type;
   
        $access_token = $this->curl_post("https://oauth.api.189.cn/emp/oauth2/v3/access_token", $send);
        $access_token = json_decode($access_token, true);
       
        return $access_token['access_token'];
  
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
        return $tmpInfo; // 返回数据      
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

    /**
     * [_curl_post description]
     * @param  [type] $url  [description]
     * @param  [type] $post [description]
     * @return [type]       [description]
     */
    private function _curl_post($url,$post){
	    $options = array(
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_HEADER         => false,
	        CURLOPT_POST           => true,
	        CURLOPT_POSTFIELDS     => $post,
	    );

	    $ch = curl_init($url);
	    curl_setopt_array($ch, $options);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
    }
}