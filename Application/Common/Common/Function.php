<?php
/**
 * 打印函数
 * @param array $array
 */
function p($array){
	dump($array,1,'<pre>',0);
}

/*
 * 得到客户端ip
 * @param $type
 */
function get_browse_ip($type = 0) {
	$type       =  $type ? 1 : 0;
	static $ip  =   NULL;
	if ($ip !== NULL) return $ip[$type];
	if($_SERVER['HTTP_X_REAL_IP']){//nginx 代理模式下，获取客户端真实IP
		$ip=$_SERVER['HTTP_X_REAL_IP'];
	}elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
		$ip     =   $_SERVER['HTTP_CLIENT_IP'];
	}elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
		$arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$pos    =   array_search('unknown',$arr);
		if(false !== $pos) unset($arr[$pos]);
		$ip     =   trim($arr[0]);
	}elseif (isset($_SERVER['REMOTE_ADDR'])) {
		$ip     =   $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
	}else{
		$ip=$_SERVER['REMOTE_ADDR'];
	}

	// IP地址合法验证
	$long = sprintf("%u",ip2long($ip));
	$ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
	return $ip[$type];
}

/**
 * 重构F函数，解决序列化问题
 * @param string $file  保存文件名
 * @param array $data   缓存数据
 * @param string $path  缓存地址
 * @return int
 */
function FN($file='',$data=array(),$path=''){
    $filename=!empty($file)?$path.'/'.$file.'.php':$path.'/think_data.php';
    return file_put_contents($filename, "<?php return " .trim_all(var_export($data, true)) . ";");
}
/**
 * 去除空格
 * @param $str          字符串
 * @return string       结果
 */
function trim_all($str){
    $q=array(" ","　","\t","\n","\r");
    $h=array("","","","","");
    return str_replace($q,$h,$str);
}
/**
 * 判断文件夹是否为空
 * @param $dir  文件夹
 * @return bool
 */
function dir_is_empty($dir){
    if($handle = opendir($dir)){
        while($item = readdir($handle)){
            if ($item != '.' && $item != '..')
				return false;
		}
    }
    return true;
}
/**
 * [download 下载文件]
 * @param  string $url      [文件地址]
 * @param  string $filename [显示名称]
 * @return [type]           [description]
 */
function download($url='',$filename=''){
	$url = !empty($url) ? $url : '';
	\Org\Net\Http::download($url,$filename);
}

/**
 * 截取指定字符串
 * @param $str          字符串
 * @param $split        截取串
 * @param string $a     截取方向:n截取,l截取左侧,r截取右侧
 * @return mixed|string
 */
function pai_chu($str,$split,$a='n'){
    if(empty($str)){
        return "被替换的字符串不存在";
    }
    $mub = mb_convert_encoding($str,'GB2312','UTF-8');
    $zhi = mb_convert_encoding($split,'GB2312','UTF-8');
    if($a=="" || $a=='n'){
        $_result = str_replace($mub,"",$split);
    }elseif($a=="r"){
        $_result=substr($str,strpos($str,$split));
    }elseif($a=="l"){
        $_result=substr($str,0,strpos($str,$split));
    }

    return $_result;
}

/**
 * 检测访问的ip是否为规定的允许的ip
 * @param array $allowed_ip
 */
function check_ip($allowed_ip=array('192.168.2.*','127.0.0.1','192.168.2.49')){
	$ip=get_client_ip();
	$check_ip_arr= explode('.',$ip);//要检测的ip拆分成数组
	#限制IP
	if(!in_array($ip,$allowed_ip)) {
		foreach ($allowed_ip as $val){
			if(strpos($val,'*')!==false){//发现有*号替代符
				$arr=array();//
				$arr=explode('.', $val);
				$bl=true;//用于记录循环检测中是否有匹配成功的
				for($i=0;$i<4;$i++){
					if($arr[$i]!='*'){//不等于*  就要进来检测，如果为*符号替代符就不检查
						if($arr[$i]!=$check_ip_arr[$i]){
							$bl=false;
							break;//终止检查本个ip 继续检查下一个ip
						}
					}
				}//end for
				if($bl){//如果是true则找到有一个匹配成功的就返回
					return;
					die;
				}
			}
		}//end foreach
		header('HTTP/1.1 403 Forbidden');
		echo "Access forbidden";
		die;
	}
}
/**
 * 转换彩虹字
 * @param string $str
 * @param int $size
 * @param bool $bold
 * @return string
 */
