<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title><?php echo ((isset($title) && ($title !== ""))?($title):'首页'); ?>_PHPCMS内容管理系统</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="/PHPCMS/Public/Admin/media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/PHPCMS/Public/Admin/media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="/PHPCMS/Public/Admin/media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="/PHPCMS/Public/Admin/media/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="/PHPCMS/Public/Admin/media/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/PHPCMS/Public/Admin/media/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="/PHPCMS/Public/Admin/media/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="/PHPCMS/Public/Admin/media/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" href="/PHPCMS/Public/static/common.css" />
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="/PHPCMS/Public/Admin/media/image/favicon.ico" />
    <!--BEGIN JQUERY -->
    <script src="/PHPCMS/Public/Admin/media/js/jquery-1.10.1.min.js" type="text/javascript"></script>
    <!--END JQUERY  -->
	<script type="text/javascript">
		$self='/PHPCMS/Admin/Control/del';
		$url='/PHPCMS/Admin/Control';
		$module ='<?php echo (MODULE_NAME); ?>';
		$controller ='<?php echo (CONTROLLER_NAME); ?>';
		$action = '<?php echo (ACTION_NAME); ?>';
	</script>
</head>
<body class="page-header-fixed">	
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="index.html">
				<img src="/PHPCMS/Public/Admin/media/image/logo.png" alt="logo"/>
				</a>
				<!-- END LOGO -->
				
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
					<img src="/PHPCMS/Public/Admin/media/image/menu-toggler.png" alt="" />
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->            

				<!-- BEGIN TOP NAVIGATION MENU -->              
				<ul class="nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->   
					<li class="dropdown" id="header_notification_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-warning-sign"></i>
							<span class="badge">6</span>
						</a>
						<ul class="dropdown-menu extended notification">
							<li>
								<p>您有 14个新通知</p>
							</li>
							<li>
								<a href="#">
								<span class="label label-success"><i class="icon-plus"></i></span>
								新用户注册. 
								<span class="time">刚刚</span>
								</a>
							</li>
							<li>
								<a href="#">
								<span class="label label-important"><i class="icon-bolt"></i></span>
								Server #12 overloaded. 
								<span class="time">15 mins</span>
								</a>
							</li>
							<li>
								<a href="#">
								<span class="label label-warning"><i class="icon-bell"></i></span>
								Server #2 not respoding.
								<span class="time">22 mins</span>
								</a>
							</li>												
							<li class="external">
								<a href="#">See all notifications <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->

					<!-- BEGIN INBOX DROPDOWN -->
					<li class="dropdown" id="header_inbox_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-envelope"></i>
							<span class="badge">5</span>
						</a>
						<ul class="dropdown-menu extended inbox">
							<li>
								<p>您有12个新信息</p>
							</li>
							<li>
								<a href="inbox.html?a=view">
								<span class="photo"><img src="/PHPCMS/Public/Admin/media/image/avatar2.jpg" alt="" /></span>
								<span class="subject">
									<span class="from">Lisa Wong</span>
									<span class="time">Just Now</span>
								</span>
								<span class="message">
									Vivamus sed auctor nibh congue nibh. auctor nibh
									auctor nibh...
								</span>  
								</a>
							</li>
							<li>
								<a href="inbox.html?a=view">
								<span class="photo"><img src=".//PHPCMS/Public/Admin/media/image/avatar3.jpg" alt="" /></span>
								<span class="subject">
									<span class="from">Richard Doe</span>
									<span class="time">16 mins</span>
								</span>
								<span class="message">
									Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh
									auctor nibh...
								</span>  
								</a>
							</li>
							<li>
								<a href="inbox.html?a=view">
								<span class="photo"><img src=".//PHPCMS/Public/Admin/media/image/avatar1.jpg" alt="" /></span>
								<span class="subject">
									<span class="from">Bob Nilson</span>
									<span class="time">2 hrs</span>
								</span>
								<span class="message">
									Vivamus sed nibh auctor nibh congue nibh. auctor nibh
									auctor nibh...
								</span>  
								</a>
							</li>
							<li class="external">
								<a href="inbox.html">See all messages <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>
					<!-- END INBOX DROPDOWN -->
					
					<!-- BEGIN TODO DROPDOWN -->
					<li class="dropdown" id="header_task_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-tasks"></i>
						<span class="badge">5</span>
						</a>
						<ul class="dropdown-menu extended tasks">
							<li>
								<p>You have 12 pending tasks</p>
							</li>
							<li>
								<a href="#">
								<span class="task">
									<span class="desc">New release v1.2</span>
									<span class="percent">30%</span>
								</span>
								<span class="progress progress-success ">
									<span style="width: 30%;" class="bar"></span>
								</span>
								</a>
							</li>
							<li>
								<a href="#">
									<span class="task">
										<span class="desc">Application deployment</span>
										<span class="percent">65%</span>
									</span>
									<span class="progress progress-danger progress-striped active">
									<span style="width: 65%;" class="bar"></span>
									</span>
								</a>
							</li>
							<li>
								<a href="#">
								<span class="task">
									<span class="desc">Mobile app release</span>
									<span class="percent">98%</span>
								</span>
								<span class="progress progress-success">
									<span style="width: 98%;" class="bar"></span>
								</span>
								</a>
							</li>
							<li>
								<a href="#">
								<span class="task">
									<span class="desc">Database migration</span>
									<span class="percent">10%</span>
								</span>
								<span class="progress progress-warning progress-striped">
									<span style="width: 10%;" class="bar"></span>
								</span>
								</a>
							</li>
							<li>
								<a href="#">
								<span class="task">
									<span class="desc">Web server upgrade</span>
									<span class="percent">58%</span>
								</span>
								<span class="progress progress-info">
									<span style="width: 58%;" class="bar"></span>
								</span>
								</a>
							</li>
							<li>
								<a href="#">
								<span class="task">
								<span class="desc">Mobile development</span>
								<span class="percent">85%</span>
								</span>
								<span class="progress progress-success">
								<span style="width: 85%;" class="bar"></span>
								</span>
								</a>
							</li>
							<li class="external">
								<a href="#">See all tasks <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>
					<!-- END TODO DROPDOWN -->

					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img alt="" src="/PHPCMS/Public/Admin/media/image/avatar1_small.jpg" />
						<span class="username"><?php echo ((isset($user["username"]) && ($user["username"] !== ""))?($user["username"]):'魏巍'); ?></span>
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="extra_profile.html"><i class="icon-user"></i> 我的工程</a></li>
							<li><a href="page_calendar.html"><i class="icon-calendar"></i> My Calendar</a></li>
							<li><a href="inbox.html"><i class="icon-envelope"></i> My Inbox(3)</a></li>
							<li><a href="#"><i class="icon-tasks"></i> My Tasks</a></li>
							<li class="divider"></li>
							<li><a href="extra_lock.html"><i class="icon-lock"></i> Lock Screen</a></li>
							<li><a href="<?php echo U('Public/logout');?>"><i class="icon-key"></i>退出</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU --> 
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        
			<ul class="page-sidebar-menu">
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<form class="sidebar-search">
						<div class="input-box">
							<a href="javascript:;" class="remove"></a>
							<input type="text" placeholder="搜索..." />
							<input type="button" class="submit" value=" " />
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<li class="<?php if(($control) == "Index"): ?>start active<?php endif; ?>">
					<a href="<?php echo U('Index/index');?>">
						<i class="icon-home"></i> 
						<span class="title">Dashboard</span>
						<span class="selected"></span>
					</a>
				</li>				
				<?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$volt): $mod = ($i % 2 );++$i;?><li class="nav">
						<a href="javascript:;">
							<i class="icon-folder-open"></i> 
							<span class="title"><?php echo ($volt["name"]); ?></span>
							<span class="arrow"></span>
						</a>
						<?php if(!empty($volt["child"])): ?><ul class="sub-menu">
									<?php if(is_array($volt["child"])): $i = 0; $__LIST__ = $volt["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$volt1): $mod = ($i % 2 );++$i; if(!empty($volt1["child"])): ?><ul class="sub-menu">
												<li  class="nav-item">
													<a href="javascript:;">
														<?php if(!empty($volt1["ico"])): ?><i class="<?php echo ($volt1["ico"]); ?>"></i>
															<?php else: ?>
															<i class="icon-folder-open"></i><?php endif; ?>
														<span class="title"><?php echo ($volt1["name"]); ?></span>
														<span class="arrow "></span>
													</a>
													<volost name="volt1.child" id="volt2">
														<li  class="nav-item-sub">
															<a href="#">
																<?php if(!empty($volt2["ico"])): ?><i class="<?php echo ($volt2["ico"]); ?>"></i>
																	<?php else: ?>
																	<i class="icon-folder-open"></i><?php endif; ?>
																<?php echo ($volt2["name"]); ?>
															</a>
														</li>
													</volost>
												</li>
											</ul>
											<?php else: ?>
											<li  class="nav-item">
												<a href="<?php echo ($rd); ?>/<?php echo ($volt["title"]); ?>/<?php echo ($volt1["title"]); ?>">
													<?php if(!empty($volt1["ico"])): ?><i class="<?php echo ($volt1["ico"]); ?>"></i>
														<?php else: ?>
														<i class="icon-folder-open"></i><?php endif; ?>
													<?php echo ($volt1["name"]); ?>
												</a>
											</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
								</ul>
							<?php else: ?>
								<li  class="nav">
									<a href="<?php echo ($uri); ?>/<?php echo ($volt["title"]); ?>">
										<?php if(!empty($volt["ico"])): ?><i class="<?php echo ($volt["ico"]); ?>"></i>
											<?php else: ?>
											<i class="icon-folder-open"></i><?php endif; ?>
										<?php echo ($volt["name"]); ?>
									</a>
								</li><?php endif; ?>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>	
				<li class="last ">
					<a href="#charts.html">
						<i class="icon-bar-chart"></i> 
						<span class="title">Visual Charts</span>
					</a>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>		
		
    <!-- END SIDEBAR -->
    <!-- BEGIN PAGE -->
    <div class="page-content fill-content">
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                        Dashboard <small>statistics and more</small>
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="<?php echo U('Index/index');?>">首页</a>
                            <i class="icon-angle-right"></i>
                        </li>
                        <?php if(!empty($breadcrumb)): echo ($breadcrumb); ?>
                            <?php else: ?>
                            <li><a href="#">Dashboard</a></li><?php endif; ?>

                        <li class="pull-right no-text-shadow">
                            <div id="dashboard-report-range" class="dashboard-date-range tooltips no-tooltip-on-touch-device responsive" data-tablet="" data-desktop="tooltips" data-placement="top" data-original-title="Change dashboard date range">
                                <i class="icon-calendar"></i>
                                <span></span>
                                <i class="icon-angle-down"></i>
                            </div>
                        </li>
                    </ul>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
	<div class="footer">
		<div class="footer-inner">
			<?php echo ((isset($copyright) && ($copyright !== ""))?($copyright):'2013 &copy; Metronic by keenthemes.'); ?>
		</div>
		<div class="footer-tools">
			<span class="go-top">
				<i class="icon-angle-up"></i>
			</span>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->

	<script src="/PHPCMS/Public/Admin/media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="/PHPCMS/Public/Admin/media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
	<script src="/PHPCMS/Public/Admin/media/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="/PHPCMS/Public/Admin/media/js/app.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL SCRIPTS -->  
	<script type="text/javascript">
		$(function(){
			App.init(); // initlayout and core plugins
			$u = window.location.pathname;
			$u = $u.replace('<?php echo ($rd); ?>/','').split('/');
			$r = $controller+"/"+$action;

            $('li.nav-item').each(function(){
                $this = $(this);
                $c = $this.children('a').attr('href');
                if($c.indexOf($r) > 0){
                    $this.addClass('active');
                    $p = $this.parent('ul');
                    $p.show();
                    //$p.parent('li').addClass('open');
                    $p.parent('li').addClass('start active open');
                }
            });
		});
	</script>
	<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
</html>