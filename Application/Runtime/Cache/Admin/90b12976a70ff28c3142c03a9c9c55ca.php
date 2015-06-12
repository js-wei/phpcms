<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title><?php echo ((isset($$config["title"]) && ($$config["title"] !== ""))?($$config["title"]):'首页'); ?>_PHPCMS内容管理系统</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="/phpcms/Public/Admin/media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/phpcms/Public/Admin/media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="/phpcms/Public/Admin/media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="/phpcms/Public/Admin/media/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="/phpcms/Public/Admin/media/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/phpcms/Public/Admin/media/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="/phpcms/Public/Admin/media/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="/phpcms/Public/Admin/media/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" href="/phpcms/Public/static/common.css" />
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="/phpcms/Public/Admin/media/image/favicon.ico" />
    <!--BEGIN JQUERY -->
    <script src="/phpcms/Public/Admin/media/js/jquery-1.10.1.min.js" type="text/javascript"></script>
    <!--END JQUERY  -->
	<script type="text/javascript">
		$self='/phpcms/Admin/Column/index';
		$url='/phpcms/Admin/Column';
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
				<img src="/phpcms/Public/Admin/media/image/logo.png" alt="logo"/>
				</a>
				<!-- END LOGO -->
				
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
					<img src="/phpcms/Public/Admin/media/image/menu-toggler.png" alt="" />
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->            

				<!-- BEGIN TOP NAVIGATION MENU -->              
				<ul class="nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->   
					<li class="dropdown" id="header_notification_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-warning-sign"></i>
							<span class="badge">1</span>
						</a>
						<ul class="dropdown-menu extended notification">
							<li>
								<p>您有 1个新通知</p>
							</li>
							<li>
								<a href="#">
								<span class="label label-success"><i class="icon-plus"></i></span>
								新用户注册. 
								<span class="time">刚刚</span>
								</a>
							</li>
							<li class="external">
								<a href="#">查看更多消息<i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN INBOX DROPDOWN -->
					<li class="dropdown" id="header_inbox_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-envelope"></i>
							<span class="badge">1</span>
						</a>
						<ul class="dropdown-menu extended inbox">
							<li>
								<p>您有1个新信息</p>
							</li>
							<li>
								<a href="inbox.html?a=view">
								<span class="photo"><img src="/phpcms/Public/Admin/media/image/avatar2.jpg" alt="" /></span>
								<span class="subject">
									<span class="from">Lisa Wong</span>
									<span class="time">Just Now</span>
								</span>
								<span class="message">
									Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh...
								</span>
								</a>
							</li>
							<li class="external">
								<a href="inbox.html">查看更多留言 <i class="m-icon-swapright"></i></a>
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
                    <li>
                        <div class="btn-group">
                            <a class="btn purple" href="#" data-toggle="dropdown">
                                <i class="icon-cog"></i> 语言
                                <i class="icon-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu" id="change-lang">
                                <li><a href="zh-cn">简体中文</a></li>
                                <li><a href="zh-tw">繁体中文</a></li>
                                <li><a href="en-us">English</a></li>
                            </ul>
                        </div>
                    </li>
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img alt="" src="/phpcms/Public/Admin/media/image/avatar1_small.jpg" />
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
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" href="/phpcms/Public/Admin/media/css/DT_bootstrap.css" />
<!-- END PAGE LEVEL STYLES -->
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
					<input type="button" class="submit" value="" />
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
					<!--<i class="icon-folder-open"></i> -->
					<!--<span class="title"><?php echo ($volt["name"]); ?></span>-->
                    <?php if(!empty($volt["ico"])): ?><i class="<?php echo ($volt["ico"]); ?>"></i>
                        <?php else: ?>
                        <i class="icon-folder-open"></i><?php endif; ?>
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
                            <a href="<?php echo U('Index/index');?>"><?php echo (L("home")); ?></a>
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
            <!--BEGIN CONTAINER -->
            <!--BEGIN SEARCH -->
            <div class="alert-info alert-error">
                <button class="close alert-btn"></button>
                <span id="alert-info-item"></span>
            </div>
            <div class="clear margin10"></div>
            <script type="text/javascript" src="/phpcms/Public/Admin/plug/My97DatePicker/WdatePicker.js"></script>
            <script type="text/javascript" src="/phpcms/Public/Admin/scripts/jquery.form.js"></script>
            <script type="text/javascript">
                $(function(){
                    $('#search-submit').click(function(){
                        $('#form-search').submit();
                    });
                });
            </script>
            <div class="row-fluid">
                <div class="span12">
                    <div class="span6">
                        <a href="javascript:void(0);" class="btn grey" id="btn-enable" data-role="enable"><?php echo (L("enable")); ?></a>
                        <a href="javascript:void(0);" class="btn grey" id="btn-forbidden" data-role="forbidden"><?php echo (L("forbidden")); ?></a>
                        <a href="javascript:void(0);" class="btn grey" id="btn-delete" data-role="delete"><?php echo (L("delete")); ?></a>
                    </div>
                    <form action="/phpcms/Admin/Column/search"  method="get" id="form-search">
                        <div class="span3" style="text-align:right;">
                            <select name="status" style="width:75px;height:35px;">
                                <option value="-1"><?php echo (L("all")); ?></option>
                                <option value="0" <?php if(($search["status"]) == "0"): ?>selected<?php endif; ?>><?php echo (L("enable")); ?></option>
                                <option value="1" <?php if(($search["status"]) == "1"): ?>selected<?php endif; ?>><?php echo (L("forbidden")); ?></option>
                            </select>
                            <div class="search-key" style="float:right;">
                                <input type="text" name="name" value="<?php echo ($search["name"]); ?>" placeholder="<?php echo (L("keyword")); ?>"  style="width:160px;;height:25px;">
                            </div>
                        </div>
                        <div class="span3" style="text-align:left;margin:0px;padding:0px;margin-left:-10px;width:315px;position:relative;">
                            <div class="search-button" style="margin-left:20px;">
                                <botton id="search-submit"  class="btn grey margin-10" ><?php echo (L("search")); ?></botton>
                                <botton id="search-date"  class="btn blue margin-10" i="0"><?php echo (L("senior")); ?></botton>
                            </div>
                            <div class="search-time hide" style="left:-10px;position:relative;width:450px;">
                                <div class="control-group">
                                    <div class="controls pull-left">
                                        <input class="Wdate" value="<?php echo ($data["from"]); ?>" type="text" id="start" name="from" onfocus="WdatePicker()" style="width:100px;height:25px;"/> To <input value="<?php echo ($data["to"]); ?>" class="Wdate" type="text" name="to" id="end" onfocus="WdatePicker()" style="width:100px;height:25px;"/>
                                        <a href="javascript:void(0);" id="ok-date"><?php echo (L("confirm_ok")); ?></a>
                                        <a href="javascript:void(0);" id="clear-date"><?php echo (L("clear")); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="clear"></div>
            <hr class="divider"/>
            <div class="row-fluid">
                <div class="span12">
                    <div class="btn-group">
                        <a id="sample_editable_1_new" class="btn green" href="<?php echo U('add');?>">
                            <?php echo (L("add")); ?><i class="icon-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <hr class="divider"/>
            <!--END SEARCH -->
            <!--BEGIN DATA CONTAINER -->
            <div class="row-fluid">
                <div class="span12">
                    <table class="table table-striped table-bordered table-hover dataTable" id="sample_2" aria-describedby="sample_1_info">
                        <thead>
                        <tr role="row" id="dis-sort-simple">
                            <th style="width:24px;" class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="">
                                <div class="checker">
                                    <span><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"></span>
                                </div>
                            </th>
                            <th class="hidden-480" style="width:70px;"><?php echo (L("n")); ?></th>
                            <th class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" style="width:250px;"><?php echo (L("title")); ?></th>
                            <th class="hidden-480 sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 220px;"><?php echo (L("name")); ?></th>
                            <th class="hidden-480 sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1"  style="width: 220px;"><?php echo (L("description")); ?></th>
                            <th class="hidden-480 sorting_disabled" role="columnheader" rowspan="1" colspan="1"  style="width: 237px;"><?php echo (L("ico")); ?></th>
                            <th class="hidden-480" style="width:50px;"><?php echo (L("show")); ?></th>
                            <th class="hidden-480" style="width:50px;"><?php echo (L("status")); ?></th>
                            <th class="hidden-480" style="width:250px;"><?php echo (L("add_time")); ?></th>
                            <th class="hidden-480 sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="" style="width:450px;"></th>
                        </tr>
                        </thead>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="gradeX <?php if($key%2==0){echo 'odd';}else{echo 'even';} ?>">
                                <td class=" sorting_1"><div class="checker"><span><input type="checkbox" class="checkboxes" value="<?php echo ($vo["id"]); ?>"></span></div></td>
                                <td><?php echo ($vo["id"]); ?></td>
                                <td class="" style="padding-left:<?php echo ($vo['level']*10); ?>px;"><?php echo ($vo["html"]); echo ($vo["title"]); ?></td>
                                <td class="hidden-480 "><?php echo ($vo["name"]); ?></td>
                                <td class="hidden-480 "><?php echo ($vo["info"]); ?></td>
                                <td class="hidden-480 "><?php echo ($vo["ico"]); ?></td>
                                <td class="hidden-480 text-center"><?php if(($vo["show"]) == "1"): ?><label class="label label-error"><?php echo (L("un_show")); ?></label><?php else: ?><label class="label label-success"><?php echo (L("show")); ?></label><?php endif; ?></td>
                                <td class="hidden-480 "><?php if(($vo["status"]) == "1"): ?><label class="label label-error"><?php echo (L("forbidden")); ?></label><?php else: ?><label class="label label-success"><?php echo (L("enable")); ?></label><?php endif; ?></td>
                                <td class="hidden-480"><?php echo (date('Y-m-d h:i:s',$vo["date"])); ?></td>
                                <td class="text text-center">
                                    <a href="/phpcms/Admin/Column/check?id=<?php echo ($vo["id"]); ?>" class="btn mini"><?php echo (L("check")); ?></a>
                                    <a href="/phpcms/Admin/Column/edit?id=<?php echo ($vo["id"]); ?>" class="btn blue mini"><?php echo (L("edit")); ?></a>
                                    <?php if(($vo["status"]) == "0"): ?><a href="/phpcms/Admin/Column/status?id=<?php echo ($vo["id"]); ?>&t=forbidden&p=<?php echo ($_GET['p']); ?>&ajax=0" class="btn black mini"><?php echo (L("forbidden")); ?></a>
                                        <?php else: ?>
                                        <a href="/phpcms/Admin/Column/status?id=<?php echo ($vo["id"]); ?>&t=enable&p=<?php echo ($_GET['p']); ?>&ajax=0" class="btn yellow mini"><?php echo (L("enable")); ?></a><?php endif; ?>
                                    <a href="javascript:void(0);" data-role="/phpcms/Admin/Column/status?id=<?php echo ($vo["id"]); ?>&t=delete&p=<?php echo ($_GET['p']); ?>&ajax=0" class="btn red mini btn-del"><?php echo (L("delete")); ?></a>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="pagination">
                                <?php echo ($page); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END DATA CONTAINER -->
            <!--END CONTAINER -->
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->
</div>
<script type="text/javascript">
    $(function(){
        $checkboxes = $('.checkboxes');
        $('.group-checkable').click(function(){
            $this = $(this);
            if($this.attr('checked')=='checked'){
                $this.parent('span').addClass('checked');
                $checkboxes.each(function(){
                    $(this).attr('checked','checked');
                    $(this).parent('span').addClass('checked');
                });
            }else{
                $this.parent('span').removeClass('checked');
                $checkboxes.each(function(){
                    $(this).removeAttr('checked');
                    $(this).parent('span').removeClass('checked');
                });
            }
        });
        $checkboxes.click(function(){
            if($(this).attr('checked')=='checked'){
                $(this).attr('checked','checked');
                $(this).parent('span').addClass('checked');
            }else{
                $(this).removeAttr('checked');
                $(this).parent('span').removeClass('checked');
            }
        });
        $('#btn-enable,#btn-forbidden,#btn-delete').click(function(){
            $t = $(this).attr('data-role');
            $q='';
            $('.checkboxes').each(function(){
                if($(this).attr('checked')=='checked'){
                    $q += ','+$(this).val();
                }
            });
            $q = $q.substr(1);
            if($q!=''){
                $.post('/phpcms/Admin/Column/status',{k:$q,t:$t},function(data){
                    if(data.status==0){
                        window.location.reload();
                    }else{
                        $('#alert-info-item').text('<?php echo (L("fail")); ?>');
                        $('.alert-info').show();
                    }
                });
            }else{
                $('#alert-info-item').text('<?php echo (L("select_option")); ?>');
                $('.alert-info').show();
            }
        });

        $('.alert-btn').click(function(){
            $(this).parent('.alert-error').hide();
        });

        $('.btn-del').click(function(e){
            e.preventDefault();
            if(confirm("<?php echo (L("confirm")); ?>")){
                window.location.href=$(this).attr('data-role');
            }
        });
        $('#search-date').click(function(e){
            e.preventDefault();
            $i = $(this).attr('i');
            if($i=='0'){
                $('.search-time').show();
                $(this).attr('i',1);
            }else{
                $('.search-time').hide();
                $(this).attr('i',0);
            }
        });
        $('#clear-date').click(function(){
            $('#start,#end').val('');
        });
        $('#ok-date').click(function(){
            $('.search-time').hide();
            $(this).attr('i',1);
        });
    });