function color_txt($str,$size=20,$bold=false){
	$len = mb_strlen($str);
	$colorTxt   = '';
	if($bold){
		$bold="bolder";
		$bolder="font-weight:".$bold;
	}
	for($i=0; $i<$len; $i++) {
		$colorTxt .=  '<span style="font-size:'.$size.'px;'.$bolder.'; color:'.rand_color().'">'.mb_substr($str,$i,1,'utf-8').'</span>';
	}
	return $colorTxt;
}
/**
 * 替换表情
 * @param string $content
 * @return string
 */
function replace_phiz($content){
    preg_match_all('/\[.*?\]/is', $content, $arr);
    /**
     * 替换表情
     */
    if($arr[0]){
        $phiz=F('phiz','','./data/');
        foreach ($arr[0] as $v){
            foreach ($phiz as $key =>$value){
                if($v=='['.$value.']'){
                    $content=str_repeat($v, '<img src="'.__ROOT__.'/Public/Images/phiz/'.$key.'.gif"/>',$content);
                    break;
                }
            }
        }
        return $content;
    }
}
/**
 * 截取字符串
 * @param string $str               字符串
 * @param int $start                开始位置
 * @param int $length               截取长度
 * @param string $charset           编码格式
 * @param bool $suffix              省略号
 * @return string|string
 */
function sub_str($str,$start=0,$length,$charset="utf-8",$suffix=true){
    $l=strlen($str);
    $slice='';
    if(function_exists("mb_substr"))
        return 	!$suffix?mb_substr($str,$start,$length,$charset):mb_substr($str,$start,$length,$charset)."…";
    else if(function_exists('iconv_substr')){
        return  !$suffix?iconv_substr($str,$start,$length,$charset):iconv_substr($str,$start,$length,$charset)."…";
    }
    $re['utf-8']="/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312']="/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']="/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']="/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset],$str,$match);
    $slice = join("",array_slice($match[0],$start,$length));

    if($suffix){
        if($l>$length){
            return $slice."…";
        }else{
            return $slice;
        }
    }
}

/**
 * 产生随机颜色
 * @return string
 */
function rand_color(){
	return '#'.sprintf("%02X",mt_rand(0,255)).sprintf("%02X",mt_rand(0,255)).sprintf("%02X",mt_rand(0,255));
}
/**
 * PHP去掉特定的html标签
 * @param array $string
 * @param bool $str
 * @return string
 */
function _strip_tags($tagsArr,$str) {
	foreach ($tagsArr as $tag) {
		$p[]="/(<(?:\/".$tag."|".$tag.")[^>]*>)/i";
	}
	$return_str = preg_replace($p,"",$str);
	return $return_str;
}
/**
 * [tag 截取字符串]
 * @param  [type] $资源字符串
 * @param  [type] $开始位置
 * @param  [type] $截取长度
 * @return [type] 结果字符串
 */
function tagstr($str,$start=0,$length=250){
	$str=strip_tags(htmlspecialchars_decode($str));
	$temp=mb_substr($str,$start,$length,'utf-8');
	//return (strlen($str)>$length*1.5)?$temp.'...':$temp;
	return $temp;
}


