<?PHP 

//用php写一个服务器端的http类 
//File: Http.class.php 
//Author: lijunjie 
//Date: 2007-08-05 
//E-mail:lijunjie1982@yahoo.com.cn 
//修改历史： 
//1. 2007-09-21 对参数里的名字也进行了编码 
//2. 2007-9-22 对参数的编码的算法进行了纠正和简化 
//3. 2007-10-11 规范了书写的格式，添加了几个方法 
//4. 2007-10-13 允许添加请求头信息和输出相应头信息，修改了post和get的调用方法， 
// 现在只返回true|false，相应内容通过其它方法得到，这样基本可以不用is_error方法了. 
// 由于此修改该版本无法与以前版本兼容，故又添加了获取版本号的方法，目前版本定为1.1.0 
//5. 2007-10-17 修改了addGetParam中的一个bug 从 $this->_url .= strpos($this->_url,'?') == -1?'?':'&'; 到 $this->_url .= strpos($this->_url,'?') === false?'?':'&'; 
//6. 2007-11-7 将 $this->_port = isset($arr_url['port'])?$arr_url['port']:'80'; 修改成 $this->_port = isset($arr_url['port'])?$arr_url['port']:'80'; 避免一个notice 
/* 
//测试代码 
$http = new Http('http://localhost/cgi-bin/cgi.php/extra/path?A=B&C=D'); 
$http->addPostParam(array('from'=>'2008mail','name'=>'vblog0')); 
$http->addHeader("Author:lijunjie"); 
//echo $http->getVersion(); 
if(!$http->post()){ 
    //如果是javascript请求，输出是给javascript的，可能就需要对输出转码 
    echo "error description：".$http->err_str; 
    exit; 
}else{ 
    echo $http->getResponse('header'); 
    echo $http->getContent(); 
} 
exit; 
*/ 
namespace Tool;

class Http { 

    private $_url = ''; //请求资源的地址 
    private $_params = ''; //post参数字符串 
    private $_headers = ''; //header参数字符串 
    private $_host = ''; //主机 
    private $_port = ''; //端口号 
    private $_path = ''; //资源路径 
    private $_query = ''; //查询字符串 
    private $_time_out = 10; //请求超时时间（单位：s） 
    private $_response = array(); //相应信息 
    private $_version = "Http_class v1.1.0 \ncopyright@lijunjie"; 
    public $err_no = ''; //错误代码 
    public $err_str = ''; //错误描述 
    /** 
     * 构造函数 
     * 
     */ 
    public function Http($url = '') { 
        $this->_url = $url; 
    } 
    /** 
     * 设置url 
     * 
     */ 
    public function setURL($url = '') { 
        $this->_url = $url; 
    } 
    /** 
    * 设置请求超时时间 
    * 
    */ 
    public function setTimeOut($timeout = 10) { 
        $this->_time_out = $timeout; 
    } 
    /** 
    * 重置 
    * 
    */ 
    public function clear() { 
        $this->_url = ""; 
        $this->_params = ""; 
        $this->_headers = ""; 
        $this->err_no = ""; 
        $this->err_str = ""; 
    } 
    /** 
     * 添加header 
     * @$str_header 
     */ 
    public function addHeader($str_header) { 
        $this->_headers .= $str_header ."\n"; 
    } 
    /** 
     * 设置header 
     * @$str_header 
     */ 
    public function setHeader($str_header) { 
        $this->_headers = $str_header ."\n"; 
    } 
    /** 
     * 添加get参数 
     * @$arrParam ：参数数组 
     */ 
    public function addGetParam($arrParam) { 
        $this->_url .= strpos($this->_url,'?') === false?'?':'&'; 
        $this->_url .= http_build_query($arrParam); 
    } 
    /** 
     * 添加post参数 
     * @$arrParam ：参数数组 
     */ 
    public function addPostParam($arrParam) { 
        $this->_params .= strlen($this->_params) > 0?'&':''; 
        $this->_params .= http_build_query($arrParam); 
    } 
    /** 
     * 重新添加post参数 
     * @$arrParam ：参数数组 
     */ 
    public function setPostParam($arrParam) { 
        $this->_params = http_build_query($arrParam); 
    } 
    /** 
     * get方法 
     * 说明：资源不存在时将返回空 
     */ 
    public function get() { 
        return $this->_request("GET"); 
    } 
    /** 
     * post方法 
     * 说明：资源不存在时将返回空 
     */ 
    public function post() { 
        return $this->_request("POST"); 
    } 
    /** 
     * getResponse方法 
     * 说明：获取响应信息 
     * @$item = [header | content] 
     */ 
    public function getResponse($item = "") { 
        return $item == ""?$this->_response:$this->_response[$item]; 
    } 
    /** 
     * getContent方法 
     * 说明：获取响应内容,简化getResponse 
     */ 
    public function getContent() { 
        return $this->_response['content']; 
    } 
    /** 
     * getVersion方法 
     * 说明：获取响应内容,简化getResponse 
     */ 
    public function getVersion() { 
        return $this->_version; 
    } 
    /** 
     * 只检查post方法是否出错 
     * 
     */ 
    public function is_error() { 
        return $this->err_no; 
    } 
    /** 
     * 返回出错信息 
     * 
     */ 
    public function get_error() { 
        return $this->err_str; 
    } 

    //=====私有方法===== 

    private function _parse_url() { 
        $arr_url = parse_url($this->_url); 
        if(!is_array($arr_url)){ 
            $arr_url = array(); 
        } 
        $this->_host = $arr_url['host']; 
        $this->_port = isset($arr_url['port'])?$arr_url['port']:'80'; 
        $this->_path = $arr_url['path']; 
        $this->_query = $arr_url['query']; 
    } 
    /** 
     * request方法 
     * 说明：资源不存在时将返回空 
     */ 
    private function _request($method = "GET") { 
        $this->_parse_url(); 
        $fp = @fsockopen($this->_host,$this->_port,$this->err_no,$this->err_str,$this->_time_out); 

        if(!$fp){ 
            return false; 
        }else{ 
            $request = ''; 
            $request .= sprintf("%s %s%s%s HTTP/1.0\n", $method, $this->_path, $this->_query ? "?" : "", $this->_query); 
            $request .= "Host: ".$this->_host."\n"; 
            $request .= $this->_headers; 
            $request .= $method == "POST"?"Content-type: application/x-www-form-urlencoded\n":""; 
            $request .= $method == "POST"?"Content-length: ". strlen($this->_params) ."\n":""; 
           	$request .= "Connection: close\n"; //这里还不太理解 
            $request .= $method == "POST"?"\n$this->_params\n":""; //注意是两次回车后写数据的 

            $request .= "\n"; 
            //echo $request;//exit; 
            fputs($fp,$request); 
            //获得请求后返回的内容 
            $results = ""; 
            while(!feof($fp)) { 
                $line = fgets($fp,1024); 
                $results .= $line; 
            } 
            fclose($fp); 
            $this->_response['header'] = substr($results,0,strpos($results,"\r\n\r\n")+1); //相应的头信息 
            $this->_response['content'] = substr($results,strpos($results,"\r\n\r\n")+4); //去掉请求返回的头部 
            return true; 
        } 
    } 
} 
