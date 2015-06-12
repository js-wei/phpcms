<?php
return array(

	//资源列表
	'TMPL_PARSE_STRING'=>array(
		'__PUBLIC__'=> MODULE_PATH.'Public',
		'__JS__'=> __ROOT__.'/Public/'.MODULE_NAME.'/scripts',
        '__PLUG__'=> __ROOT__.'/Public/'.MODULE_NAME.'/plug',
		'__CSS__'=>__ROOT__.'/Public/'.MODULE_NAME.'/styles',
		'__IMAGES__'=> __ROOT__.'/Public/'.MODULE_NAME.'/images',
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__METRONIC_CSS__'=> __ROOT__.'/Public/'.MODULE_NAME.'/media/css',
        '__METRONIC_JS__'=> __ROOT__.'/Public/'.MODULE_NAME.'/media/js',
        '__METRONIC_IMG__'=> __ROOT__.'/Public/'.MODULE_NAME.'/media/image',
	),
    //SESSION前缀
    'SESSION_PREFIX'=>'Admin',
	//伪静态后缀
	'URL_HTML_SUFFIX'=>'',
	//默认分页
	'PAGE_SIZE'=>10,
);