/**
 * * 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null){
	$config = C('THINK_EMAIL');
	vendor('PHPMailer.class#phpmailer');
	//从PHPMailer目录导class.phpmailer.php类文件
	$mail             = new PHPMailer(); //PHPMailer对象
	$mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
	$mail->IsSMTP();  // 设定使用SMTP服务
	$mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能,1 = errors and messages,2 = messages only
	$mail->SMTPAuth   = false;                  // 启用 SMTP 验证功能
	$mail->SMTPSecure = 'ssl';                 // 使用安全协议
	$mail->Host       = $config['SMTP_HOST'];  // SMTP 服务器
	$mail->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号
	$mail->Username   = $config['SMTP_USER'];  // SMTP服务器用户名
	$mail->Password   = $config['SMTP_PASS'];  // SMTP服务器密码
	$mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
	$replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
	$replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
	$mail->AddReplyTo($replyEmail, $replyName);
	$mail->Subject    = $subject;
	$mail->MsgHTML($body);
	$mail->AddAddress($to, $name);
	if(is_array($attachment)){ // 添加附件
		foreach ($attachment as $file){
			is_file($file) && $mail->AddAttachment($file);
		}
	}
	return $mail->Send() ? true : $mail->ErrorInfo;
}
/*
 * 邮件发送
 * @param string $to 收件人邮箱，多个邮箱用,分开
 * @param string $title 标题
 * @param string $content 内容
 */

function send_email($to,$title,$content,$webname="官方网站"){
	
	//邮件相关变量
	$cfg_smtp_server = 'smtp.163.com';
	$cfg_ask_guestview = '8';
	$cfg_smtp_port = '25';
	$cfg_ask_guestanswer = '8';
	$cfg_smtp_usermail = 'js_weiwei_100@163.com';//你的邮箱
	$cfg_smtp_user = 'js_weiwei_100@163.com';//你的邮箱号
	$cfg_smtp_password = 'wei110120';//你的邮箱密码

	$smtp = new \Tool\smtp($cfg_smtp_server,$cfg_smtp_port,true,$cfg_smtp_usermail,$cfg_smtp_password);
	$smtp->debug = false;

	$cfg_webname=$webname;
	$mailtitle=$title;//邮件标题
	$mailbody=$content;//邮件内容
	//$to 多个邮箱用,分隔
	$mailtype='html';
	return $smtp->sendmail($to,$cfg_webname,$cfg_smtp_usermail, $mailtitle, $mailbody, $mailtype);
}
/**
 * [NoRand 不重复随机数]
 * @param integer $begin [description]
 * @param integer $end   [description]
 * @param integer $limit [description]
 */
function NoRand($begin=0,$end=20,$limit=4){
	$rand_array=range($begin,$end);
	shuffle($rand_array);//调用现成的数组随机排列函数
	return implode('',array_slice($rand_array,0,$limit));//截取前$limit个
}
/**
 * [zeroize 数字补足]
 * @param  int $num    		[带补足数字]
 * @param  int $length 		 [补足长度]
 * @param  string $fill   	     [补足字符]
 * @param  int $fill   	  	[补足字符]
 * @return [type]         	[description]
 */
function zeroize($num,$length=10,$type=1,$fill='0'){
	$type=$type?STR_PAD_LEFT:STR_PAD_RIGHT;
	return str_pad($num,$length,$fill,$type);
}

/**
 * [getKey 根据value得到数组key]
 * @param  [type] $arr   [数组]
 * @param  [type] $value [值]
 * @return [type]        [description]
 */
function getKey($arr,$value) {
	if(!is_array($arr)) return null;
	foreach($arr as $k =>$v) {
		$return = getKey($v, $value);
		if($v == $value){
			return $k;
		}
		if(!is_null($return)){
			return $return;
		}
	}
}

/**
 * [php2class 转换成Think默认命名规则类]
 * e.g:
 * 修改文件夹下所有的php文件:.php --> .class.php
 * php2class(__FILE__,'Action\MemberAction.class.php','Tool');
 * @param [type] $path     		[文件夹路劲]
 * @param [type] $reg_path 		[要替换文件夹]
 * @param [type] $sea_path 		[待替换文件夹]
 * @param  boolean $print    	[是否输出]
 * @return [type]            	[description]
 */
function php2class($path,$reg_path,$sea_path,$print=false){
	$hostdir=!empty($path)?$path:__FILE__;

	if(!empty($reg_path) && !empty($sea_path)){
		$hostdir=str_replace($reg_path,$sea_path,$hostdir);
	}

	$filesnames = scandir($hostdir);
	foreach ($filesnames as $k => $v) {
		if($k>1){ //修改类名
			if(strpos($v,'class')===false){
				$temp=explode('.', $v);
				$n=$hostdir.'\\'.$temp[0].'.class.php';
				$o=$hostdir.'\\'.$v;
				rename($o,$n);
				if($print){
					p($n);
				}
			}else{
				if($print){
					p($v);
				}
			}
		}
	}
}