</script>
<script type="text/javascript" src="/phpcms/Public/Admin/media/js/select2.min.js"></script>
<script type="text/javascript" src="/phpcms/Public/Admin/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="/phpcms/Public/Admin/media/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="/phpcms/Public/Admin/media/js/table-managed.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        TableManaged.init();
        $('#sample_2_wrapper').children('.row-fluid').first().remove();
        $('#sample_2_wrapper').children('.row-fluid').last().remove();
        $('#sample_1_wrapper').children('.row-fluid').first().remove();
        $('#sample_1_wrapper').children('.row-fluid').last().remove();
    });
</script>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
	<div class="footer">
		<div class="footer-inner">
			<?php echo ((isset($$config["copyright"]) && ($$config["copyright"] !== ""))?($$config["copyright"]):'2013 &copy; Metronic by keenthemes.'); ?>
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
	<script src="/phpcms/Public/Admin/media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="/phpcms/Public/Admin/media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
	<script src="/phpcms/Public/Admin/media/js/bootstrap.min.js" type="text/javascript"></script>
    <!--[if lt IE 9]>
    <script src="/phpcms/Public/Admin/media/js/excanvas.min.js"></script>
    <script src="/phpcms/Public/Admin/media/js/respond.min.js"></script>
    <![endif]-->
    <script src="/phpcms/Public/Admin/media/js/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="/phpcms/Public/Admin/media/js/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="/phpcms/Public/Admin/media/js/jquery.cookie.min.js" type="text/javascript"></script>
    <script src="/phpcms/Public/Admin/media/js/jquery.uniform.min.js" type="text/javascript" ></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="/phpcms/Public/Admin/media/js/app.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL SCRIPTS -->

	<script type="text/javascript">
		$(function(){
			App.init(); // init layout and core plugins
			$u = window.location.pathname;
			$u = $u.replace('<?php echo ($rd); ?>/','').split('/');
			$r = $controller+"/"+$action;
            //更改高亮地址
            if($action=='add' || $action=='del' || $action=='edit' || $action=='check'|| $action=='search'){
                $r = $controller+"/index";
            }
            //循环高亮
            $('li.nav-item').each(function(e){
                $this = $(this);
                $c = $this.children('a').attr('href');
                if($c.indexOf($r) > 0){
                    $this.addClass('active');
                    $p = $this.parent('ul');
                    $p.show();
                    $p.parent('li').addClass('start active open');
                }
            });
            //退出登陆
            $(document).keypress(function(e){
            	$code = e.keyCode | e.which;
                if($code==32){
                    window.location.href='<?php echo U("Public/logout");?>';
                    return false;
                }
            });
            //提交搜索
            $(document).keypress(function(e){
                $code = e.keyCode | e.which;
                if($code==13){
                    $('#form-search').submit();
                    return false;
                }
            });
            $('#change-lang li').click(function(e){
                e.preventDefault();
                $uri = $(this).children('a').attr('href');
                $.post('/phpcms/Admin/Column/index',{l:$uri},function(d){
                    window.location.reload();
                });
            });
		});
        //获取url参数
        function GetRequest() {
            var url = location.search; //获取url中"?"符后的字串
            var theRequest = new Object();
            if (url.indexOf("?") != -1) {
                var str = url.substr(1);
                strs = str.split("&");
                for(var i = 0; i < strs.length; i ++) {
                    theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
                }
            }
            return theRequest;
        }

        /**
         * 获取url参数
         * @param name   url地址
         * @returns {*} 获取参数
         */
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;
        }

	</script>
	<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
</html>