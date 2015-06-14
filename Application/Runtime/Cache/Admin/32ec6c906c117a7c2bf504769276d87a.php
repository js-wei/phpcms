<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title><?php echo ((isset($config["title"]) && ($config["title"] !== ""))?($config["title"]):'PHPCMS-Login Page'); ?></title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="/Public/Admin/media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/Public/Admin/media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="/Public/Admin/media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="/Public/Admin/media/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="/Public/Admin/media/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/Public/Admin/media/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="/Public/Admin/media/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="/Public/Admin/media/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="/Public/Admin/media/css/login.css" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="/Public/Admin/media/image/favicon.ico" />
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="login">
	<!-- BEGIN LOGO -->
	<div class="logo">
		<img src="/Public/Admin/media/image/logo-big.png" alt="" /> 
	</div>
	<!-- END LOGO -->

	<!-- BEGIN LOGIN -->
	<div class="content">
		<!-- BEGIN LOGIN FORM -->
		<form class="form-vertical login-form" method="post" action="<?php echo U('Public/login');?>" id="login-form" autocomplete="off">
			<h3 class="form-title">输入登录账号</h3>
			<div class="alert alert-error hide">
				<button class="close" data-dismiss="alert"></button>
				<span>输入您的账号和密码.</span>
			</div>
			<div class="control-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9">账户名</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-user"></i>
						<input class="m-wrap placeholder-no-fix" type="text" value="<?php echo ($username); ?>" placeholder="登录账号" name="username" id="username" autocomplete="off"/>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label visible-ie8 visible-ie9">密码</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-lock"></i>
						<input class="m-wrap placeholder-no-fix" value="<?php echo ($password); ?>" type="password" placeholder="登录密码" name="password" id="password" autocomplete="off"/>
					</div>
				</div>
			</div>
            <div class="control-group">
                <label class="control-label visible-ie8 visible-ie9">验证码</label>
                <div class="controls">
                    <div class="input-icon left">
                        <i class="icon-lock"></i>
                        <input class="m-wrap placeholder-no-fix" type="text" placeholder="验证码" name="verify" id="verify"/>
                    </div>
                </div>
                <div class="controls">
                    <img src="/Admin/Login/verify" alt="验证码" width="450" style="cursor:pointer;" id="verify-image"/>
                </div>
            </div>
			<div class="form-actions">
                <label for="remember">
                    <input type="checkbox" name="remember" id="remember" value="1"  <?php if(($remember) == "1"): ?>checked<?php endif; ?>/>记住我
                </label>
				<button type="submit" class="btn green pull-right" id="login">
				登录 <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
		</form>
		<!-- END LOGIN FORM -->        
	</div>
	<!-- END LOGIN -->
	<!-- BEGIN COPYRIGHT -->
	<div class="copyright">
		<?php echo ((isset($$config["copyright"]) && ($$config["copyright"] !== ""))?($$config["copyright"]):'2013 &copy; Metronic. Admin Dashboard Template.'); ?>
	</div>
	<!-- END COPYRIGHT -->

	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->
	<script src="/Public/Admin/media/js/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="/Public/Admin/media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="/Public/Admin/media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
	<script src="/Public/Admin/media/js/bootstrap.min.js" type="text/javascript"></script>
	<!--[if lt IE 9]>
	<script src="/Public/Admin/media/js/excanvas.min.js"></script>
	<script src="/Public/Admin/media/js/respond.min.js"></script>  
	<![endif]-->   

	<script src="/Public/Admin/media/js/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="/Public/Admin/media/js/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="/Public/Admin/media/js/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="/Public/Admin/media/js/jquery.uniform.min.js" type="text/javascript" ></script>
	<!-- END CORE PLUGINS -->

	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="/Public/Admin/media/js/jquery.validate.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->

	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="/Public/Admin/media/js/app.js" type="text/javascript"></script>
	<script src="/Public/Admin/media/js/login.js" type="text/javascript"></script>      
	<!-- END PAGE LEVEL SCRIPTS --> 
	
	<script type="text/javascript">
		jQuery(document).ready(function() {     
			App.init();
			Login.init();
            $('#verify-image').click(function(){
                $(this).attr('src','/Admin/Login/verify?id'+Math.random());
            });

            if('<?php echo (session('login_remember')); ?>'=='1'){
                $('#verify').focus();
            }else{
                $('#username').focus();
            }
		});
	</script>
	<!-- END JAVASCRIPTS -->
	<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->

</html>