/**
 * 获取字符串中的图片
 * @param string $str   字符串
 * @return mixed
 */
function get_images($str=''){
    $pattern='';
    $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
    preg_match_all($pattern,$str,$match);
    return $match;
}

/**
 * 高亮
 * @param $key                  关键词
 * @param $content              文本
 * @param string $color         颜色
 * @param string $bold          加粗
 * @param string $italic        倾斜
 * @return mixed
 */
function highlight($key,$content,$color='red',$bold='normal',$italic='normal'){
    return preg_replace('/'.$key.'/i', '<span style="color:'.$color.';font-width:'.$bold.';font-style:'.$italic.';">'.$key.'</span>', $content);
}

/**
 * 去掉特定的html标签
 * @param array $tagsArr   过滤的标签{'<h1>','<b>'}
 * @param string $str      内容
 * @return mixed
 */
function rd_tags($tagsArr=array(),$str='') {
    foreach ($tagsArr as $tag) {
        $p[]="/(<(?:\/".$tag."|".$tag.")[^>]*>)/i";
    }
    $return_str = preg_replace($p,"",$str);
    return $return_str;
}




// OneThink常量定义
const ONETHINK_VERSION    = '1.0.131129';
const ONETHINK_ADDON_PATH = './Addons/';

/**
 * 系统公共库文件
 * 主要定义系统公共函数库
 */

/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str  要分割的字符串
 * @param  string $glue 分割符
 * @return array
 */
function str2arr($str, $glue = ','){
	return explode($glue, $str);
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array  $arr  要连接的数组
 * @param  string $glue 分割符
 * @return string
 */
function arr2str($arr, $glue = ','){
	return implode($glue, $arr);
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 */
function think_encrypt($data, $key = '', $expire = 0) {
	$key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
	$data = base64_encode($data);
	$x    = 0;
	$len  = strlen($data);
	$l    = strlen($key);
	$char = '';

	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) $x = 0;
		$char .= substr($key, $x, 1);
		$x++;
	}

	$str = sprintf('%010d', $expire ? $expire + time():0);

	for ($i = 0; $i < $len; $i++) {
		$str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
	}
	return str_replace('=', '',base64_encode($str));
}

/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list,$field, $sortby='asc') {
	if(is_array($list)){
		$refer = $resultSet = array();
		foreach ($list as $i => $data)
			$refer[$i] = &$data[$field];
		switch ($sortby) {
			case 'asc': // 正向排序
				asort($refer);
				break;
			case 'desc':// 逆向排序
				arsort($refer);
				break;
			case 'nat': // 自然排序
				natcasesort($refer);
				break;
		}
		foreach ( $refer as $key=> $val)
			$resultSet[] = &$list[$key];
		return $resultSet;
	}
	return false;
}


/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 * @return string
 */
function think_decrypt($data, $key = ''){
	$key    = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
	$x      = 0;
	$data   = base64_decode($data);
	$expire = substr($data,0,10);
	$data   = substr($data,10);

	if($expire > 0 && $expire < time()) {
		return '';
	}

	$len  = strlen($data);
	$l    = strlen($key);
	$char = $str = '';

	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) $x = 0;
		$char .= substr($key, $x, 1);
		$x++;
	}

	for ($i = 0; $i < $len; $i++) {
		if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
			$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
		}else{
			$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
		}
	}
	return base64_decode($str);
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名

 */
