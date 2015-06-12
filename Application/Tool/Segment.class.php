<?php
namespace Tool;

class Segment{

	protected $url='http://5.tbip.sinaapp.com/api.php?';

	public  function segment($str='苏州',$type='json'){
		$uri=$this->url.'str='.$str.'&type='.$type;
		p($uri);die;
		$res=$this->_curl($uri);
		return $res;
	}

    /**
    * [_get 获取数据]
    * @return [type] [description]
    */
    private function _curl($url,$data,$type='get'){
    	import('Class.Ini',APP_PATH);
    	$ini=new Ini();
    	if(function_exists('file_get_contents') && $ini->get('allow_url_fopen')){
    		$tmpInfo=file_get_contents($url);	
    	}else{
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
    	}  
	    return json_decode($tmpInfo,true); // 返回数据
    }

     /**
     * [_verb 分词属性代码]
     * @param  [type] $result [description]
     * @return [type]         [description]
     */
    private function _verb($result){
    	$verb=array(
    		10 =>'形容词',
			210 =>'副形词(直接作状语的形容词)',
			211 =>'名形词(具有名词功能的形容词)',
			20 =>'区别词',
			30 =>'连词',
			31 =>'体词连接',
			32 =>'分句连接',
			40 =>'副词',
			41 =>'副词("不")',
			42 =>'副词("没")',
			50 =>'叹词',
			60 =>'方位词',
			62 =>'方位短语(名词+方位词"地上")',
			61 =>'方位短语(处所词+方位词)',
			63 =>'方位短语(动词+方位词"取前")',
			64 =>'方位短语(动词+方位词"取前")',
			70 =>'前接成分',
			71 =>'数词前缀("数"---数十)',
			74 =>'姓氏',
			73 =>'姓氏',
			72 =>'时间词前缀("公元""明永乐")',
			80 =>'后接成分',
			81 =>'数词后缀("来"--,十来个)',
			83 =>'名词后缀("们")',
			87 =>'状态词后缀("然")',
			86 =>'状态词后缀("然")',
			84 =>'处所词后缀("苑""里")',
			82 =>'时间词后缀("初""末""时")',
			85 =>'状态词后缀("然")',
			90 =>'数词',
			201 =>'数量短语("叁个")',
			95 =>'名词',
			101 =>'名处词',
			102 =>'地名(名处词专指："中国")',
			103 =>'n-m,数词开头的名词(三个学生)',
			104 =>'n-rb,以区别词/代词开头的名词(该学校，该生)',
			96 =>'人名("毛泽东")',
			97 =>'机构团体("团"的声母为t,名词代码n和t并在一起。"公司")',
			98 =>'机构团体名("北大")',
			99 =>'机构团体名("北大")',
			100 =>'其他专名("专"的声母的第1个字母为z，名词代码n和z并在一起。)',
			107 =>'拟声词',
			108 =>'介词',
			110 =>'量词',
			113 =>'货币量词("元""美元""英镑")',
			112 =>'时间量词("年""月""期")',
			111 =>'动量词("趟""遍")',
			120 =>'代词',
			202 =>'代量短语("这个")',
			127 =>'区别词性代词("某""每")',
			121 =>'副词性代词("怎么")',
			122 =>'数词性代词("多少")',
			123 =>'名词性代词("什么""谁")',
			124 =>'处所词性代词("哪儿")',
			125 =>'时间词性代词("何时")',
			126 =>'谓词性代词("怎么样")',
			130 =>'处所词(取英语space的第1个字母。"东部")',
			200 =>'不及物谓词(主谓结构"腰酸""头疼")',
			230 =>'空格',
			131 =>'处所词(取英语space的第1个字母。"东部")',
			132 =>'时间词(取英语time的第1个字母)',
			133 =>'时间专指("唐代""西周")',
			140 =>'助词',
			0 =>'不知道',
			143 =>'补语助词("得")',
			142 =>'状语助词("地")',
			141 =>'定语助词("的")',
			145 =>'体词后助词("等、等等")',
			146 =>'助词("所")',
			144 =>'谓词后助词("了、着、过")',
			170 =>'及物动词(取英语动词verb的第一个字母。)',
			212 =>'副动词(直接作状语的动词)',
			213 =>'名动词(指具有名词功能的动词)',
			176 =>'助动词("应该""能够")',
			172 =>'动补结构动词("取出""放到")',
			171 =>'不及物谓词(谓宾结构"剃头")',
			175 =>'趋向动词("来""去""进来")',
			173 =>'动词"是"',
			174 =>'动词"有"',
			150 =>'标点符号',
			151 =>'顿号("、")',
			156 =>'中缀型符号',
			154 =>'搭配型标点左部',
			155 =>'搭配型标点右部("》""]""）")',
			153 =>'分句尾标点("，""；")',
			152 =>'句号("。")',
			190 =>'语素字',
			196 =>'状态词语素("伟""芳")',
			191 =>'名词语素("琥")',
			193 =>'处所词语素("中""日""美")',
			194 =>'时间词语素("唐""宋""元")',
			192 =>'动词语素("酹")',
			195=> '状态词语素("伟""芳")',
			160 =>'语气词(取汉字"语"的声母。"吗""吧""啦")',
			180=>'状态词(不及物动词,v-o、sp之外的不及物动词)'
    		);
		foreach ($result as $k => $v) {
			$v['word_tag']=$verb[$v['word_tag']];
			$temp[]=$v;
		}

		return $temp;
    }


}