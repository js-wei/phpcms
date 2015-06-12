<?php
namespace Home\Model;

class UserModel extends \Think\Model{
	//自定义表前缀,没有前缀，则可以设置tablePrefix为空字符串
	protected $tablePrefix = 'think_';
	//指定操作的数据表,trueTableName需要完整的表名定义
	protected $trueTableName = 'user';
	//指定操作的数据库
	protected $dbName = 'think';
	//插入字段
    protected $insertFields = array('account','password','nickname','email');
    //更新字段
    protected $updateFields = array('nickname','email');
    //定义数据表字段的名称,避免IO加载的效率开销
    protected $fields = array('id', 'account', 'email', 'age');
    //指定表主键
    protected $pk     = 'id';
    //定义字段的类型,用于某些验证环节
  	protected $fields = array('id', 'account', 'email', 'age',
        '_type'=>array('id'=>'bigint','account'=>'varchar','email'=>'varchar','age'=>'int')
    );
  	//自动验证,验证没有通过 输出错误提示信息:exit($User->getError());
    protected $_validate = array(
     	array('verify','require','验证码必须！'), 							//默认情况下用正则进行验证
     	array('account','','帐号名称已经存在！',0,'unique',1), 				// 在新增的时候验证name字段是否唯一
     	array('age',array(1,2,3),'值的范围不正确！',2,'in'), 				// 当值不为空的时候判断是否在一个范围内
     	array('repassword','password','确认密码不正确',0,'confirm'), 		// 验证确认密码是否和密码一致
     	//array('password','checkPwd','密码格式不正确',0,'function'), 		// 自定义函数验证密码格式
    );
    //自动完成
    protected $_auto = array ( 
        array('status','1'，1),  								// 新增的时候把status字段设置为1
        array('password','md5',3,'function') , 					//对password字段在新增和编辑的时候使md5函数处理
        array('account','getName',3,'callback'), 				// 对name字段在新增和编辑的时候回调getName方法
        array('update_time','time',2,'function'),				// 对update_time字段在更新的时候写入当前时间戳
    );
    //关联模型
    protected $_link = array(
        'Profile'=>array(
            'mapping_type'      => self::HAS_ONE,				//关联关系:一对一关联 ：ONE_TO_ONE，包括HAS_ONE 和 BELONGS_TO;
            													//一对多关联 ：ONE_TO_MANY，包括HAS_MANY 和 BELONGS_TO
            													//多对多关联 ：MANY_TO_MANY
            'class_name'        => 'Profile',					//要关联的模型类名
           	'foreign_key'   	=> 'userId',					//关联的外键名称
    		'mapping_name'  	=> 'dept',						//关联的映射名称，用于获取数据用
    		'condition'			=>'', 							//关联条件
    		'mapping_fields'	=>'',							//关联的字段
    		'mapping_order' 	=> 'create_time desc',			//关联排序条件
    		'mapping_limit'		=>5,							//获取的条数
        ),
    );
 }