function data_auth_sign($data) {
	//数据类型检测
	if(!is_array($data)){
		$data = (array)$data;
	}
	ksort($data); //排序
	$code = http_build_query($data); //url编码并生成query字符串
	$sign = sha1($code); //生成签名
	return $sign;
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
	// 创建Tree
	$tree = array();
	if(is_array($list)) {
		// 创建基于主键的数组引用
		$refer = array();
		foreach ($list as $key => $data) {
			$refer[$data[$pk]] =& $list[$key];
		}
		foreach ($list as $key => $data) {
			// 判断是否存在parent
			$parentId =  $data[$pid];
			if ($root == $parentId) {
				$tree[] =& $list[$key];
			}else{
				if (isset($refer[$parentId])) {
					$parent =& $refer[$parentId];
					$parent[$child][] =& $list[$key];
				}
			}
		}
	}
	return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 */
function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
	if(is_array($tree)) {
		$refer = array();
		foreach ($tree as $key => $value) {
			$reffer = $value;
			if(isset($reffer[$child])){
				unset($reffer[$child]);
				tree_to_list($value[$child], $child, $order, $list);
			}
			$list[] = $reffer;
		}
		$list = list_sort_by($list, $order, $sortby='asc');
	}
	return $list;
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
	$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
	return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 设置跳转页面URL
 * 使用函数再次封装，方便以后选择不同的存储方式（目前使用cookie存储）
 */
function set_redirect_url($url){
	cookie('redirect_url', $url);
}

/**
 * 获取跳转页面URL
 * @return string 跳转页URL
 */
function get_redirect_url(){
	$url = cookie('redirect_url');
	return empty($url) ? __APP__ : $url;
}

/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 */
function time_format($time = NULL,$format='Y-m-d H:i'){
	$time = $time === NULL ? NOW_TIME : intval($time);
	return date($format, $time);
}

/**
 * 根据用户ID获取用户名
 * @param  integer $uid 用户ID
 * @return string       用户名
 */
function get_username($uid = 0){
	static $list;
	if(!($uid && is_numeric($uid))){ //获取当前登录用户名
		return session('user_auth.username');
	}
	/* 获取缓存数据 */
	if(empty($list)){
		$list = S('sys_active_user_list');
	}
	/* 查找用户信息 */
	$key = "u{$uid}";
	if(isset($list[$key])){ //已缓存，直接使用
		$name = $list[$key];
	} else { //调用接口获取用户信息
		$User = new User\Api\UserApi();
		$info = $User->info($uid);
		if($info && isset($info[1])){
			$name = $list[$key] = $info[1];
			/* 缓存用户 */
			$count = count($list);
			$max   = C('USER_MAX_CACHE');
			while ($count-- > $max) {
				array_shift($list);
			}
			S('sys_active_user_list', $list);
		} else {
			$name = '';
		}
	}
	return $name;
}

/**
 * 根据用户ID获取用户昵称
 * @param  integer $uid 用户ID
 * @return string       用户昵称
 */
function get_nickname($uid = 0){
	static $list;
	if(!($uid && is_numeric($uid))){ //获取当前登录用户名
		return session('user_auth.username');
	}
	/* 获取缓存数据 */
	if(empty($list)){
		$list = S('sys_user_nickname_list');
	}

	/* 查找用户信息 */
	$key = "u{$uid}";
	if(isset($list[$key])){ //已缓存，直接使用
		$name = $list[$key];
	} else { //调用接口获取用户信息
		$info = M('Member')->field('nickname')->find($uid);
		if($info !== false && $info['nickname'] ){
			$nickname = $info['nickname'];
			$name = $list[$key] = $nickname;
			/* 缓存用户 */
			$count = count($list);
			$max   = C('USER_MAX_CACHE');
			while ($count-- > $max) {
				array_shift($list);
			}
			S('sys_user_nickname_list', $list);
		} else {
			$name = '';
		}
	}
	return $name;
}

/**
 * 获取分类信息并缓存分类
 * @param  integer $id    分类ID
 * @param  string  $field 要获取的字段名
 * @return string         分类信息
 */
function get_category($id, $field = null){
	static $list;

	/* 非法分类ID */
	if(empty($id) || !is_numeric($id)){
		return '';
	}

	/* 读取缓存数据 */
	if(empty($list)){
		$list = S('sys_category_list');
	}

	/* 获取分类名称 */
	if(!isset($list[$id])){
		$cate = M('Category')->find($id);
		if(!$cate || 1 != $cate['status']){ //不存在分类，或分类被禁用
			return '';
		}
		$list[$id] = $cate;
		S('sys_category_list', $list); //更新缓存
	}
	return is_null($field) ? $list[$id] : $list[$id][$field];
}

/* 根据ID获取分类标识 */
function get_category_name($id){
	return get_category($id, 'name');
}
/* 根据ID获取分类名称 */
function get_category_title($id){
	return get_category($id, 'title');
}

/**
 * 记录行为日志，并执行该行为的规则
 * @param string $action 行为标识
 * @param string $model 触发行为的模型名
 * @param int $record_id 触发行为的记录id
 * @param int $user_id 执行行为的用户id
 * @return boolean
 * @author huajie <banhuajie@163.com>
 */
function action_log($action = null, $model = null, $record_id = null, $user_id = null){

	//参数检查
	if(empty($action) || empty($model) || empty($record_id)){
		return '参数不能为空';
	}
	if(empty($user_id)){
		$user_id = is_login();
	}

	//查询行为,判断是否执行
	$action_info = M('Action')->getByName($action);
	if($action_info['status'] != 1){
		return '该行为被禁用或删除';
	}

	//插入行为日志
	$data['action_id'] = $action_info['id'];
	$data['user_id'] = $user_id;
	$data['action_ip'] = ip2long(get_client_ip());
	$data['model'] = $model;
	$data['record_id'] = $record_id;
	$data['create_time'] = NOW_TIME;
	//系统日志记录操作url参数
	$data['remark'] = '操作url：'.$_SERVER['REQUEST_URI'];
	M('ActionLog')->add($data);

	if(!empty($action_info['rule'])){
		//解析行为
		$rules = parse_action($action, $user_id);

		//执行行为
		$res = execute_action($rules, $action_info['id'], $user_id);
	}
}

/**
 * 解析行为规则
 * 规则定义  table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
 * 规则字段解释：table->要操作的数据表，不需要加表前缀；
 *              field->要操作的字段；
 *              condition->操作的条件，目前支持字符串，默认变量{$self}为执行行为的用户
 *              rule->对字段进行的具体操作，目前支持四则混合运算，如：1+score*2/2-3
 *              cycle->执行周期，单位（小时），表示$cycle小时内最多执行$max次
 *              max->单个周期内的最大执行次数（$cycle和$max必须同时定义，否则无效）
 * 单个行为后可加 ； 连接其他规则
 * @param string $action 行为id或者name
 * @param int $self 替换规则里的变量为执行用户的id
 * @return boolean|array: false解析出错 ， 成功返回规则数组
 * @author huajie <banhuajie@163.com>
 */
function parse_action($action = null, $self){
	if(empty($action)){
		return false;
	}

	//参数支持id或者name
	if(is_numeric($action)){
		$map = array('id'=>$action);
	}else{
		$map = array('name'=>$action);
	}

	//查询行为信息
	$info = M('Action')->where($map)->find();
	if(!$info || $info['status'] != 1){
		return false;
	}

	//解析规则:table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
	$rules = $info['rule'];
	$rules = str_replace('{$self}', $self, $rules);
	$rules = explode(';', $rules);
	$return = array();
	foreach ($rules as $key=>&$rule){
		$rule = explode('|', $rule);
		foreach ($rule as $k=>$fields){
			$field = empty($fields) ? array() : explode(':', $fields);
			if(!empty($field)){
				$return[$key][$field[0]] = $field[1];
			}
		}
		//cycle(检查周期)和max(周期内最大执行次数)必须同时存在，否则去掉这两个条件
		if(!array_key_exists('cycle', $return[$key]) || !array_key_exists('max', $return[$key])){
			unset($return[$key]['cycle'],$return[$key]['max']);
		}
	}

	return $return;
}

/**
 * 执行行为
 * @param array $rules 解析后的规则数组
 * @param int $action_id 行为id
 * @param array $user_id 执行的用户id
 * @return boolean false 失败 ， true 成功
 * @author huajie <banhuajie@163.com>
 */
function execute_action($rules = false, $action_id = null, $user_id = null){
	if(!$rules || empty($action_id) || empty($user_id)){
		return false;
	}

	$return = true;
	foreach ($rules as $rule){

		//检查执行周期
		$map = array('action_id'=>$action_id, 'user_id'=>$user_id);
		$map['create_time'] = array('gt', NOW_TIME - intval($rule['cycle']) * 3600);
		$exec_count = M('ActionLog')->where($map)->count();
		if($exec_count > $rule['max']){
			continue;
		}

		//执行数据库操作
		$Model = M(ucfirst($rule['table']));
		$field = $rule['field'];
		$res = $Model->where($rule['condition'])->setField($field, array('exp', $rule['rule']));

		if(!$res){
			$return = false;
		}
	}
	return $return;
}

//基于数组创建目录和文件
function create_dir_or_files($files){
	foreach ($files as $key => $value) {
		if(substr($value, -1) == '/'){
			mkdir($value);
		}else{
			@file_put_contents($value, '');
		}
	}
}

if(!function_exists('array_column')){
	function array_column(array $input, $columnKey, $indexKey = null) {
		$result = array();
		if (null === $indexKey) {
			if (null === $columnKey) {
				$result = array_values($input);
			} else {
				foreach ($input as $row) {
					$result[] = $row[$columnKey];
				}
			}
		} else {
			if (null === $columnKey) {
				foreach ($input as $row) {
					$result[$row[$indexKey]] = $row;
				}
			} else {
				foreach ($input as $row) {
					$result[$row[$indexKey]] = $row[$columnKey];
				}
			}
		}
		return $result;
	}
}

/**
 * 获取表名（不含表前缀）
 * @param string $model_id
 * @return string 表名
 * @author huajie <banhuajie@163.com>
 */
function get_table_name($model_id = null){
	if(empty($model_id)){
		return false;
	}
	$Model = M('Model');
	$name = '';
	$info = $Model->getById($model_id);
	if($info['extend'] != 0){
		$name = $Model->getFieldById($info['extend'], 'name').'_';
	}
	$name .= $info['name'];
	return $name;
}

/**
 * 获取属性信息并缓存
 * @param  integer $id    属性ID
 * @param  string  $field 要获取的字段名
 * @return string         属性信息
 */
function get_model_attribute($model_id, $group = true){
	static $list;

	/* 非法ID */
	if(empty($model_id) || !is_numeric($model_id)){
		return '';
	}

	/* 读取缓存数据 */
	if(empty($list)){
		$list = S('attribute_list');
	}

	/* 获取属性 */
	if(!isset($list[$model_id])){
		$map = array('model_id'=>$model_id);
		$extend = M('Model')->getFieldById($model_id,'extend');

		if($extend){
			$map = array('model_id'=> array("in", array($model_id, $extend)));
		}
		$info = M('Attribute')->where($map)->select();
		$list[$model_id] = $info;
		//S('attribute_list', $list); //更新缓存
	}

	$attr = array();
	foreach ($list[$model_id] as $value) {
		$attr[$value['id']] = $value;
	}

	if($group){
		$sort  = M('Model')->getFieldById($model_id,'field_sort');

		if(empty($sort)){	//未排序
			$group = array(1=>array_merge($attr));
		}else{
			$group = json_decode($sort, true);

			$keys  = array_keys($group);
			foreach ($group as &$value) {
				foreach ($value as $key => $val) {
					$value[$key] = $attr[$val];
					unset($attr[$val]);
				}
			}

			if(!empty($attr)){
				$group[$keys[0]] = array_merge($group[$keys[0]], $attr);
			}
		}
		$attr = $group;
	}
	return $attr;
}

/**
 * 根据条件字段获取指定表的数据
 * @param mixed $value 条件，可用常量或者数组
 * @param string $condition 条件字段
 * @param string $field 需要返回的字段，不传则返回整个数据
 * @param string $table 需要查询的表
 * @author huajie <banhuajie@163.com>
 */
function get_table_field($value = null, $condition = 'id', $field = null, $table = null){
	if(empty($value) || empty($table)){
		return false;
	}

	//拼接参数
	$map[$condition] = $value;
	$info = M(ucfirst($table))->where($map);
	if(empty($field)){
		$info = $info->field(true)->find();
	}else{
		$info = $info->getField($field);
	}
	return $info;
}