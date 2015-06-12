$(document).ready(function() { 
	//banner上的区域框连接
	//$('.loginBox .gd,#game_down').attr('href','http://download.17gd.com/lobby/SetupLobby_Mini_17GD_1.0.0.exe');
	$('.loginBox .gr').attr('href','/register');
	$('.loginBox .gl').attr('href','/user');
	
	$('.index_game_list ul li:last').css('margin-right','0px');
	
	//下载统计
	$('.loginBox .gd,.game_down').click(function(){
		location.href='http://download.17gd.com/lobby/SetupLobby_Mini_17GD_1.0.4.exe'; //下载链接
		$.post('/index/down', null, function(data) {
		}, 'json');
		  
	});
	//在线服务连接
	$('.server_line,#server_line').click(function(){
		window.open('http://tb.53kf.com/webCompany.php?arg=10080265&style=1', '_blank', 'height=473,width=703,top=200,left=200,status=yes,toolbar=no,menubar=no,resizable=yes,scrollbars=no,location=no,titlebar=no');
	});
	var user_is_login=false;
	if(islogin()){
		user_is_login=true;
	}
	$('.pop_close').each(function(){
		$(this).click(function(){ 
			$('#TB_overlay').hide();$('#login-pop').hide();$('#message-pop').hide();
			if($(this).attr('data')=='login'){
				var d_l=location.href;
				if(d_l.indexOf('/user')>-1 || d_l.indexOf('/orders')>-1){
					location.href='/';
				}
			}else if($(this).attr('data')=='url'){
				if($(this).attr('data-url')!=''){
					location.href=$(this).attr('data-url');
				}
			}
		});
	});
	
	//检测所有需要登录的菜单
	$('a').each(function(){
		if(user_is_login){return true;}
		var href=$(this).attr('href').toLowerCase();
		if(href.indexOf('/user')>-1 || href.indexOf('/orders')>-1 || href.indexOf('/shop/shop_order')>-1 || href.indexOf('/service/look_bug')>-1){ 
				$(this).attr('href','#');$(this).attr('data-url',href);
				$(this).click(function(){
					if(!user_is_login){
						 back_url= $(this).attr('data-url').replace(new RegExp("/","gm"),"|"); 
						 $('#TB_window').html('');$('#TB_window').html('<iframe src="/public/login/back_url/'+back_url+'" frameborder="0" scrolling="no" border="0"></iframe>');
						 $('#TB_overlay').show();$('#login-pop').show();
					}else{
						location.href=href;
					}
				});
		}
	});
	$('.open_login_window').click(function(){
		 $('#TB_window').html('');$('#TB_window').html('<iframe src="/public/login/back_url/def" frameborder="0" scrolling="no" border="0"></iframe>');
		 $('#TB_overlay').show();$('#login-pop').show();
	});
	$('#true_pop_close').click(function(){
			$('#TB_overlay').hide();$('#message-pop').hide();
			if($(this).attr('data')=='login'){
				var d_l=location.href;
				if(d_l.indexOf('/user')>-1 || d_l.indexOf('/orders')>-1){
					location.href='/';
				}
			}else if($(this).attr('data')=='url'){
				if($(this).attr('data-url')!=''){
					location.href=$(this).attr('data-url');
				}
			}
	});
	$('#logout').click(function(){
		logoutSubmit();
	});
	
})

function islogin(){
	b_v=$.ajax({url:"/index/islogin",async:false});
	if(b_v.responseText==1){
		return true;
	}else{
		return false;
	}
}

function tip_message(title,content,t,url){
	if(t==0){
		title==''?title='失败':title=title;
		status='<i class="check_status_no"></i>';
	}else if(t==2){
		status='';
		content='<div class="check_status_q"><a href="/user/douziinhistory" style=" position:absolute;left:71px;top:139px; width:117px; height:35px;"></a><a id="c_tip_win" href="" style=" position:absolute;left:205px;top:139px; width:127px; height:35px;"></a></div>';
		title==''?title='确认':title=title;
		$('#message-pop .center').hide();
		$('#message-pop').css('height','280px');
		$('#c_tip_win').on('click',function(){ $('#true_pop_close').click(); });
	}else{
		status='<i class="check_status"></i>';
		title==''?title='成功':title=title;
	}
	$('#message-pop-title span').html(title);
	$('#TB_status').html('');$('#TB_status').html(status+content);
	$('#message-pop').find('a').attr('data-url',url);
	$('#true_pop_close').attr('data-url',url);
	$('#TB_overlay').show();$('#message-pop').show();
}

function logoutSubmit() {
	$.post('/index/logout', null, function(data) {
		//alert(data.info);
		window.location.href = "/";
	}, 'json');
}

//
function checkname(accounts, callback) {
	if (accounts == "") {
		return;
	}
	$.post('/index/check_register', {
		'accounts' : accounts
	}, function(data) {
		callback(data);
	}, 'json');
}

function check_nickname(nickname, callback) {
	if (nickname == "") {
		return;
	}
	$.post('/index/check_nickname', {
		'nickname' : nickname
	}, function(data) {
		callback(data);
	}, 'json');
}

function get_adv(div,title,t,id){
	
	$.post('/public/get_adv', {
		't' : t,'id':id
	}, function(data) {
		if(data.status ==1){
			var text="<a href='"+data.info.url+"' title='"+title+"' target='_blank'><img src='"+data.info.pic+"' /></a>"; 
			$('#'+div).html(text);
		}else{
			return;
		}
	}, 'json');
}

var countdown=60;
function settime() {
	if (countdown == 0) {
		$("#m_key").bind('click',function(){sendkey();});
		$("#m_key").css('color','').html("获取验证码");
		clearInterval(p);
		countdown=60;
	} else {
		$("#m_key").unbind('click'); 
		$("#m_key").css('color','red').html("重新发送(" + countdown + ")");
		countdown--;
	}
} 

