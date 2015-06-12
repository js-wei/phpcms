<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="en-us">
<head>
    <!--拥有者:魏巍
        创建日期:2014-03-13 14:58:30
        编辑器:Editplus-->
	<meta charset="utf-8">
	<title>你若敢忘记我，别人会不知道你</title>
	<meta name="keywords" content="你若你记得我，别人会记得你"/>
	<meta name="description" content="你若懂我，别人也懂你"/>
	<meta name="author" content="魏巍"/>
	<meta name="generator" content="Editplus"/>
	<meta name="robots" content="all"/>
	<link href="./Application/Admin/Public/style/login.css" rel="stylesheet" type="text/css" />
    <script src="./Application/Admin/Public/Scripts/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {

            $(".tbox").focus(function () {
                $(".tbox").removeClass("tbox_focus");
                $(this).addClass("tbox_focus");
            }).blur(function () {
                $(this).removeClass("tbox_focur");
            }).first().focus();
            var url = $('#checkCode').attr('src');

            //点击验证码图片 更换验证码图片
            $('#checkCode,.checkCode').click(function(){
                var img = $('#checkCode');
                img.attr('src', url +'/'+ Math.random());
            })
        });
    </script>
</head>
<body>
	<form id="form1" action="<?php echo U(GROUP_NAME.'/Login/Login');?>" method="post">
    <div class="login">
        <div class="left">
            <img alt="" src="./Application/Admin/Public/images/login/login_03.gif" style="margin-left: 30px;" />
            <img alt="" src="./Application/Admin/Public/images/login/login_09.gif" />
            <div class="support">
                <span class="info">版权信息</span> <span class="copyright">&copy; 魏巍：13585490863 </span>
            </div>
        </div>
        <div class="middle">
            <img alt="" src="./Application/Admin/Public/images/login/login_05.gif" />
            <div class="area">
                <table class="tblogin">
                    <tr>
                        <td>
                            用户名：
                        </td>
                        <td>
                           <input type="text" name="username" class="tbox">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            密 &nbsp;&nbsp; 码：
                        </td>
                        <td>
                            <input type="password" name="password" class="tbox">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            验证码：
                        </td>
                        <td>
							<input type="text" name="verify" id="txtVerify" class="tbox">
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <img id="checkCode" src="<?php echo U(GROUP_NAME.'/Login/verify','','');?>"  title="点击图片更换验证码" class="checkCode" />
                            &nbsp;<a href="javascript:void(0);" class="checkCode" style="font-size: 13px;">换一张</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="btn">
                          <!--  <input type="submit" value="登录" class="button"> -->
                        </td>
                        <td class="btn">
                           <input type="submit" value="登录" class="button">
                        </td>
                    </tr>
                </table>
            </div>
            <img alt="" src="./Application/Admin/Public/images/login/login_16.gif" />
        </div>
        <div class="right">
            <img alt="" src="./Application/Admin/Public/images/login/login_11.gif" />
        </div>
    </div>
    </form>
</body>
</html>