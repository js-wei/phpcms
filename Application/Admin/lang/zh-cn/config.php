<?php
/**
 * Created by PhpStorm.
 * User: 魏巍
 * Date: 2015/6/9
 * Time: 16:23
 */
return array(

    //网站基本设置
    'site_title'=>'网站标题',
    'site_description'=>'网站描述',
    'site_keyword'=>'网站关键字',
    'site_off'=>'关闭站点',
    'site_icp'=>'网站备案号',
    'site_title_tip'=>'网站标题前台显示标题',
    'site_off_tip'=>'站点关闭后其他用户不能访问，管理员可以正常访问',
    'site_description_tip'=>'网站搜索引擎描述',
    'site_keyword_tip'=>'网站搜索引擎关键字',
    'site_icp_tip'=>'设置在网站底部显示的备案号，如“沪ICP备12007941号-2',
    'off'=>'关闭',
    'on'=>'开启',

    //网站文档设置
    'document'=>'文档推荐位',
    'document_tip'=>'文档推荐位，推荐到多个位置KEY值相加即可',
    'document_list_comment'=>'列表页推荐',
    'document_channel_comment'=>'频道页推荐',
    'document_hone_comment'=>'网站首页推荐',
    'document_show'=>'文档可见性',
    'document_show_tip'=>'文章可见性仅影响前台显示，后台不收影响',
    'document_show_item0'=>'所有人可见',
    'document_show_item1'=>'仅注册会员可见',
    'document_show_item2'=>'仅管理员可见',
    'draft'=>'是否开启草稿功能',
    'draft_tip'=>'新增文章时的草稿功能配置',
    'draft_on'=>'开启草稿功能',
    'draft_off'=>'关闭草稿功能',
    'auto_save'=>'自动保存草稿时间',
    'auto_save_tip'=>'自动保存草稿的时间间隔，单位：秒',
    'admin_page_size'=>'后台每页记录数',
    'admin_page_size_tip'=>'后台数据每页显示记录数',

    //用户配置
    'register'=>'是否允许用户注册',
    'register_tip'=>'是否开放用户注册',
    'register_on'=>'开放注册',
    'register_off'=>'关闭注册',

    //系统设置配置
    'data_backup'=>'数据库备份根路径',
    'data_backup_tip'=>'路径必须以 / 结尾',
    'data_backup_size'=>'数据库备份卷大小',
    'data_backup_size_tip'=>'该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M',
    'zip'=>'数据库备份文件是否启用压缩',
    'zip_tip'=>'压缩备份文件需要PHP环境支持gzopen,gzwrite函数',
    'zip_on'=>'使用压缩',
    'zip_off'=>'不使用压缩',
    'zip_level'=>'数据库备份文件压缩级别',
    'zip_level_tip'=>'数据库备份文件的压缩级别，该配置在开启压缩时生效',
    'zip_level_item0'=>'普通',
    'zip_level_item1'=>'一般',
    'zip_level_item2'=>'最高',

);