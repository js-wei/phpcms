<?php
return array(
	//数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'phpcms', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => 'root', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'think_', // 数据库表前缀 
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  ture, // 调试模式
	
	//数据库配置1
	//在Model中使用配置文件中的数据库配置1 protected $connection = 'DB_CONFIG2';
	//在Model中直接切换数据库连接 M('User','other_','mysql://root:1234@localhost/demo#utf8');
	//在MOdel中实例化中使用DB_CONFIG2配置文件 M('User','other_','DB_CONFIG2');
	/*'DB_CONFIG1' => array(
		'db_type'  		=> 'mysql',
		'db_user'  		=> 'root',
		'db_pwd'   		=> '1234',
		'db_host'  		=> 'localhost',
		'db_port'  		=> '3306',
		'db_name'  		=> 'thinkphp',
		'db_charset'	=>    'utf8',
	),
	//数据库配置2
	'DB_CONFIG2' => 'mysql://root:1234@localhost:3306/thinkphp#utf8',
	// 关闭字段缓存 调试模式下面由于考虑到数据结构可能会经常变动，所以默认是关闭字段缓存的。
	'DB_FIELDS_CACHE'=>false,*/

);