<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Tool;

class WeixinAction extends Action{

	public function index(){
		/* 加载微信SDK */
		import('COM.ThinkWechat');
		$weixin = new ThinkWechat('这里填写你申请的TOKEN');

		/* 获取请求信息 */
		$data = $weixin->request();
		
		/* 获取回复信息 */
		// 这里的回复信息是通过判断请求内容自行定制的， 不在 SDK范围内，请自行完成
		list($content, $type) = $this->reply($data);

		/* 响应当前请求 */
		$weixin->response($content, $type);
	}

	private function reply($data){
		if('text' == $data['MsgType']){
			$reply = array($data['Content'], 'text');
		} elseif('event' == $data['MsgType'] && 'subscribe' == $data['Event']){
			$reply = array('欢迎您关注麦当苗儿公众助手！', 'text');
		} else {
			exit;
		}
		return $reply;
	}

}
