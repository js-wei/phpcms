<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="en-us">
<head>
    <!--拥有者:魏巍
        创建日期:2014-03-13 15:09:18
        编辑器:Editplus-->
	<meta charset="utf-8">
	<title>你若敢忘记我，别人会不知道你</title>
	<meta name="keywords" content="你若你记得我，别人会记得你"/>
	<meta name="description" content="你若懂我，别人也懂你"/>
	<meta name="author" content="魏巍"/>
	<meta name="generator" content="Editplus"/>
	<meta name="robots" content="all"/>
	<link href="/PHPCMS./Application/Admin/Public/style/left.css" rel="stylesheet" type="text/css" />
    <script src="/PHPCMS./Application/Admin/Public/scripts/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        function logout() {
            if (confirm("确定要退出当前系统吗？")) {
				//alert("<?php echo U('Index/loginOut');?>");
                window.top.location.href = "<?php echo U('Index/loginOut');?>";
            }
        }

        $(function () {
            $(".navigation-item").not(".navigation-item:first").find("ul").slideUp();
            $(".navigation-item:first .item-title").addClass("current");

            $(".navigation-item").each(function () {
                var item = $(this);
                item.find(".item-title").click(function () {
                    if ($(this).hasClass("current")) {
                        $(this).removeClass("current");
                    } else {
                        var par = $(".navigation-item").not($(this).parents(".navigation-item"));
                        par.find(".item-title").removeClass("current");
                        par.find("ul").slideUp(1000);
                        $(this).addClass("current");
                    }
                    item.find("ul").slideToggle("30");
                });

            });

            $(".navigation-item ul li a").click(function () {
                $(".navigation-item ul li a.current").removeClass("current");
                $(this).addClass("current");
            });

        });
    </script>
</head>
<body>
	<div style="scroll-y: hidden; background: url(./Application/Admin/Public/images/logMsg.jpg) no-repeat 0px 0px;
        height: 70px; color: Black; padding-top: 3px;">
        <p>
            欢迎您，<strong class="f14 orange"><font class="gray"><?php echo (session('username')); ?></font></strong>
		</p>
        <a href="/" target="_blank" style="color: Black;">网站首页</a> - 
		<a href="##" onclick="logout()" style="color:Black;">注销</a>
    </div>
    <div id="sidebar" class="holder osX">
      <div class="navigationbar">
            <span>管理菜单</span>
      </div>
     
        <?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="navigation-list">
                <div class="navigation-item">
                    <?php if(empty($vo[child])): ?><h5 class="item-title">
                        <?php echo ($vo["name"]); ?></h5><?php endif; ?>
                    <noempty name="vo[child]">
                    <h5 class="item-title">
                        <?php echo ($vo["name"]); ?></h5>
                    <?php if(is_array($vo[child])): $i = 0; $__LIST__ = $vo[child];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?><ul>
                            <li><a href="/PHPCMS/<?php echo (MODULE_NAME); ?>/<?php echo ($vo["title"]); ?>/<?php echo ($sub["title"]); ?>" target="main_right"> <!-- <img alt="" src="./Application/Admin/Public/images/tree/<?php echo ($vo["ico"]); ?>.png" style="float: left; margin: 10px 20px 0px 30px;" /> --><?php echo ($sub["name"]); ?></a></li>
                         </ul><?php endforeach; endif; else: echo "" ;endif; ?>
                    </noempty>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($nav_column)): $i = 0; $__LIST__ = $nav_column;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="navigation-list">
                <div class="navigation-item">
                    <?php if(empty($vo[child])): ?><h5 class="item-title">
                        <?php echo ($vo["title"]); ?></h5><?php endif; ?>
                    <noempty name="vo[child]">
                    <h5 class="item-title">
                        <?php echo ($vo["title"]); ?></h5>
                    <?php if(is_array($vo[child])): $i = 0; $__LIST__ = $vo[child];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?><ul>
                           <li>
                                <a href="<?php echo U('Article/index',array('cid'=>$sub['id']));?>" target="main_right"> 
                                    <?php echo ($sub["title"]); ?>
                                </a>
                            </li> 
                         </ul><?php endforeach; endif; else: echo "" ;endif; ?>
                    </noempty>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
 
        <?php if(!empty($singel)): ?><div class="navigation-list">
                <div class="navigation-item">
                    <h5 class="item-title">
                        单页面管理</h5>
                    <ul>
                        <?php if(is_array($singel)): $i = 0; $__LIST__ = $singel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sg): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Single/index',array('id'=>$sg['id']));?>" target="main_right"><?php echo ($sg["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div><?php endif; ?>
         <div class="navigation-list">
            <div class="navigation-item">
                <h5 class="item-title">
                    基本管理</h5>
                <ul>
                    <li><a href="<?php echo U('Base/index');?>" target="main_right">网站信息</a></li>
                    <li><a href="<?php echo U('Base/message');?>" target="main_right">留言信息</a></li>
                    <li><a href="<?php echo U('Base/flink');?>" target="main_right">友情链接</a></li>
                    <li><a href="<?php echo U('Base/site');?>" target="main_right">接入网站管理</a></li>
                </ul>
            </div>
        </div> 

        <div class="navigation-list">
            <div class="navigation-item">
                <h5 class="item-title">
                    商城管理</h5>
                <ul>
                    <li><a href="<?php echo U('Shopping/index');?>" target="main_right">订单管理</a></li>
                    <li><a href="<?php echo U('Shopping/send');?>" target="main_right">发货管理</a></li> 
                </ul>
            </div>
        </div> 
        <div class="navigation-list">
            <div class="navigation-item">
                <h5 class="item-title">
                    游戏管理</h5>
                <ul>
                    <li><a href="<?php echo U('Game/index');?>" target="main_right">账号管理</a></li>
                    <li><a href="<?php echo U('Shopping/send');?>" target="main_right">发货管理</a></li> 
                </ul>
            </div>
        </div> 
        
    </div>
</body>
</html>